<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi: Withdrawal Selesai — Saldo Dikurangi
 * Target: User (client/freelancer)
 * Trigger: Admin\WithdrawalController::complete()
 */
class WithdrawalCompletedNotification extends Notification
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
            'type'          => 'withdrawal_completed',
            'title'         => '🎉 Dana Sudah Ditransfer!',
            'message'       => "Penarikan saldo Rp " .
                               number_format($this->withdrawal->amount, 0, ',', '.') .
                               " ke {$this->withdrawal->bank_name} ({$this->withdrawal->account_number}) " .
                               "telah selesai diproses.",
            'withdrawal_id' => $this->withdrawal->id,
            'url'           => route('withdrawal.history'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[SkillKul] 🎉 Transfer Selesai — Rp ' . number_format($this->withdrawal->amount, 0, ',', '.'))
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line("Penarikan saldo Anda telah **berhasil ditransfer**!")
            ->line("**Nominal**: Rp " . number_format($this->withdrawal->amount, 0, ',', '.'))
            ->line("**Bank**: {$this->withdrawal->bank_name}")
            ->line("**No. Rekening**: {$this->withdrawal->account_number}")
            ->line("**A/N**: {$this->withdrawal->account_holder}")
            ->line("Jika dana belum masuk dalam 1x24 jam, hubungi tim SkillKul.")
            ->action('Lihat Riwayat', route('withdrawal.history'))
            ->line('Terima kasih telah menggunakan SkillKul!');
    }
}
