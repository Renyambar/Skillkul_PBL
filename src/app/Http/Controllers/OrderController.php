<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function clientOrders()
    {
        return view('orders.index');
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
