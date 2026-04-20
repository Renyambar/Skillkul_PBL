<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('freelancer.invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_email' => 'required|email',
            'total_price'  => 'required|numeric|min:0',
            'order_notes'  => 'required|string',
        ]);

        return redirect()->route('freelancer.dasbor')->with('success', 'Custom Invoice Escrow berhasil dibuat dan dikirim ke klien.');
    }
}
