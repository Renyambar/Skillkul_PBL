<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index($order_id)
    {
        $order = (object) ['id' => $order_id];
        return view('checkout.index', compact('order'));
    }

    public function process(Request $request, $order_id)
    {
        return redirect()->route('pesanan.detail', ['id' => $order_id])
            ->with('success', 'Pembayaran berhasil. Menunggu freelancer mengerjakan tugas.');
    }
}
