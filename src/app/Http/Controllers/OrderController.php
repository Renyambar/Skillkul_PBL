<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptOrderRequest;
use App\Http\Requests\SubmitResultRequest;
use App\Models\Order;
use App\Models\Review;
use App\Notifications\FreelancerSubmitNotification;
use App\Notifications\OrderCompletedNotification;
use App\Services\EscrowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(protected EscrowService $escrowService) {}
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
        $order = Order::with(['service', 'freelancer', 'client', 'review', 'payments'])
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
     * Client meminta revisi atas hasil pekerjaan freelancer.
     *
     * Syarat:
     * - Hanya client pemilik order yang boleh meminta revisi
     * - Status order harus 'delivered' (sudah dikirim freelancer)
     * - revision_count harus < revision_limit
     *
     * Setelah revisi: status kembali ke 'revision', counter bertambah.
     * Jika sudah mencapai limit, tombol revisi dinonaktifkan di view.
     */
    public function requestRevision(string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        // Otorisasi: hanya client pemilik order
        abort_unless(auth()->id() === $order->client_id, 403, 'Akses ditolak.');

        // Pastikan order berstatus delivered
        if ($order->status !== 'delivered') {
            return redirect()->back()
                ->with('error', 'Revisi hanya bisa diminta saat hasil pekerjaan sudah terkirim.');
        }

        // Cek batas revisi
        if ($order->revision_count >= $order->revision_limit) {
            return redirect()->back()
                ->with('error', "Batas revisi ({$order->revision_limit}x) sudah tercapai. Silakan terima atau hubungi freelancer.");
        }

        // Increment counter dan ubah status ke 'revision'
        $order->update([
            'status'         => 'revision',
            'revision_count' => $order->revision_count + 1,
        ]);

        return redirect()->back()
            ->with('success', "Permintaan revisi ke-{$order->revision_count} berhasil dikirim ke freelancer.");
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
        if (! in_array($order->status, ['delivered', 'revision'])) {
            return redirect()->back()
                ->with('error', 'Pesanan ini belum dikirim oleh freelancer.');
        }

        $validated = $request->validated();

        DB::transaction(function () use ($order, $validated) {
            // 1. Update status order menjadi completed
            $order->update([
                'status'       => 'completed',
                'completed_at' => now(),
                'escrow_released_at' => now(), // guard: sudah dilepas
            ]);

            // 2. Simpan review dari client (hanya jika belum ada review)
            if (! $order->review) {
                Review::create([
                    'order_id'  => $order->id,
                    'client_id' => auth()->id(),
                    'rating'    => $validated['rating'],
                    'comment'   => $validated['comment'] ?? null,
                ]);
            }

            // 3. Lepas dana escrow ke wallet freelancer via EscrowService
            //    (potong 8% fee platform, catat ledger, idempotent)
            $this->escrowService->releaseToFreelancer($order, 'manual_accept');

            // 4. Notifikasi ke freelancer: order selesai + dana masuk
            $order->freelancer->notify(new OrderCompletedNotification($order));
        });

        return redirect()->route('pesanan.detail', ['id' => $order->id])
            ->with('success', 'Pesanan diterima! Terima kasih atas penilaian Anda. Dana telah diteruskan ke freelancer.');
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
     * - Status order harus 'in_progress' atau 'revision' (re-submit setelah revisi)
     *
     * Setelah submit: status berubah menjadi 'delivered'.
     */
    public function submitResult(SubmitResultRequest $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        // Otorisasi: hanya freelancer yang mengerjakan order ini
        abort_unless(auth()->id() === $order->freelancer_id, 403);

        // Pastikan order sedang dalam proses pengerjaan atau revisi
        if (! in_array($order->status, ['in_progress', 'revision', 'paid'])) {
            return redirect()->back()
                ->with('error', 'Pesanan ini tidak dalam status pengerjaan atau revisi.');
        }

        $validated = $request->validated();

        // Update link hasil, ubah status ke delivered, catat submitted_at
        $order->update([
            'freelancer_result_link' => $validated['freelancer_result_link'],
            'status'                 => 'delivered',
            'submitted_at'           => now(), // acuan waktu 48-jam auto-complete
        ]);

        // Notifikasi ke client: freelancer sudah kirim hasil
        $order->client->notify(new FreelancerSubmitNotification($order->load(['service', 'client', 'freelancer'])));

        return redirect()->back()
            ->with('success', 'Hasil pekerjaan berhasil dikirim. Menunggu konfirmasi client.');
    }
}
