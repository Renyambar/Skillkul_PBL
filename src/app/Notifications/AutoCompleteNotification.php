<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Auto-Complete (48 Jam)
 * Target: Client + Freelancer
 * Trigger: AutoCompleteOrders command
 */
class AutoCompleteNotification extends Notification
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
        $feePercent    = config('skillkul.platform_fee_percent', 8);
        $freelancerAmt = $this->order->total_price * ((100 - $feePercent) / 100);

        if ($this->recipientRole === 'freelancer') {
            return [
                'type'     => 'auto_complete',
                'title'    => '✅ Order Auto-Selesai — Dana Diterima',
                'message'  => "Order #{$this->order->id} otomatis diselesaikan setelah 48 jam tanpa respons client. " .
                              "Dana Rp " . number_format($freelancerAmt, 0, ',', '.') . " masuk ke wallet Anda.",
                'order_id' => $this->order->id,
                'url'      => route('freelancer.dompet'),
            ];
        }

        return [
            'type'     => 'auto_complete',
            'title'    => 'Order Auto-Selesai',
            'message'  => "Order #{$this->order->id} otomatis diselesaikan karena tidak ada respons dalam 48 jam " .
                          "setelah freelancer mengirim hasil.",
            'order_id' => $this->order->id,
            'url'      => route('pesanan.detail', $this->order->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $feePercent    = config('skillkul.platform_fee_percent', 8);
        $freelancerAmt = $this->order->total_price * ((100 - $feePercent) / 100);

        if ($this->recipientRole === 'freelancer') {
            return (new MailMessage)
                ->subject('[SkillKul] Order Auto-Selesai — Dana Masuk')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line("Order **#{$this->order->id}** otomatis diselesaikan karena client tidak memberikan respons dalam 48 jam.")
                ->line("**Dana diterima**: Rp " . number_format($freelancerAmt, 0, ',', '.'))
                ->action('Lihat Wallet', route('freelancer.dompet'));
        }

        return (new MailMessage)
            ->subject('[SkillKul] Order Auto-Selesai')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Order **#{$this->order->id}** otomatis diselesaikan karena tidak ada respons dari Anda dalam 48 jam.")
            ->line("Jika ada masalah dengan hasil pekerjaan, silakan hubungi tim SkillKul.")
            ->action('Lihat Detail Order', route('pesanan.detail', $this->order->id));
    }
}
