<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Notifications\PaymentFailedNotification;
use App\Notifications\PaymentSuccessNotification;
use App\Services\EscrowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     */
    public function __construct(protected EscrowService $escrowService)
    {
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
     */
    public function getSnapToken(string $order_id): JsonResponse
    {
        try {
            // ── 1. Ambil order beserta relasi client & service ───────────
            $order = Order::with(['client', 'service'])->findOrFail($order_id);

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
            // Truncate service title ke 50 karakter (batas Midtrans)
            $serviceTitle = mb_substr($order->service->title ?? 'Jasa SkillKul', 0, 50);

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->id,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->client->name,
                    'email'      => $order->client->email,
                    'phone'      => $order->client->phone_number ?? '',
                ],
                'item_details' => [
                    [
                        'id'       => (string) $order->service_id,
                        'price'    => (int) $order->total_price,
                        'quantity' => 1,
                        'name'     => $serviceTitle,
                    ],
                ],
                'callbacks' => [
                    'finish' => route('pesanan.detail', ['id' => $order->id]),
                ],
            ];

            // ── 3. Panggil Midtrans Snap API ─────────────────────────────
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // ── 4. Simpan snap_token ke database ─────────────────────────
            $order->update([
                'midtrans_snap_token' => $snapToken,
                'status'              => 'waiting_payment',
            ]);

            Log::info('[Midtrans] Snap Token berhasil dibuat.', [
                'order_id'  => $order->id,
                'client_id' => $order->client_id,
                'amount'    => $order->total_price,
            ]);

            // ── 5. Kembalikan snap_token sebagai JSON ─────────────────────
            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'message'    => 'Snap token berhasil dibuat.',
            ]);

        } catch (\Midtrans\Exceptions\MidtransApiException $e) {
            Log::error('[Midtrans] API Error saat membuat Snap Token.', [
                'order_id' => $order_id,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke Midtrans: ' . $e->getMessage(),
            ], 502);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.',
            ], 404);

        } catch (\Exception $e) {
            Log::error('[Midtrans] Error tidak terduga saat membuat Snap Token.', [
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
     * Alur:
     *  1. Baca payload JSON dari request body
     *  2. Verifikasi signature key secara manual dengan SHA512
     *  3. Petakan transaction_status Midtrans ke status internal SkillKul
     *  4. Update order & buat record Payment secara atomic menggunakan DB::transaction()
     *  5. Return HTTP 200 agar Midtrans tidak mengirim ulang notifikasi
     *
     * PENTING: Route ini sudah dikecualikan dari CSRF di bootstrap/app.php.
     *
     * Status Flow yang benar:
     *   pending → waiting_payment → [paid → in_progress] (oleh freelancer accept)
     *   paid setelah freelancer konfirmasi → in_progress
     *   in_progress → delivered (freelancer kirim hasil)
     *   delivered → completed (client terima ATAU auto 48 jam)
     */
    public function handleNotification(Request $request): JsonResponse
    {
        // ── 1. Baca payload JSON dari Midtrans ───────────────────────────
        $payload = $request->json()->all();

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
        $orderId      = $payload['order_id']     ?? '';
        $statusCode   = $payload['status_code']  ?? '';
        $grossAmount  = $payload['gross_amount'] ?? '';
        $receivedSign = $payload['signature_key'] ?? '';

        $expectedSign = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
        );

        if (! hash_equals($expectedSign, $receivedSign)) {
            Log::warning('[Midtrans] Signature tidak valid — kemungkinan request palsu.', [
                'order_id'      => $orderId,
                'received_sign' => substr($receivedSign, 0, 16) . '...',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Signature tidak valid.',
            ], 403);
        }

        // ── 3. Ambil order dari DB ────────────────────────────────────────
        $order = Order::find($orderId);

        if (! $order) {
            Log::error('[Midtrans] Order tidak ditemukan di database.', ['order_id' => $orderId]);
            // Tetap return 200 agar Midtrans tidak terus mengirim ulang
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan.'], 200);
        }

        // ── 4. Petakan status Midtrans → status internal SkillKul ────────
        // Referensi: https://docs.midtrans.com/docs/getting-notified
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status']       ?? '';
        $transactionId     = $payload['transaction_id']     ?? null;
        $paymentType       = $payload['payment_type']       ?? null;

        // Status mapping yang benar:
        // settlement/capture(accept) → 'paid' (bukan in_progress!)
        // Transisi paid → in_progress terjadi ketika freelancer mulai mengerjakan
        $newStatus = match(true) {
            // Transfer bank / e-wallet dikonfirmasi oleh Midtrans
            $transactionStatus === 'settlement'
                => 'paid',

            // Kartu kredit di-capture, tidak ada fraud
            $transactionStatus === 'capture' && $fraudStatus === 'accept'
                => 'paid',

            // Kartu kredit terdeteksi fraud — tahan di waiting_payment
            $transactionStatus === 'capture' && $fraudStatus === 'challenge'
                => 'waiting_payment',

            // Pembayaran gagal / kedaluwarsa / ditolak
            in_array($transactionStatus, ['expire', 'cancel', 'deny'])
                => 'canceled',

            // Menunggu pembayaran dari user
            $transactionStatus === 'pending'
                => 'waiting_payment',

            // Status tidak dikenali — pertahankan status lama
            default => $order->status,
        };

        // ── 5. Update order & buat record Payment secara atomic ──────────
        try {
            DB::transaction(function () use ($order, $newStatus, $transactionId, $paymentType, $grossAmount, $payload, $transactionStatus) {

                // FIX: lockForUpdate() harus dipanggil pada query builder, bukan model instance
                // Cara yang benar: query builder → lockForUpdate() → first()
                $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->first();

                if (! $lockedOrder) {
                    return; // Order hilang saat proses — abaikan
                }

                // Update status order
                $lockedOrder->update([
                    'status'                  => $newStatus,
                    'midtrans_transaction_id' => $transactionId,
                ]);

                // Buat atau update record Payment untuk audit trail
                $payment = Payment::updateOrCreate(
                    ['midtrans_transaction_id' => $transactionId],
                    [
                        'order_id'                 => $lockedOrder->id,
                        'midtrans_order_id'        => $lockedOrder->id,
                        'payment_method'           => $paymentType,
                        'gross_amount'             => (float) $grossAmount,
                        'payment_status'           => $transactionStatus,
                        'paid_at'                  => in_array($transactionStatus, ['settlement', 'capture']) ? now() : null,
                        'raw_response'             => $payload,
                    ]
                );

                // ── BARU: Tahan dana escrow jika pembayaran berhasil ──────
                if ($newStatus === 'paid') {
                    $this->escrowService->holdFunds($lockedOrder, $payment);

                    // Notifikasi ke client: pembayaran berhasil
                    $lockedOrder->client->notify(
                        new PaymentSuccessNotification($lockedOrder->load(['service', 'client']))
                    );
                }

                // ── BARU: Notifikasi jika pembayaran gagal ────────────────
                if (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
                    $lockedOrder->client->notify(
                        new PaymentFailedNotification($lockedOrder->load('client'), $transactionStatus)
                    );
                }
            });

            Log::info('[Midtrans] Status order berhasil diperbarui.', [
                'order_id'           => $orderId,
                'transaction_status' => $transactionStatus,
                'new_order_status'   => $newStatus,
                'transaction_id'     => $transactionId,
            ]);

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
