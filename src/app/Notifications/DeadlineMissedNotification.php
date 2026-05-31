<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Deadline Terlewati — Order Dibatalkan
 * Target: Client + Freelancer
 * Trigger: CancelExpiredOrders command
 */
class DeadlineMissedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
        public readonly string $recipientRole, // 'client' atau 'freelancer'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        if ($this->recipientRole === 'freelancer') {
            return [
                'type'     => 'deadline_missed',
                'title'    => '❌ Order Dibatalkan — Deadline Terlewati',
                'message'  => "Order #{$this->order->id} dibatalkan secara otomatis karena Anda tidak mengirim hasil sebelum deadline. " .
                              "Dana dikembalikan ke client.",
                'order_id' => $this->order->id,
                'url'      => route('freelancer.pesanan'),
            ];
        }

        return [
            'type'     => 'deadline_missed',
            'title'    => '📋 Order Dibatalkan — Refund Dikirim',
            'message'  => "Order #{$this->order->id} dibatalkan karena freelancer tidak mengirim hasil sebelum deadline. " .
                          "Refund telah masuk ke wallet Anda.",
            'order_id' => $this->order->id,
            'url'      => route('pesanan.detail', $this->order->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        if ($this->recipientRole === 'freelancer') {
            return (new MailMessage)
                ->subject('[SkillKul] Order Dibatalkan — Deadline Terlewati')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line("Order **#{$this->order->id}** dibatalkan karena Anda tidak mengirim hasil pekerjaan sebelum deadline.")
                ->line("**Layanan**: " . ($this->order->service->title ?? '-'))
                ->line("**Deadline**: " . $this->order->deadline?->format('d M Y, H:i'))
                ->line("Dana telah dikembalikan ke client. Pastikan untuk selalu memenuhi deadline di order berikutnya.")
                ->action('Lihat Order Saya', route('freelancer.pesanan'));
        }

        return (new MailMessage)
            ->subject('[SkillKul] Order Dibatalkan — Refund Sedang Diproses')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Order **#{$this->order->id}** dibatalkan karena freelancer tidak mengirim hasil sebelum deadline.")
            ->line("**Layanan**: " . ($this->order->service->title ?? '-'))
            ->line("Dana Anda telah dikembalikan ke wallet SkillKul.")
            ->action('Lihat Wallet Saya', route('client.dompet'));
    }
}
