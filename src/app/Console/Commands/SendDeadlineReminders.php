<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * SendDeadlineReminders Command
 *
 * Mencari semua pesanan yang:
 * - Status 'in_progress' atau 'revision'
 * - Memiliki deadline yang diisi
 * - Deadline jatuh dalam rentang 24 jam ke depan
 *
 * Lalu mengirim notifikasi (via Log untuk sekarang, siap di-upgrade ke email/push).
 *
 * Jadwal: setiap jam (lihat routes/console.php)
 *
 * Usage: php artisan orders:deadline-reminders
 */
class SendDeadlineReminders extends Command
{
    protected $signature   = 'orders:deadline-reminders';
    protected $description = 'Kirim pengingat ke freelancer yang deadlinenya dalam 24 jam.';

    public function handle(): int
    {
        $now        = now();
        $in24Hours  = now()->addHours(24);

        // Cari pesanan yang deadlinenya antara sekarang dan 24 jam ke depan
        $orders = Order::with(['freelancer', 'client', 'service'])
            ->whereIn('status', ['in_progress', 'revision'])
            ->whereNotNull('deadline')
            ->whereBetween('deadline', [$now, $in24Hours])
            ->get();

        if ($orders->isEmpty()) {
            $this->info('[DeadlineReminder] Tidak ada deadline dalam 24 jam ke depan.');
            return self::SUCCESS;
        }

        $sent = 0;

        foreach ($orders as $order) {
            try {
                $hoursLeft = (int) now()->diffInHours($order->deadline);

                // ── Log reminder (upgrade ke Notification / Mail sesuai kebutuhan) ──
                Log::info('[DeadlineReminder] Pengingat deadline dikirim ke freelancer.', [
                    'order_id'       => $order->id,
                    'freelancer_id'  => $order->freelancer_id,
                    'freelancer_name'=> $order->freelancer->name,
                    'service_title'  => $order->service->title ?? '-',
                    'deadline'       => $order->deadline->format('d M Y H:i'),
                    'hours_left'     => $hoursLeft,
                ]);

                // TODO: Ganti dengan notifikasi nyata jika fitur email/push sudah aktif:
                // $order->freelancer->notify(new DeadlineReminderNotification($order));

                $this->line("  ✓ Reminder: Order #{$order->id} → {$order->freelancer->name} ({$hoursLeft} jam lagi)");

                $sent++;

            } catch (\Exception $e) {
                Log::error('[DeadlineReminder] Gagal mengirim reminder.', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        $this->info("[DeadlineReminder] Selesai. {$sent} reminder dikirim.");

        return self::SUCCESS;
    }
}
