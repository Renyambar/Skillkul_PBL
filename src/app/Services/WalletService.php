<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Escrow;
use App\Models\Order;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

/**
 * WalletService — Core Financial Ledger Service
 *
 * Bertanggung jawab atas SEMUA perubahan saldo wallet.
 * Tidak ada perubahan saldo yang terjadi di luar service ini.
 *
 * Prinsip keamanan:
 * 1. Setiap perubahan saldo selalu disertai WalletTransaction entry.
 * 2. debit() memvalidasi saldo tidak negatif sebelum debit.
 * 3. Semua operasi menggunakan lockForUpdate() untuk mencegah race condition.
 * 4. balance_before dan balance_after disimpan sebagai snapshot immutable.
 *
 * Penggunaan:
 *   // Pastikan dipanggil di dalam DB::transaction() dari caller
 *   $walletService->credit($freelancer, 92000, 'escrow_release', 'Dana order #123 diterima', $order, $escrow);
 *   $walletService->debit($client, 50000, 'withdrawal', 'Penarikan saldo', null, null, $withdrawal);
 */
class WalletService
{
    /**
     * Credit (tambah saldo) ke wallet user.
     *
     * @param  User        $user         Pemilik wallet
     * @param  float       $amount       Nominal yang dikreditkan (harus > 0)
     * @param  string      $category     Kategori transaksi (lihat WalletTransaction::$fillable)
     * @param  string      $description  Deskripsi human-readable untuk UI
     * @param  Order|null  $order        Referensi order (opsional)
     * @param  Escrow|null $escrow       Referensi escrow (opsional)
     * @param  Withdrawal|null $withdrawal Referensi withdrawal (opsional)
     *
     * @throws \InvalidArgumentException Jika amount <= 0
     */
    public function credit(
        User $user,
        float $amount,
        string $category,
        string $description,
        ?Order $order = null,
        ?Escrow $escrow = null,
        ?Withdrawal $withdrawal = null,
    ): WalletTransaction {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Credit amount harus lebih dari 0. Diterima: {$amount}");
        }

        // Lock user row untuk mencegah race condition
        $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();

        $balanceBefore = (float) $lockedUser->wallet_balance;
        $balanceAfter  = $balanceBefore + $amount;

        // Update saldo
        $lockedUser->increment('wallet_balance', $amount);

        // Catat ledger
        return WalletTransaction::create([
            'user_id'       => $user->id,
            'order_id'      => $order?->id,
            'escrow_id'     => $escrow?->id,
            'withdrawal_id' => $withdrawal?->id,
            'type'          => 'credit',
            'category'      => $category,
            'amount'        => $amount,
            'balance_before' => $balanceBefore,
            'balance_after'  => $balanceAfter,
            'description'   => $description,
        ]);
    }

    /**
     * Debit (kurangi saldo) dari wallet user.
     *
     * @throws InsufficientBalanceException Jika saldo tidak mencukupi
     * @throws \InvalidArgumentException    Jika amount <= 0
     */
    public function debit(
        User $user,
        float $amount,
        string $category,
        string $description,
        ?Order $order = null,
        ?Escrow $escrow = null,
        ?Withdrawal $withdrawal = null,
    ): WalletTransaction {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Debit amount harus lebih dari 0. Diterima: {$amount}");
        }

        // Lock user row untuk mencegah race condition
        $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();

        $balanceBefore = (float) $lockedUser->wallet_balance;

        // Validasi saldo tidak negatif — keamanan utama
        if ($balanceBefore < $amount) {
            throw new InsufficientBalanceException($amount, $balanceBefore);
        }

        $balanceAfter = $balanceBefore - $amount;

        // Update saldo
        $lockedUser->decrement('wallet_balance', $amount);

        // Catat ledger
        return WalletTransaction::create([
            'user_id'        => $user->id,
            'order_id'       => $order?->id,
            'escrow_id'      => $escrow?->id,
            'withdrawal_id'  => $withdrawal?->id,
            'type'           => 'debit',
            'category'       => $category,
            'amount'         => $amount,
            'balance_before' => $balanceBefore,
            'balance_after'  => $balanceAfter,
            'description'    => $description,
        ]);
    }
}
