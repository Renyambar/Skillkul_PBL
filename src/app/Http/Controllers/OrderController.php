<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function clientOrders()
    {
        // Ganti dengan view yang sesuai jika pesanan-saya sudah ada layarnya
        return redirect()->route('dashboard')->with('info', 'Halaman riwayat pesanan (klien) belum tersedia secara penuh.');
    }

    public function show($id)
    {
        $order = (object) ['id' => $id];
        return view('orders.show', compact('order'));
    }

    public function review(Request $request, $id)
    {
        return redirect()->back()->with('success', 'Penilaian berhasil dikirimkan!');
    }
}
