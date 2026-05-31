<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Pembayaran Berhasil
 * Target: Client
 * Trigger: MidtransController::handleNotification() — status settlement/capture
 */
class PaymentSuccessNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly Order $order) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'     => 'payment_success',
            'title'    => 'Pembayaran Berhasil',
            'message'  => "Pembayaran untuk order #{$this->order->id} sebesar Rp " .
                          number_format($this->order->total_price, 0, ',', '.') .
                          " berhasil diterima. Freelancer akan segera memulai pengerjaan.",
            'order_id' => $this->order->id,
            'url'      => route('pesanan.detail', $this->order->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul] Pembayaran Berhasil — Order ' . substr($this->order->id, 0, 8))
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Pembayaran untuk order Anda telah berhasil dikonfirmasi.")
            ->line("**Layanan**: " . ($this->order->service->title ?? '-'))
            ->line("**Total**: Rp " . number_format($this->order->total_price, 0, ',', '.'))
            ->line("Dana Anda kini disimpan dalam escrow platform dan akan diteruskan ke freelancer setelah pekerjaan selesai.")
            ->action('Lihat Detail Order', route('pesanan.detail', $this->order->id))
            ->line('Terima kasih telah menggunakan SkillKul!');
    }
}
