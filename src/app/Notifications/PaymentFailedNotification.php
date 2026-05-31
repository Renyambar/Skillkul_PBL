<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Pembayaran Gagal / Kedaluwarsa
 * Target: Client
 * Trigger: MidtransController::handleNotification() — status expire/cancel/deny
 */
class PaymentFailedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
        public readonly string $reason = 'expire',
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        $reasonLabel = match($this->reason) {
            'expire' => 'kedaluwarsa',
            'cancel' => 'dibatalkan',
            'deny'   => 'ditolak oleh bank',
            default  => $this->reason,
        };

        return [
            'type'     => 'payment_failed',
            'title'    => 'Pembayaran Gagal',
            'message'  => "Pembayaran untuk order #{$this->order->id} {$reasonLabel}. " .
                          "Silakan coba kembali atau hubungi support.",
            'order_id' => $this->order->id,
            'url'      => route('checkout', $this->order->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul] Pembayaran Gagal — Order ' . substr($this->order->id, 0, 8))
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Pembayaran untuk order Anda tidak berhasil diproses.")
            ->line("**Layanan**: " . ($this->order->service->title ?? '-'))
            ->line("**Total**: Rp " . number_format($this->order->total_price, 0, ',', '.'))
            ->action('Coba Bayar Lagi', route('checkout', $this->order->id))
            ->line('Jika Anda mengalami masalah, hubungi tim SkillKul.');
    }
}
