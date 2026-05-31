<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Freelancer Mengirim Hasil Pekerjaan
 * Target: Client
 * Trigger: OrderController::submitResult()
 */
class FreelancerSubmitNotification extends Notification
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
            'type'     => 'freelancer_submit',
            'title'    => '📦 Hasil Pekerjaan Sudah Dikirim',
            'message'  => "Freelancer telah mengirim hasil pekerjaan untuk order #{$this->order->id}. " .
                          "Silakan periksa dan konfirmasi dalam 48 jam, atau order akan selesai otomatis.",
            'order_id' => $this->order->id,
            'url'      => route('pesanan.detail', $this->order->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul] Hasil Pekerjaan Siap Diperiksa — ' . ($this->order->service->title ?? 'Order'))
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Freelancer **{$this->order->freelancer->name}** telah mengirim hasil pekerjaan.")
            ->line("**Layanan**: " . ($this->order->service->title ?? '-'))
            ->line("**Link Hasil**: " . ($this->order->freelancer_result_link ?? '-'))
            ->line("Anda memiliki **48 jam** untuk menerima atau meminta revisi. Jika tidak ada respons, order akan selesai otomatis dan dana diteruskan ke freelancer.")
            ->action('Periksa Hasil', route('pesanan.detail', $this->order->id))
            ->line('Terima kasih telah menggunakan SkillKul!');
    }
}
