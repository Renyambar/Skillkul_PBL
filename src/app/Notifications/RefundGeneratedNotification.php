<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Refund Diterima (Deadline Miss)
 * Target: Client
 * Trigger: CancelExpiredOrders command / EscrowService::refundToClient()
 */
class RefundGeneratedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
        public readonly float $refundAmount,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'          => 'refund_generated',
            'title'         => '💰 Refund Diterima',
            'message'       => "Refund sebesar Rp " . number_format($this->refundAmount, 0, ',', '.') .
                               " untuk order #{$this->order->id} telah masuk ke wallet Anda. " .
                               "Freelancer gagal memenuhi deadline.",
            'order_id'      => $this->order->id,
            'refund_amount' => $this->refundAmount,
            'url'           => route('client.dompet'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul] Refund Berhasil — Dana Kembali ke Wallet Anda')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Kami mohon maaf atas ketidaknyamanan ini.")
            ->line("Freelancer tidak berhasil menyelesaikan order sebelum deadline, sehingga order dibatalkan secara otomatis.")
            ->line("**Refund**: Rp " . number_format($this->refundAmount, 0, ',', '.'))
            ->line("Dana telah masuk ke wallet SkillKul Anda dan dapat digunakan untuk order baru atau ditarik.")
            ->action('Lihat Wallet Saya', route('client.dompet'))
            ->line('Tim SkillKul siap membantu jika ada pertanyaan.');
    }
}
