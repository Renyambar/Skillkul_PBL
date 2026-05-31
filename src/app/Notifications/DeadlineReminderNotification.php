<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Pengingat Deadline H-24
 * Target: Freelancer
 * Trigger: SendDeadlineReminders command (setiap jam)
 */
class DeadlineReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
        public readonly int $hoursLeft,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'      => 'deadline_reminder',
            'title'     => '⏰ Deadline Mendekat!',
            'message'   => "Order #{$this->order->id} (" . ($this->order->service->title ?? '-') . ") " .
                           "memiliki deadline dalam {$this->hoursLeft} jam lagi. " .
                           "Segera selesaikan dan kirim hasil pekerjaan.",
            'order_id'  => $this->order->id,
            'hours_left' => $this->hoursLeft,
            'deadline'  => $this->order->deadline?->toISOString(),
            'url'       => route('freelancer.pesanan'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("[SkillKul] ⏰ Deadline {$this->hoursLeft} Jam Lagi — " . ($this->order->service->title ?? 'Order'))
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("**Peringatan Deadline!** Order Anda akan jatuh tempo dalam **{$this->hoursLeft} jam**.")
            ->line("**Layanan**: " . ($this->order->service->title ?? '-'))
            ->line("**Deadline**: " . $this->order->deadline?->format('d M Y, H:i') . ' WIB')
            ->line("Jika Anda tidak mengirim hasil sebelum deadline, order akan dibatalkan otomatis dan dana dikembalikan ke client.")
            ->action('Kirim Hasil Sekarang', route('freelancer.pesanan'))
            ->line('Semangat mengerjakan!');
    }
}
