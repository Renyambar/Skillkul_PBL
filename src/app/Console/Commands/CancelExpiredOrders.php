<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\EscrowService;
use App\Notifications\DeadlineMissedNotification;
use App\Notifications\RefundGeneratedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * CancelExpiredOrders Command
 *
 * Membatalkan order yang melewati deadline tanpa freelancer submit hasil.
 *
 * Kondisi yang dicek:
 *  - status = 'in_progress'
 *  - deadline < now() (deadline sudah terlewati)
 *  - submitted_at IS NULL (freelancer belum submit hasil)
 *  - escrow_released_at IS NULL (guard: escrow belum diproses)
 *
 * Aksi yang dilakukan:
 *  1. Panggil EscrowService::refundToClient() → dana kembali ke client wallet
 *  2. Update order: status = 'cancelled', cancelled_at = now()
 *  3. Kirim DeadlineMissedNotification ke client dan freelancer
 *  4. Kirim RefundGeneratedNotification ke client
 *
 * Jadwal: setiap jam (lihat routes/console.php)
 *
 * Usage: php artisan orders:cancel-expired
 */
class CancelExpiredOrders extends Command
{
    protected $signature   = 'orders:cancel-expired';
    protected $description = 'Batalkan order yang melewati deadline tanpa freelancer submit hasil, dan refund escrow ke client.';

    public function __construct(protected EscrowService $escrowService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $now = now();

        // Ambil semua order yang deadline-nya terlewati tanpa hasil dikirim
        $orders = Order::with(['client', 'freelancer', 'service', 'escrow'])
            ->where('status', 'in_progress')
            ->whereNotNull('deadline')
            ->where('deadline', '<', $now)
            ->whereNull('submitted_at')        // belum submit hasil
            ->whereNull('escrow_released_at')  // escrow belum diproses (guard)
            ->get();

        if ($orders->isEmpty()) {
            $this->info('[CancelExpired] Tidak ada order yang perlu dibatalkan karena deadline.');
            return self::SUCCESS;
        }

        $cancelled = 0;

        foreach ($orders as $order) {
            try {
                DB::transaction(function () use ($order) {
                    // 1. Refund escrow ke client wallet (via EscrowService)
                    $this->escrowService->refundToClient($order, 'refund_deadline');

                    // 2. Update status order
                    $order->update([
                        'status'       => 'canceled',
                        'cancelled_at' => now(),
                        'escrow_released_at' => now(), // guard: sudah diproses
                    ]);

                    // 3. Notifikasi ke client: refund + deadline missed
                    $refundAmount = (float) ($order->escrow?->amount ?? $order->total_price);

                    $order->client->notify(
                        new RefundGeneratedNotification($order, $refundAmount)
                    );
                    $order->client->notify(
                        new DeadlineMissedNotification($order, 'client')
                    );

                    // 4. Notifikasi ke freelancer: deadline missed
                    $order->freelancer->notify(
                        new DeadlineMissedNotification($order, 'freelancer')
                    );
                });

                Log::info('[CancelExpired] Order berhasil dibatalkan karena deadline.', [
                    'order_id'      => $order->id,
                    'freelancer_id' => $order->freelancer_id,
                    'client_id'     => $order->client_id,
                    'deadline'      => $order->deadline?->toDateTimeString(),
                ]);

                $cancelled++;

            } catch (\Exception $e) {
                Log::error('[CancelExpired] Gagal membatalkan order.', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                    'trace'    => $e->getTraceAsString(),
                ]);
            }
        }

        $this->info("[CancelExpired] Selesai. {$cancelled} order berhasil dibatalkan dan direfund.");

        return self::SUCCESS;
    }
}
