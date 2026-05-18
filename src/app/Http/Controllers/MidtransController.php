<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * MidtransController
 *
 * Menangani semua interaksi dengan Midtrans Snap API:
 * - Generate Snap Token untuk halaman pembayaran
 * - Menerima notifikasi webhook dari Midtrans (payment notification)
 */
class MidtransController extends Controller
{
    /**
     * Inisialisasi konfigurasi Midtrans dari config/midtrans.php.
     *
     * Dipanggil sekali saat controller di-instantiate agar setiap
     * method di controller ini sudah siap menggunakan Midtrans SDK.
     */
    public function __construct()
    {
        // Set konfigurasi global Midtrans SDK
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$clientKey    = config('midtrans.client_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Generate Midtrans Snap Token untuk order tertentu.
     *
     * Alur:
     * 1. Ambil order dari DB (UUID sebagai primary key)
     * 2. Susun parameter transaksi sesuai format Midtrans
     * 3. Panggil Snap::getSnapToken() dari Midtrans SDK
     * 4. Simpan snap_token ke kolom orders.midtrans_snap_token
     * 5. Kembalikan snap_token sebagai JSON response
     *
     * @param  string  $order_id  UUID dari order (bukan integer)
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSnapToken(string $order_id): JsonResponse
    {
        try {
            // ── 1. Ambil order beserta relasi client ─────────────────────
            $order = Order::with('client')->findOrFail($order_id);

            // Pastikan hanya client pemilik order yang dapat meminta token
            if (auth()->id() !== $order->client_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Anda bukan pemilik order ini.',
                ], 403);
            }

            // Pastikan order masih dalam status yang bisa dibayar
            if (! in_array($order->status, ['pending', 'waiting_payment'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ini tidak dapat diproses pembayarannya (status: ' . $order->status . ').',
                ], 422);
            }

            // Jika snap_token sudah ada & order belum expired, kembalikan yang lama
            // (hindari membuat transaksi duplikat di Midtrans)
            if (! empty($order->midtrans_snap_token)) {
                return response()->json([
                    'success'    => true,
                    'snap_token' => $order->midtrans_snap_token,
                    'message'    => 'Snap token sudah tersedia.',
                ]);
            }

            // ── 2. Susun parameter transaksi Midtrans ────────────────────
            $params = [
                // Detail transaksi: order_id menggunakan UUID, gross_amount harus integer
                'transaction_details' => [
                    'order_id'     => $order->id, // UUID string, contoh: "550e8400-e29b-41d4-a716-446655440000"
                    'gross_amount' => (int) $order->total_price, // Midtrans hanya menerima integer (Rupiah)
                ],

                // Detail pelanggan (client yang memesan)
                'customer_details' => [
                    'first_name' => $order->client->name,
                    'email'      => $order->client->email,
                    // Tambahkan phone jika kolom tersedia di tabel users
                    // 'phone'   => $order->client->phone ?? '',
                ],

                // Daftar item yang dibeli
                'item_details' => [
                    [
                        'id'       => (string) $order->service_id,
                        'price'    => (int) $order->total_price,
                        'quantity' => 1,
                        'name'     => $order->service->title ?? 'Jasa SkillKul', // Nama jasa (max 50 karakter di Midtrans)
                    ],
                ],

                // Pengaturan tampilan Snap (opsional)
                'callbacks' => [
                    // URL redirect setelah pembayaran berhasil/gagal
                    'finish' => route('pesanan.detail', ['id' => $order->id]),
                ],
            ];

            // ── 3. Panggil Midtrans Snap API ─────────────────────────────
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // ── 4. Simpan snap_token ke database ─────────────────────────
            $order->update([
                'midtrans_snap_token' => $snapToken,
                'status'              => 'waiting_payment', // Update status order
            ]);

            // Log aktivitas untuk audit trail
            Log::info('Midtrans Snap Token berhasil dibuat.', [
                'order_id'   => $order->id,
                'client_id'  => $order->client_id,
                'amount'     => $order->total_price,
            ]);

            // ── 5. Kembalikan snap_token sebagai JSON ─────────────────────
            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'message'    => 'Snap token berhasil dibuat.',
            ]);

        } catch (\Midtrans\Exceptions\MidtransApiException $e) {
            // Error spesifik dari Midtrans API (misal: key salah, parameter invalid)
            Log::error('Midtrans API Error saat membuat Snap Token.', [
                'order_id' => $order_id,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke Midtrans: ' . $e->getMessage(),
            ], 502);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Order dengan UUID tersebut tidak ditemukan di database
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.',
            ], 404);

        } catch (\Exception $e) {
            // Error tak terduga lainnya
            Log::error('Error tidak terduga saat membuat Midtrans Snap Token.', [
                'order_id' => $order_id,
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Menerima dan memproses notifikasi webhook dari Midtrans.
     *
     * Midtrans melakukan HTTP POST ke endpoint ini setiap kali status transaksi berubah.
     * Alur:
     *  1. Baca payload JSON dari request body
     *  2. Verifikasi signature key secara manual dengan SHA512
     *  3. Petakan transaction_status Midtrans ke status internal SkillKul
     *  4. Update order secara atomic menggunakan DB::transaction()
     *  5. Return HTTP 200 agar Midtrans tidak mengirim ulang notifikasi
     *
     * PENTING: Route ini sudah dikecualikan dari CSRF di bootstrap/app.php.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleNotification(Request $request): JsonResponse
    {
        // ── 1. Baca payload JSON dari Midtrans ───────────────────────────
        $payload = $request->json()->all();

        // Log seluruh payload masuk untuk audit trail & debugging
        Log::info('[Midtrans] Notifikasi webhook diterima.', [
            'order_id'           => $payload['order_id']           ?? null,
            'transaction_status' => $payload['transaction_status'] ?? null,
            'fraud_status'       => $payload['fraud_status']       ?? null,
            'gross_amount'       => $payload['gross_amount']       ?? null,
            'status_code'        => $payload['status_code']        ?? null,
            'payment_type'       => $payload['payment_type']       ?? null,
        ]);

        // ── 2. Verifikasi Signature Key secara manual ────────────────────
        // Formula resmi Midtrans:
        //   SHA512(order_id + status_code + gross_amount + server_key)
        // Referensi: https://docs.midtrans.com/docs/verifying-data-and-signature
        $orderId      = $payload['order_id']           ?? '';
        $statusCode   = $payload['status_code']        ?? '';
        $grossAmount  = $payload['gross_amount']        ?? '';
        $receivedSign = $payload['signature_key']       ?? '';

        $expectedSign = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
        );

        // Tolak request jika signature tidak cocok (kemungkinan pemalsuan)
        if (! hash_equals($expectedSign, $receivedSign)) {
            Log::warning('[Midtrans] Signature tidak valid — kemungkinan request palsu.', [
                'order_id'       => $orderId,
                'received_sign'  => substr($receivedSign, 0, 16) . '...', // jangan log full hash
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Signature tidak valid.',
            ], 403);
        }

        // ── 3. Ambil order dari DB (edge case: order tidak ditemukan) ────
        $order = Order::find($orderId);

        if (! $order) {
            Log::error('[Midtrans] Order tidak ditemukan di database.', ['order_id' => $orderId]);

            // Tetap return 200 agar Midtrans tidak terus mengirim ulang
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.',
            ], 200);
        }

        // ── 4. Petakan status Midtrans → status internal SkillKul ────────
        // Referensi lengkap: https://docs.midtrans.com/docs/getting-notified
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status']       ?? '';
        $transactionId     = $payload['transaction_id']     ?? null;

        $newStatus = match(true) {

            // settlement: transfer bank / e-wallet berhasil dikonfirmasi
            $transactionStatus === 'settlement'
                => 'in_progress',

            // capture: kartu kredit berhasil di-capture, cek fraud status
            $transactionStatus === 'capture' && $fraudStatus === 'accept'
                => 'in_progress',

            // capture tapi terdeteksi fraud
            $transactionStatus === 'capture' && $fraudStatus === 'challenge'
                => 'waiting_payment', // tahan dulu, tunggu review manual Midtrans

            // expire / cancel / deny: pembayaran gagal/kedaluwarsa
            in_array($transactionStatus, ['expire', 'cancel', 'deny'])
                => 'canceled',

            // pending: menunggu pembayaran dari user (transfer belum masuk, dsb.)
            $transactionStatus === 'pending'
                => 'waiting_payment',

            // Status tidak dikenali — pertahankan status lama
            default => $order->status,
        };

        // ── 5. Update order secara atomic menggunakan DB::transaction() ──
        // Mencegah kondisi race condition jika ada notifikasi ganda dari Midtrans
        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($order, $newStatus, $transactionId) {

                // Lock row agar tidak ada proses lain yang mengubah bersamaan
                $order->lockForUpdate()->find($order->id);

                $order->update([
                    'status'                  => $newStatus,
                    'midtrans_transaction_id' => $transactionId,
                ]);
            });

            Log::info('[Midtrans] Status order berhasil diperbarui.', [
                'order_id'           => $orderId,
                'transaction_status' => $transactionStatus,
                'new_order_status'   => $newStatus,
                'transaction_id'     => $transactionId,
            ]);

            // Return 200 agar Midtrans tidak mengirim ulang notifikasi yang sama
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil diproses.',
            ], 200);

        } catch (\Exception $e) {
            Log::error('[Midtrans] Gagal update order di database.', [
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
            ]);

            // Return 500 agar Midtrans mencoba kirim notifikasi ulang
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui order.',
            ], 500);
        }
    }
}
