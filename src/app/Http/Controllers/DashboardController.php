<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Total Pendapatan (Pesanan selesai)
        $totalPendapatan = Order::where('freelancer_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_price') * 0.95; // Assuming 5% platform fee

        // 2. Pesanan Aktif
        $pesananAktifCount = Order::where('freelancer_id', $user->id)
            ->whereIn('status', ['paid', 'in_progress', 'revision'])
            ->count();

        // 3. Saldo Dompet
        $saldoDompet = $user->wallet_balance;

        // 4. Daftar Pesanan Aktif (max 5)
        $activeOrders = Order::with('client', 'service')
            ->where('freelancer_id', $user->id)
            ->whereIn('status', ['paid', 'in_progress', 'revision', 'delivered'])
            ->latest()
            ->take(5)
            ->get();

        return view('freelancer.dashboard', compact(
            'totalPendapatan',
            'pesananAktifCount',
            'saldoDompet',
            'activeOrders'
        ));
    }
}
