<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Saldo saat ini
        $balance = $user->wallet_balance ?? 0;

        // Ambil riwayat transaksi: pesanan yang selesai untuk freelancer ini
        $transactions = Order::with(['service', 'client'])
            ->where('freelancer_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('freelancer.wallet.index', compact('transactions', 'balance'));
    }
}
