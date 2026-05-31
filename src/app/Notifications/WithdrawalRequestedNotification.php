<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Withdrawal Diminta (ke Admin)
 * Target: Admin
 * Trigger: WithdrawalController::store() / WithdrawalService::request()
 */
class WithdrawalRequestedNotification extends Notification
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
            'type'          => 'withdrawal_requested',
            'title'         => '💸 Request Withdrawal Baru',
            'message'       => "{$this->withdrawal->user->name} mengajukan penarikan saldo " .
                               "Rp " . number_format($this->withdrawal->amount, 0, ',', '.') .
                               " ke {$this->withdrawal->bank_name} ({$this->withdrawal->account_number}).",
            'withdrawal_id' => $this->withdrawal->id,
            'url'           => route('admin.withdrawal.index'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul Admin] Request Withdrawal Baru dari ' . $this->withdrawal->user->name)
            ->greeting('Halo, Admin!')
            ->line("Ada request penarikan saldo baru yang perlu ditinjau.")
            ->line("**Pemohon**: {$this->withdrawal->user->name} ({$this->withdrawal->user->email})")
            ->line("**Nominal**: Rp " . number_format($this->withdrawal->amount, 0, ',', '.'))
            ->line("**Bank**: {$this->withdrawal->bank_name}")
            ->line("**No. Rekening**: {$this->withdrawal->account_number}")
            ->line("**A/N**: {$this->withdrawal->account_holder}")
            ->action('Review Sekarang', route('admin.withdrawal.index'));
    }
}
