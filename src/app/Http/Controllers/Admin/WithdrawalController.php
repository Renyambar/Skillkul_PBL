<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalApprovedNotification;
use App\Notifications\WithdrawalCompletedNotification;
use App\Notifications\WithdrawalRejectedNotification;
use App\Services\WithdrawalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin\WithdrawalController
 *
 * Dashboard admin untuk mengelola withdrawal request, melihat saldo escrow,
 * dan memantau seluruh transaksi wallet di platform.
 */
class WithdrawalController extends Controller
{
    public function __construct(protected WithdrawalService $withdrawalService) {}

    /**
     * Daftar semua withdrawal request (default: tampilkan pending dahulu).
     */
    public function index(Request $request): View
    {
        $status = $request->get('status', 'pending');

        $withdrawals = Withdrawal::with(['user'])
            ->when(
                in_array($status, ['pending', 'approved', 'rejected', 'completed', 'all']),
                fn ($q) => $status !== 'all' ? $q->where('status', $status) : $q
            )
            ->latest('requested_at')
            ->paginate(20);

        // Summary counts untuk tabs
        $counts = [
            'pending'   => Withdrawal::where('status', 'pending')->count(),
            'approved'  => Withdrawal::where('status', 'approved')->count(),
            'completed' => Withdrawal::where('status', 'completed')->count(),
            'rejected'  => Withdrawal::where('status', 'rejected')->count(),
        ];

        return view('admin.withdrawal.index', compact('withdrawals', 'counts', 'status'));
    }

    /**
     * Admin menyetujui withdrawal request.
     */
    public function approve(int $id): RedirectResponse
    {
        $withdrawal = Withdrawal::findOrFail($id);

        try {
            $this->withdrawalService->approve($withdrawal, auth()->user());
            $withdrawal->user->notify(new WithdrawalApprovedNotification($withdrawal));

            return redirect()->back()
                ->with('success', "Withdrawal #{$id} disetujui. Silakan lakukan transfer manual ke rekening tujuan.");

        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Admin menolak withdrawal request.
     */
    public function reject(Request $request, int $id): RedirectResponse
    {
        $withdrawal = Withdrawal::findOrFail($id);

        $request->validate([
            'admin_note' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'admin_note.required' => 'Alasan penolakan wajib diisi.',
            'admin_note.min'      => 'Alasan penolakan minimal 10 karakter.',
        ]);

        try {
            $this->withdrawalService->reject($withdrawal, auth()->user(), $request->admin_note);
            $withdrawal->user->notify(new WithdrawalRejectedNotification($withdrawal->fresh()));

            return redirect()->back()
                ->with('success', "Withdrawal #{$id} ditolak. User telah dinotifikasi.");

        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Admin mengkonfirmasi transfer selesai → saldo user dikurangi.
     * Hanya bisa dilakukan jika status = 'approved'.
     */
    public function complete(int $id): RedirectResponse
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);

        try {
            $this->withdrawalService->complete($withdrawal, auth()->user());
            $withdrawal->user->notify(new WithdrawalCompletedNotification($withdrawal->fresh()));

            return redirect()->back()
                ->with('success', "Withdrawal #{$id} selesai. Saldo user telah dikurangi.");

        } catch (\App\Exceptions\InsufficientBalanceException $e) {
            return redirect()->back()->with('error', 'Saldo user tidak mencukupi: ' . $e->getMessage());

        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Dashboard escrow — saldo total yang masih ditahan platform.
     */
    public function escrowDashboard(): View
    {
        // Total escrow yang masih held (belum release/refund)
        $totalHeld = Escrow::where('status', 'held')->sum('amount');
        $totalPlatformFee = Escrow::where('status', 'released')->sum('platform_fee');

        // Escrow terbaru (semua status)
        $recentEscrows = Escrow::with(['order.client', 'order.freelancer', 'order.service'])
            ->latest()
            ->paginate(20);

        // Summary per status
        $summary = [
            'held'     => ['count' => Escrow::where('status', 'held')->count(),     'total' => Escrow::where('status', 'held')->sum('amount')],
            'released' => ['count' => Escrow::where('status', 'released')->count(), 'total' => Escrow::where('status', 'released')->sum('amount')],
            'refunded' => ['count' => Escrow::where('status', 'refunded')->count(), 'total' => Escrow::where('status', 'refunded')->sum('amount')],
        ];

        return view('admin.escrow.index', compact(
            'totalHeld', 'totalPlatformFee', 'recentEscrows', 'summary'
        ));
    }

    /**
     * Semua transaksi wallet di seluruh platform.
     */
    public function transactions(Request $request): View
    {
        $transactions = WalletTransaction::with(['user', 'order', 'escrow', 'withdrawal'])
            ->when($request->filled('user_id'), fn ($q) => $q->where('user_id', $request->user_id))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->latest()
            ->paginate(25);

        // Stats summary
        $totalCredits = WalletTransaction::where('type', 'credit')->sum('amount');
        $totalDebits  = WalletTransaction::where('type', 'debit')->sum('amount');

        return view('admin.transactions.index', compact(
            'transactions', 'totalCredits', 'totalDebits'
        ));
    }
}
