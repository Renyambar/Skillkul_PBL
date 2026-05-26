<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

/**
 * AutoCompleteOrders Command
 *
 * Menjalankan logika auto-complete: jika freelancer sudah mengirim hasil
 * ('delivered') dan client tidak memberikan respon dalam 48 jam,
 * sistem otomatis mengubah status ke 'completed' dan melepas dana ke freelancer.
 *
 * Jadwal: setiap jam (lihat routes/console.php)
 *
 * Usage: php artisan orders:auto-complete
 */
class AutoCompleteOrders extends Command
{
    protected $signature   = 'orders:auto-complete';
    protected $description = 'Auto-complete pesanan yang sudah dikirim freelancer lebih dari 48 jam tanpa konfirmasi client.';

    public function handle(): int
    {
        // Ambil semua order dengan status 'delivered' yang sudah lebih dari 48 jam
        $cutoff = now()->subHours(48);

        $orders = Order::with('freelancer')
            ->where('status', 'delivered')
            ->where('updated_at', '<=', $cutoff)
            ->get();

        if ($orders->isEmpty()) {
            $this->info('[AutoComplete] Tidak ada pesanan yang perlu di-auto-complete.');
            return self::SUCCESS;
        }

        $completed = 0;

        foreach ($orders as $order) {
            try {
                DB::transaction(function () use ($order) {
                    // Update status ke completed
                    $order->update(['status' => 'completed']);

                    // Lepas 95% dana ke wallet freelancer (5% fee platform)
                    $freelancerEarning = $order->total_price * 0.95;
                    $order->freelancer->increment('wallet_balance', $freelancerEarning);
                });

                Log::info('[AutoComplete] Order berhasil di-auto-complete.', [
                    'order_id'           => $order->id,
                    'freelancer_id'      => $order->freelancer_id,
                    'amount_released'    => $order->total_price * 0.95,
                    'delivered_at'       => $order->updated_at,
                ]);

                $completed++;

            } catch (\Exception $e) {
                Log::error('[AutoComplete] Gagal auto-complete order.', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        $this->info("[AutoComplete] Selesai. {$completed} pesanan berhasil di-auto-complete.");

        return self::SUCCESS;
    }
}
