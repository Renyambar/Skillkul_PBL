<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Order Selesai (Client Accept)
 * Target: Freelancer
 * Trigger: OrderController::acceptOrder()
 */
class OrderCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly Order $order) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        $feePercent      = config('skillkul.platform_fee_percent', 8);
        $freelancerAmt   = $this->order->total_price * ((100 - $feePercent) / 100);

        return [
            'type'             => 'order_completed',
            'title'            => '✅ Order Selesai — Dana Diterima!',
            'message'          => "Client telah menerima hasil pekerjaan Anda untuk order #{$this->order->id}. " .
                                  "Dana sebesar Rp " . number_format($freelancerAmt, 0, ',', '.') .
                                  " telah masuk ke wallet Anda.",
            'order_id'         => $this->order->id,
            'freelancer_amount' => $freelancerAmt,
            'url'              => route('freelancer.dompet'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $feePercent    = config('skillkul.platform_fee_percent', 8);
        $freelancerAmt = $this->order->total_price * ((100 - $feePercent) / 100);

        return (new MailMessage)
            ->subject('[SkillKul] 🎉 Order Selesai — Dana Masuk ke Wallet')
            ->greeting('Selamat, ' . $notifiable->name . '!')
            ->line("Client **{$this->order->client->name}** telah menerima hasil pekerjaan Anda.")
            ->line("**Layanan**: " . ($this->order->service->title ?? '-'))
            ->line("**Dana yang diterima**: Rp " . number_format($freelancerAmt, 0, ',', '.'))
            ->line("(Setelah potongan fee platform {$feePercent}%)")
            ->action('Lihat Wallet Saya', route('freelancer.dompet'))
            ->line('Kerja bagus! Terus berkarya di SkillKul.');
    }
}
