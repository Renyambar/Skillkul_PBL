<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\EscrowService;
use App\Notifications\AutoCompleteNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * AutoCompleteOrders Command
 *
 * Menjalankan logika auto-complete: jika freelancer sudah mengirim hasil
 * ('delivered') dan client tidak memberikan respon sesuai AUTO_COMPLETE_HOURS,
 * sistem otomatis mengubah status ke 'completed' dan melepas dana ke freelancer
 * melalui EscrowService (dengan ledger).
 *
 * Perubahan dari versi sebelumnya:
 * - Menggunakan EscrowService::autoRelease() (bukan direct wallet increment)
 * - Menggunakan submitted_at sebagai acuan waktu (bukan updated_at yang tidak reliable)
 * - Guard: escrow_released_at IS NULL mencegah double-release
 * - Mengirim AutoCompleteNotification ke client dan freelancer
 *
 * Jadwal: setiap jam (lihat routes/console.php)
 *
 * Usage: php artisan orders:auto-complete
 */
class AutoCompleteOrders extends Command
{
    protected $signature   = 'orders:auto-complete';
    protected $description = 'Auto-complete pesanan yang sudah dikirim freelancer lebih dari batas waktu tanpa konfirmasi client.';

    public function __construct(protected EscrowService $escrowService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $autoCompleteHours = (int) config('skillkul.auto_complete_hours', 48);
        $cutoff = now()->subHours($autoCompleteHours);

        // Gunakan submitted_at sebagai acuan (lebih reliable dari updated_at)
        // Guard: escrow_released_at IS NULL mencegah double-release
        $orders = Order::with(['client', 'freelancer', 'service', 'escrow'])
            ->where('status', 'delivered')
            ->whereNotNull('submitted_at')
            ->where('submitted_at', '<=', $cutoff)
            ->whereNull('escrow_released_at')  // guard
            ->get();

        if ($orders->isEmpty()) {
            $this->info('[AutoComplete] Tidak ada pesanan yang perlu di-auto-complete.');
            return self::SUCCESS;
        }

        $completed = 0;

        foreach ($orders as $order) {
            try {
                DB::transaction(function () use ($order) {
                    // 1. Update status ke completed
                    $order->update([
                        'status'             => 'completed',
                        'completed_at'       => now(),
                        'escrow_released_at' => now(), // guard
                    ]);

                    // 2. Lepas dana escrow ke wallet freelancer (via EscrowService + ledger)
                    $this->escrowService->autoRelease($order);

                    // 3. Notifikasi ke freelancer
                    $order->freelancer->notify(
                        new AutoCompleteNotification($order, 'freelancer')
                    );

                    // 4. Notifikasi ke client
                    $order->client->notify(
                        new AutoCompleteNotification($order, 'client')
                    );
                });

                Log::info('[AutoComplete] Order berhasil di-auto-complete.', [
                    'order_id'        => $order->id,
                    'freelancer_id'   => $order->freelancer_id,
                    'client_id'       => $order->client_id,
                    'submitted_at'    => $order->submitted_at?->toDateTimeString(),
                    'cutoff_hours'    => $autoCompleteHours,
                ]);

                $completed++;

            } catch (\Exception $e) {
                Log::error('[AutoComplete] Gagal auto-complete order.', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                    'trace'    => $e->getTraceAsString(),
                ]);
            }
        }

        $this->info("[AutoComplete] Selesai. {$completed} pesanan berhasil di-auto-complete.");

        return self::SUCCESS;
    }
}
