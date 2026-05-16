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
     * Midtrans akan melakukan POST request ke endpoint ini setiap kali
     * status transaksi berubah (paid, failed, expired, dll).
     *
     * PENTING: Route ini HARUS dikecualikan dari CSRF verification
     * (tambahkan ke $except di VerifyCsrfToken middleware).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleNotification(Request $request): JsonResponse
    {
        try {
            // Verifikasi notifikasi menggunakan Midtrans SDK
            // SDK otomatis memvalidasi signature key dari Midtrans
            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $orderId           = $notification->order_id; // UUID order kita

            // Cari order di database berdasarkan UUID
            $order = Order::findOrFail($orderId);

            // ── Petakan status Midtrans ke status internal SkillKul ──────
            // Referensi: https://docs.midtrans.com/docs/getting-notified
            if ($transactionStatus === 'capture') {
                // Pembayaran kartu kredit berhasil di-capture
                $newStatus = ($fraudStatus === 'accept') ? 'paid' : 'fraud';

            } elseif ($transactionStatus === 'settlement') {
                // Pembayaran berhasil (transfer bank, e-wallet, dll)
                $newStatus = 'paid';

            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                // Pembayaran dibatalkan / ditolak / kedaluwarsa
                $newStatus = 'cancelled';

            } elseif ($transactionStatus === 'pending') {
                // Menunggu pembayaran dari customer
                $newStatus = 'waiting_payment';

            } else {
                // Status tidak dikenali — biarkan apa adanya
                $newStatus = $order->status;
            }

            // Simpan ID transaksi Midtrans & perbarui status order
            $order->update([
                'midtrans_transaction_id' => $notification->transaction_id,
                'status'                  => $newStatus,
            ]);

            Log::info('Notifikasi Midtrans diterima.', [
                'order_id'          => $orderId,
                'transaction_status'=> $transactionStatus,
                'new_order_status'  => $newStatus,
            ]);

            return response()->json(['success' => true, 'message' => 'Notifikasi diproses.']);

        } catch (\Exception $e) {
            Log::error('Gagal memproses notifikasi Midtrans.', [
                'error' => $e->getMessage(),
                'body'  => $request->all(),
            ]);

            return response()->json(['success' => false, 'message' => 'Gagal memproses notifikasi.'], 500);
        }
    }
}
