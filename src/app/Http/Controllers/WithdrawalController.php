<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientBalanceException;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalRequestedNotification;
use App\Services\WithdrawalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * WithdrawalController
 *
 * Menangani request penarikan saldo dari client maupun freelancer.
 * Satu controller untuk kedua peran — dibedakan oleh auth()->user()->role.
 */
class WithdrawalController extends Controller
{
    public function __construct(protected WithdrawalService $withdrawalService) {}

    /**
     * Tampilkan form request withdrawal.
     * Accessible oleh: client (dari wallet refund) dan freelancer (dari wallet earning).
     */
    public function create(): View
    {
        $user    = auth()->user();
        $balance = (float) $user->wallet_balance;

        // Cek apakah ada pending/approved withdrawal
        $pendingWithdrawal = Withdrawal::where('user_id', $user->id)
                                       ->whereIn('status', ['pending', 'approved'])
                                       ->latest()
                                       ->first();

        $minAmount = (int) config('skillkul.min_withdrawal_amount', 50000);

        return view('withdrawal.create', compact('balance', 'pendingWithdrawal', 'minAmount'));
    }

    /**
     * Proses request withdrawal.
     */
    public function store(Request $request): RedirectResponse
    {
        $user     = auth()->user();
        $minAmount = (int) config('skillkul.min_withdrawal_amount', 50000);

        $validated = $request->validate([
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:30', 'regex:/^\d+$/'],
            'account_holder' => ['required', 'string', 'max:100'],
            'amount'         => ['required', 'numeric', 'min:' . $minAmount],
        ], [
            'account_number.regex' => 'Nomor rekening hanya boleh berisi angka.',
            'amount.min'           => 'Minimal penarikan adalah Rp ' . number_format($minAmount, 0, ',', '.'),
        ]);

        try {
            $withdrawal = $this->withdrawalService->request($user, $validated);

            // Notifikasi ke semua admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new WithdrawalRequestedNotification($withdrawal));
            }

            return redirect()->route('withdrawal.history')
                ->with('success', 'Request penarikan saldo berhasil diajukan. Admin akan memprosesnya segera.');

        } catch (InsufficientBalanceException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());

        } catch (\RuntimeException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan histori withdrawal user.
     */
    public function history(): View
    {
        $user = auth()->user();

        $withdrawals = Withdrawal::where('user_id', $user->id)
                                 ->latest('requested_at')
                                 ->paginate(10);

        $balance = (float) $user->wallet_balance;

        return view('withdrawal.history', compact('withdrawals', 'balance'));
    }
}
