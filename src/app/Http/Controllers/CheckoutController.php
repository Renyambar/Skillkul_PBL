<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutProcessRequest;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Buat order baru dari halaman detail jasa (Non-Project / direct checkout).
     *
     * Alur:
     * 1. Validasi: jasa aktif, freelancer tidak sibuk, client bukan pemilik jasa
     * 2. Buat order dengan UUID (auto-generate di Model)
     * 3. Redirect ke halaman checkout untuk proses pembayaran
     */
    public function createOrder(int $service_id): RedirectResponse
    {
        $service = Service::with('freelancer')->findOrFail($service_id);

        // Pastikan jasa masih aktif
        if (! $service->is_active) {
            return redirect()->back()
                ->with('error', 'Jasa ini sedang tidak tersedia.');
        }

        // Pastikan freelancer tidak sedang sibuk (mode ujian / ada order in_progress)
        if ($service->freelancer->is_busy) {
            return redirect()->back()
                ->with('error', 'Freelancer sedang sibuk. Silakan coba lagi nanti.');
        }

        // Pastikan client tidak memesan jasa miliknya sendiri
        if (auth()->id() === $service->freelancer_id) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat memesan jasa milik sendiri.');
        }

        // Buat order baru — UUID di-generate otomatis oleh Model boot()
        $order = Order::create([
            'client_id'     => auth()->id(),
            'freelancer_id' => $service->freelancer_id,
            'service_id'    => $service->id,
            'type'          => 'direct_checkout',
            'status'        => 'pending',
            'total_price'   => $service->price,
        ]);

        return redirect()->route('checkout', ['order_id' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    /**
     * Tampilkan halaman checkout dengan detail pesanan.
     *
     * Hanya client pemilik order yang boleh mengakses halaman ini.
     */
    public function index(string $order_id): View
    {
        $order = Order::with(['service', 'freelancer', 'client'])
            ->findOrFail($order_id);

        // Otorisasi: hanya client pemilik order yang boleh akses
        abort_unless(auth()->id() === $order->client_id, 403);

        return view('checkout.index', compact('order'));
    }

    /**
     * Proses data checkout (catatan pesanan & link gdrive).
     *
     * Saat ini menyimpan data form saja.
     * TODO: Integrasi Midtrans Snap akan ditambahkan di sini oleh Ambar.
     */
    public function process(CheckoutProcessRequest $request, string $order_id): RedirectResponse
    {
        $order = Order::findOrFail($order_id);

        // Otorisasi: hanya client pemilik order yang boleh proses
        abort_unless(auth()->id() === $order->client_id, 403);

        // Pastikan order masih berstatus pending (belum dibayar)
        if ($order->status !== 'pending') {
            return redirect()->route('pesanan.detail', ['id' => $order->id])
                ->with('error', 'Pesanan ini sudah tidak dapat diproses.');
        }

        // Simpan catatan & link dari client
        $order->update($request->validated());

        // TODO: Generate Midtrans Snap Token di sini
        // $snapToken = Midtrans::createTransaction([...]);
        // $order->update(['midtrans_snap_token' => $snapToken]);

        return redirect()->route('checkout', ['order_id' => $order->id])
            ->with('info', 'Data pesanan tersimpan. Silakan lanjutkan ke pembayaran.');
    }
}
