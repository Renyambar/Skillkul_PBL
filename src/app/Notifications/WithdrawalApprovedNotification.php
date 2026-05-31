<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Withdrawal Disetujui
 * Target: User (client/freelancer)
 * Trigger: Admin\WithdrawalController::approve()
 */
class WithdrawalApprovedNotification extends Notification
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
            'type'          => 'withdrawal_approved',
            'title'         => '✅ Withdrawal Disetujui',
            'message'       => "Request penarikan saldo Rp " .
                               number_format($this->withdrawal->amount, 0, ',', '.') .
                               " Anda telah disetujui. Transfer manual sedang diproses oleh tim SkillKul.",
            'withdrawal_id' => $this->withdrawal->id,
            'url'           => route('withdrawal.history'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul] Withdrawal Disetujui — Rp ' . number_format($this->withdrawal->amount, 0, ',', '.'))
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Request penarikan saldo Anda telah **disetujui**!")
            ->line("**Nominal**: Rp " . number_format($this->withdrawal->amount, 0, ',', '.'))
            ->line("**Bank**: {$this->withdrawal->bank_name} ({$this->withdrawal->account_number})")
            ->line("Tim SkillKul akan segera memproses transfer. Harap tunggu konfirmasi selesai.")
            ->action('Lihat Riwayat', route('withdrawal.history'));
    }
}
