<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * WithdrawalService — Penarikan Saldo
 *
 * Menangani seluruh alur withdrawal:
 *   1. request()  : User mengajukan penarikan
 *   2. approve()  : Admin menyetujui
 *   3. reject()   : Admin menolak (dengan catatan)
 *   4. complete() : Admin konfirmasi transfer selesai → saldo dikurangi
 *
 * PENTING:
 * - Saldo TIDAK dikurangi saat request atau approve.
 * - Saldo dikurangi HANYA saat complete() melalui WalletService::debit().
 * - Validasi: tidak boleh ada pending withdrawal lain dari user yang sama.
 */
class WithdrawalService
{
    public function __construct(
        protected WalletService $walletService,
    ) {}

    /**
     * User mengajukan request penarikan saldo.
     *
     * Validasi:
     * - Nominal harus > 0
     * - Saldo cukup (tidak melebihi wallet_balance saat ini)
     * - Tidak ada pending/approved withdrawal lain dari user yang sama
     *
     * @param  User  $user  Pemohon (client atau freelancer)
     * @param  array $data  Data bank: bank_name, account_number, account_holder, amount
     * @return Withdrawal
     *
     * @throws InsufficientBalanceException Jika saldo tidak cukup
     * @throws \RuntimeException            Jika sudah ada pending withdrawal
     */
    public function request(User $user, array $data): Withdrawal
    {
        $amount = (float) $data['amount'];

        // Validasi: tidak ada pending/approved withdrawal lain
        $hasPending = Withdrawal::where('user_id', $user->id)
                                ->whereIn('status', ['pending', 'approved'])
                                ->exists();

        if ($hasPending) {
            throw new \RuntimeException(
                'Anda masih memiliki request penarikan yang sedang diproses. ' .
                'Harap tunggu hingga selesai sebelum mengajukan yang baru.'
            );
        }

        // Validasi saldo mencukupi (cek snapshot — saldo aktual di DB)
        $currentBalance = (float) User::where('id', $user->id)->value('wallet_balance');
        if ($currentBalance < $amount) {
            throw new InsufficientBalanceException($amount, $currentBalance);
        }

        $withdrawal = Withdrawal::create([
            'user_id'        => $user->id,
            'bank_name'      => $data['bank_name'],
            'account_number' => $data['account_number'],
            'account_holder' => $data['account_holder'],
            'amount'         => $amount,
            'status'         => 'pending',
            'requested_at'   => now(),
        ]);

        Log::info('[Withdrawal] Request baru dibuat.', [
            'withdrawal_id' => $withdrawal->id,
            'user_id'       => $user->id,
            'amount'        => $amount,
        ]);

        return $withdrawal;
    }

    /**
     * Admin menyetujui withdrawal request.
     *
     * @param  Withdrawal $withdrawal Request yang akan disetujui
     * @param  User       $admin      Admin yang menyetujui
     */
    public function approve(Withdrawal $withdrawal, User $admin): void
    {
        if ($withdrawal->status !== 'pending') {
            throw new \RuntimeException(
                "Withdrawal tidak dapat disetujui karena status saat ini: {$withdrawal->status}"
            );
        }

        $withdrawal->update([
            'status'      => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);

        Log::info('[Withdrawal] Disetujui oleh admin.', [
            'withdrawal_id' => $withdrawal->id,
            'admin_id'      => $admin->id,
        ]);
    }

    /**
     * Admin menolak withdrawal request.
     *
     * @param  Withdrawal $withdrawal Request yang ditolak
     * @param  User       $admin      Admin yang menolak
     * @param  string     $note       Alasan penolakan (wajib)
     */
    public function reject(Withdrawal $withdrawal, User $admin, string $note): void
    {
        if (! in_array($withdrawal->status, ['pending', 'approved'])) {
            throw new \RuntimeException(
                "Withdrawal tidak dapat ditolak karena status saat ini: {$withdrawal->status}"
            );
        }

        $withdrawal->update([
            'status'      => 'rejected',
            'admin_note'  => $note,
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);

        Log::info('[Withdrawal] Ditolak oleh admin.', [
            'withdrawal_id' => $withdrawal->id,
            'admin_id'      => $admin->id,
            'reason'        => $note,
        ]);
    }

    /**
     * Admin mengkonfirmasi transfer selesai → saldo user dikurangi.
     *
     * Ini adalah operasi yang paling sensitif karena melibatkan perubahan saldo.
     * Gunakan DB::transaction() dan WalletService::debit() untuk atomicity.
     *
     * @param  Withdrawal $withdrawal Request yang sudah ditransfer
     * @param  User       $admin      Admin yang mengkonfirmasi
     *
     * @throws \RuntimeException            Jika status bukan 'approved'
     * @throws InsufficientBalanceException Jika saldo tidak cukup (re-check)
     */
    public function complete(Withdrawal $withdrawal, User $admin): void
    {
        if ($withdrawal->status !== 'approved') {
            throw new \RuntimeException(
                "Withdrawal harus berstatus 'approved' sebelum bisa diselesaikan. " .
                "Status saat ini: {$withdrawal->status}"
            );
        }

        $user = $withdrawal->user;

        DB::transaction(function () use ($withdrawal, $admin, $user) {
            // Lock withdrawal record untuk mencegah double-complete
            $lockedWithdrawal = Withdrawal::where('id', $withdrawal->id)
                                          ->lockForUpdate()
                                          ->first();

            if ($lockedWithdrawal->status !== 'approved') {
                throw new \RuntimeException('Withdrawal sudah diproses oleh request lain.');
            }

            // Update status withdrawal
            $lockedWithdrawal->update([
                'status'       => 'completed',
                'completed_at' => now(),
                'reviewed_by'  => $admin->id,
            ]);

            // Kurangi saldo wallet melalui WalletService (dengan ledger)
            $this->walletService->debit(
                user: $user,
                amount: (float) $lockedWithdrawal->amount,
                category: 'withdrawal',
                description: "Penarikan saldo ke {$lockedWithdrawal->bank_name} " .
                             "a/n {$lockedWithdrawal->account_holder} " .
                             "({$lockedWithdrawal->account_number})",
                withdrawal: $lockedWithdrawal,
            );
        });

        Log::info('[Withdrawal] Selesai — saldo user dikurangi.', [
            'withdrawal_id' => $withdrawal->id,
            'user_id'       => $user->id,
            'amount'        => $withdrawal->amount,
            'admin_id'      => $admin->id,
        ]);
    }
}
