<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Tampilkan form pembuatan Custom Invoice.
     *
     * Hanya menampilkan jasa milik freelancer yang sedang login,
     * agar freelancer bisa memilih jasa mana yang akan ditagihkan.
     */
    public function create(): View
    {
        // Ambil daftar jasa aktif milik freelancer yang login
        $services = Service::where('freelancer_id', auth()->id())
            ->where('is_active', true)
            ->select('id', 'title', 'price', 'price_max', 'type')
            ->orderBy('title')
            ->get();

        return view('freelancer.invoices.create', compact('services'));
    }

    /**
     * Proses pembuatan Custom Invoice.
     *
     * Alur:
     * 1. Validasi input (email klien harus terdaftar, jasa harus milik freelancer)
     * 2. Pastikan freelancer tidak menagih dirinya sendiri
     * 3. Pastikan jasa yang dipilih milik freelancer yang login
     * 4. Buat order baru dengan type=custom_invoice, status=pending
     * 5. Redirect ke halaman pesanan freelancer
     */
    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Cari user client berdasarkan email
        $client = User::where('email', $validated['client_email'])->first();

        // Pastikan freelancer tidak menagih dirinya sendiri
        if ($client->id === auth()->id()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda tidak dapat membuat tagihan untuk diri sendiri.');
        }

        // Pastikan jasa yang dipilih milik freelancer yang login
        $service = Service::where('id', $validated['service_id'])
            ->where('freelancer_id', auth()->id())
            ->first();

        if (! $service) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jasa yang dipilih bukan milik Anda.');
        }

        // Buat order baru — UUID di-generate otomatis oleh Model boot()
        Order::create([
            'client_id'     => $client->id,
            'freelancer_id' => auth()->id(),
            'service_id'    => $service->id,
            'type'          => 'custom_invoice',
            'status'        => 'pending',
            'total_price'   => $validated['total_price'],
            'order_notes'   => $validated['order_notes'],
        ]);

        return redirect()->route('freelancer.pesanan')
            ->with('success', 'Invoice berhasil dibuat! Klien dapat melihat tagihan di halaman pesanan mereka.');
    }
}
