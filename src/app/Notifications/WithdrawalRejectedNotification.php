<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Withdrawal Ditolak
 * Target: User (client/freelancer)
 * Trigger: Admin\WithdrawalController::reject()
 */
class WithdrawalRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly Withdrawal $withdrawal) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'          => 'withdrawal_rejected',
            'title'         => '❌ Withdrawal Ditolak',
            'message'       => "Request penarikan saldo Rp " .
                               number_format($this->withdrawal->amount, 0, ',', '.') .
                               " ditolak. Alasan: " . ($this->withdrawal->admin_note ?? '-'),
            'withdrawal_id' => $this->withdrawal->id,
            'url'           => route('withdrawal.history'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul] Withdrawal Ditolak')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Sayangnya, request penarikan saldo Anda **ditolak**.")
            ->line("**Nominal**: Rp " . number_format($this->withdrawal->amount, 0, ',', '.'))
            ->line("**Alasan**: " . ($this->withdrawal->admin_note ?? 'Tidak ada keterangan.'))
            ->line("Saldo Anda tidak berkurang. Anda dapat mengajukan request baru setelah memperbaiki data.")
            ->action('Ajukan Kembali', route('withdrawal.create'))
            ->line('Hubungi support jika ada pertanyaan.');
    }
}
