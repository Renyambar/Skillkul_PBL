<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WalletController extends Controller
{
    /**
     * Dashboard wallet freelancer.
     * Menampilkan saldo + riwayat ledger dari escrow release.
     */
    public function index(): View
    {
        $user    = Auth::user();
        $balance = (float) $user->wallet_balance;

        // Riwayat transaksi dari ledger (bukan dari orders)
        $transactions = WalletTransaction::where('user_id', $user->id)
            ->with(['order.service', 'order.client', 'withdrawal'])
            ->latest()
            ->paginate(10);

        return view('freelancer.wallet.index', compact('transactions', 'balance'));
    }

    /**
     * Dashboard wallet client.
     * Menampilkan saldo refund + riwayat ledger.
     */
    public function clientWallet(): View
    {
        $user    = Auth::user();
        $balance = (float) $user->wallet_balance;

        // Riwayat transaksi dari ledger
        $transactions = WalletTransaction::where('user_id', $user->id)
            ->with(['order.service', 'order.freelancer', 'withdrawal'])
            ->latest()
            ->paginate(10);

        return view('wallet.client', compact('transactions', 'balance'));
    }
}
