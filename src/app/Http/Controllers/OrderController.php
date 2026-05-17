<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptOrderRequest;
use App\Http\Requests\SubmitResultRequest;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    // ─── Portal Klien ────────────────────────────────────────

    /**
     * Daftar pesanan milik client yang sedang login.
     * Eager load service & freelancer agar tidak N+1 query.
     */
    public function clientOrders(): View
    {
        $orders = Order::with(['service', 'freelancer'])
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Detail pesanan.
     * Dapat diakses oleh client pemilik order ATAU freelancer yang mengerjakan.
     */
    public function show(string $id): View
    {
        $order = Order::with(['service', 'freelancer', 'client', 'review'])
            ->findOrFail($id);

        // Otorisasi: hanya client atau freelancer terkait yang boleh akses
        abort_unless(
            auth()->id() === $order->client_id || auth()->id() === $order->freelancer_id,
            403,
            'Anda tidak memiliki akses ke pesanan ini.'
        );

        return view('orders.show', compact('order'));
    }

    /**
     * Client menerima hasil pekerjaan dan memberikan review + rating.
     *
     * Alur dalam satu transaksi DB:
     * 1. Update status order → completed
     * 2. Buat review (rating + komentar opsional)
     * 3. Tambahkan 95% dari total_price ke wallet freelancer (5% fee platform)
     */
    public function acceptOrder(AcceptOrderRequest $request, string $id): RedirectResponse
    {
        $order = Order::with('freelancer')->findOrFail($id);

        // Otorisasi: hanya client pemilik order yang boleh terima
        abort_unless(auth()->id() === $order->client_id, 403);

        // Pastikan order berstatus delivered (sudah dikirim oleh freelancer)
        if ($order->status !== 'delivered') {
            return redirect()->back()
                ->with('error', 'Pesanan ini belum dikirim oleh freelancer.');
        }

        $validated = $request->validated();

        DB::transaction(function () use ($order, $validated) {
            // 1. Update status order menjadi completed
            $order->update(['status' => 'completed']);

            // 2. Simpan review dari client
            Review::create([
                'order_id'  => $order->id,
                'client_id' => auth()->id(),
                'rating'    => $validated['rating'],
                'comment'   => $validated['comment'] ?? null,
            ]);

            // 3. Tambahkan saldo ke wallet freelancer (potong 5% fee platform)
            $freelancerEarning = $order->total_price * 0.95;
            $order->freelancer->increment('wallet_balance', $freelancerEarning);
        });

        return redirect()->route('pesanan.detail', ['id' => $order->id])
            ->with('success', 'Pesanan diterima! Terima kasih atas penilaian Anda.');
    }

    // ─── Portal Freelancer ───────────────────────────────────

    /**
     * Daftar pesanan yang dikerjakan oleh freelancer yang sedang login.
     * Eager load service & client agar tidak N+1 query.
     */
    public function freelancerOrders(): View
    {
        $orders = Order::with(['service', 'client'])
            ->where('freelancer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('freelancer.orders.index', compact('orders'));
    }

    /**
     * Freelancer mengirim link hasil pekerjaan.
     *
     * Syarat:
     * - freelancer_id harus = user yang login
     * - Status order harus in_progress
     *
     * Setelah submit: status berubah menjadi delivered.
     */
    public function submitResult(SubmitResultRequest $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        // Otorisasi: hanya freelancer yang mengerjakan order ini
        abort_unless(auth()->id() === $order->freelancer_id, 403);

        // Pastikan order sedang dikerjakan (in_progress)
        if ($order->status !== 'in_progress') {
            return redirect()->back()
                ->with('error', 'Pesanan ini tidak dalam status pengerjaan.');
        }

        $validated = $request->validated();

        // Update link hasil dan ubah status ke delivered
        $order->update([
            'freelancer_result_link' => $validated['freelancer_result_link'],
            'status'                 => 'delivered',
        ]);

        return redirect()->back()
            ->with('success', 'Hasil pekerjaan berhasil dikirim. Menunggu konfirmasi client.');
    }
}
