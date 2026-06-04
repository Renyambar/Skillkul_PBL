<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptOrderRequest;
use App\Http\Requests\SubmitResultRequest;
use App\Models\Order;
use App\Models\OrderRevision;
use App\Models\Review;
use App\Notifications\FreelancerSubmitNotification;
use App\Notifications\OrderCompletedNotification;
use App\Notifications\RefundGeneratedNotification;
use App\Notifications\RevisionRequestedNotification;
use App\Services\EscrowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(protected EscrowService $escrowService) {}

    // ─── Portal Klien ────────────────────────────────────────

    /**
     * Daftar pesanan milik client yang sedang login.
     *
     * Tampilkan dua grup:
     * - $pendingOrders: status pending/waiting_payment (tampil terpisah dengan tombol bayar)
     * - $activeOrders: pesanan aktif yang sudah dibayar/selesai
     */
    public function clientOrders(): View
    {
        $activeOrders = Order::with(['service', 'freelancer'])
            ->where('client_id', auth()->id())
            ->whereNotIn('status', ['pending', 'waiting_payment'])
            ->latest()
            ->paginate(10, ['*'], 'active');

        $pendingOrders = Order::with(['service', 'freelancer'])
            ->where('client_id', auth()->id())
            ->whereIn('status', ['pending', 'waiting_payment'])
            ->latest()
            ->get();

        return view('orders.index', compact('activeOrders', 'pendingOrders'));
    }

    /**
     * Detail pesanan.
     * Dapat diakses oleh client pemilik order ATAU freelancer yang mengerjakan.
     */
    public function show(string $id): View
    {
        $order = Order::with(['service', 'freelancer', 'client', 'review', 'payments', 'escrow', 'revisions.requester'])
            ->findOrFail($id);

        abort_unless(
            auth()->id() === $order->client_id || auth()->id() === $order->freelancer_id,
            403,
            'Anda tidak memiliki akses ke pesanan ini.'
        );

        // Hitung sisa waktu batalkan (12 jam sejak bayar)
        $paidPayment    = $order->payments->where('payment_status', 'settlement')->first()
                       ?? $order->payments->where('payment_status', 'capture')->first();
        $paidAt         = $paidPayment?->paid_at ?? null;
        $cancelDeadline = $paidAt?->addHours(12);
        $canCancel      = in_array($order->status, ['paid', 'in_progress'])
                       && $cancelDeadline
                       && now()->lessThan($cancelDeadline);
        $cancelHoursLeft = $cancelDeadline ? max(0, now()->diffInMinutes($cancelDeadline, false)) : 0;

        return view('orders.show', compact('order', 'canCancel', 'cancelDeadline', 'cancelHoursLeft'));
    }

    /**
     * Client membatalkan pesanan (maksimal 12 jam setelah bayar).
     *
     * Alur:
     * 1. Validasi: pemilik order, status paid/in_progress, dalam 12 jam
     * 2. DB::transaction: update status canceled, refundToClient()
     * 3. Notifikasi refund ke client
     */
    public function cancelOrder(string $id): RedirectResponse
    {
        $order = Order::with(['client', 'freelancer', 'payments', 'escrow'])->findOrFail($id);

        abort_unless(auth()->id() === $order->client_id, 403, 'Akses ditolak.');

        if (! in_array($order->status, ['paid', 'in_progress'])) {
            return redirect()->back()
                ->with('error', 'Pesanan tidak dapat dibatalkan karena statusnya sudah berubah.');
        }

        $paidPayment    = $order->payments->where('payment_status', 'settlement')->first()
                       ?? $order->payments->where('payment_status', 'capture')->first();
        $paidAt         = $paidPayment?->paid_at ?? null;
        $cancelDeadline = $paidAt?->addHours(12);

        if (! $cancelDeadline || now()->greaterThanOrEqualTo($cancelDeadline)) {
            return redirect()->back()
                ->with('error', 'Batas waktu pembatalan (12 jam setelah pembayaran) sudah lewat.');
        }

        DB::transaction(function () use ($order) {
            $order->update([
                'status'       => 'canceled',
                'cancelled_at' => now(),
            ]);

            $this->escrowService->refundToClient($order, 'refund_cancel');
            $order->client->notify(new RefundGeneratedNotification($order->load(['service', 'client'])));
        });

        return redirect()->route('pesanan.klien')
            ->with('success', 'Pesanan berhasil dibatalkan. Dana Rp ' . number_format($order->total_price, 0, ',', '.') . ' telah dikembalikan ke Wallet SkillKul Anda.');
    }

    /**
     * Client meminta revisi atas hasil pekerjaan freelancer.
     * Menyimpan catatan revisi ke tabel order_revisions.
     */
    public function requestRevision(Request $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        abort_unless(auth()->id() === $order->client_id, 403, 'Akses ditolak.');

        if ($order->status !== 'delivered') {
            return redirect()->back()
                ->with('error', 'Revisi hanya bisa diminta saat hasil pekerjaan sudah terkirim.');
        }

        if ($order->revision_count >= $order->revision_limit) {
            return redirect()->back()
                ->with('error', "Batas revisi ({$order->revision_limit}x) sudah tercapai.");
        }

        $validated = $request->validate([
            'notes'      => ['required', 'string', 'min:10', 'max:2000'],
            'drive_link' => ['nullable', 'url', 'max:500'],
        ], [
            'notes.required' => 'Catatan revisi wajib diisi.',
            'notes.min'      => 'Catatan revisi minimal 10 karakter.',
            'drive_link.url' => 'Link Google Drive harus berupa URL yang valid.',
        ]);

        DB::transaction(function () use ($order, $validated) {
            $newRevisionCount = $order->revision_count + 1;

            // Simpan catatan revisi ke tabel order_revisions
            OrderRevision::create([
                'order_id'        => $order->id,
                'requested_by'    => auth()->id(),
                'notes'           => $validated['notes'],
                'drive_link'      => $validated['drive_link'] ?? null,
                'revision_number' => $newRevisionCount,
            ]);

            // Update status dan counter di tabel orders
            $order->update([
                'status'         => 'revision',
                'revision_count' => $newRevisionCount,
            ]);
        });

        // Notifikasi ke freelancer (jika class ada)
        if (class_exists('App\Notifications\RevisionRequestedNotification')) {
            $order->freelancer->notify(new RevisionRequestedNotification($order->load(['service', 'client'])));
        }

        return redirect()->back()
            ->with('success', "Permintaan revisi ke-{$order->revision_count} berhasil dikirim ke freelancer.");
    }

    /**
     * Client menerima hasil pekerjaan dan memberikan review + rating.
     */
    public function acceptOrder(AcceptOrderRequest $request, string $id): RedirectResponse
    {
        $order = Order::with('freelancer')->findOrFail($id);

        abort_unless(auth()->id() === $order->client_id, 403);

        if (! in_array($order->status, ['delivered', 'revision'])) {
            return redirect()->back()
                ->with('error', 'Pesanan ini belum dikirim oleh freelancer.');
        }

        $validated = $request->validated();

        DB::transaction(function () use ($order, $validated) {
            $order->update([
                'status'             => 'completed',
                'completed_at'       => now(),
                'escrow_released_at' => now(),
            ]);

            if (! $order->review) {
                Review::create([
                    'order_id'  => $order->id,
                    'client_id' => auth()->id(),
                    'rating'    => $validated['rating'],
                    'comment'   => $validated['comment'] ?? null,
                ]);
            }

            $this->escrowService->releaseToFreelancer($order, 'manual_accept');
            $order->freelancer->notify(new OrderCompletedNotification($order));
        });

        return redirect()->route('pesanan.detail', ['id' => $order->id])
            ->with('success', 'Pesanan diterima! Dana telah diteruskan ke freelancer.');
    }

    // ─── Portal Freelancer ───────────────────────────────────

    /**
     * Daftar pesanan yang dikerjakan oleh freelancer yang sedang login.
     * Hanya tampilkan pesanan yang sudah dibayar (bukan pending).
     */
    public function freelancerOrders(): View
    {
        $orders = Order::with(['service', 'client'])
            ->where('freelancer_id', auth()->id())
            ->whereNotIn('status', ['pending', 'waiting_payment'])
            ->latest()
            ->paginate(10);

        return view('freelancer.orders.index', compact('orders'));
    }

    /**
     * Freelancer mengirim link hasil pekerjaan.
     */
    public function submitResult(SubmitResultRequest $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        abort_unless(auth()->id() === $order->freelancer_id, 403);

        if (! in_array($order->status, ['in_progress', 'revision', 'paid'])) {
            return redirect()->back()
                ->with('error', 'Pesanan ini tidak dalam status pengerjaan atau revisi.');
        }

        $validated = $request->validated();

        $order->update([
            'freelancer_result_link' => $validated['freelancer_result_link'],
            'status'                 => 'delivered',
            'submitted_at'           => now(),
        ]);

        $order->client->notify(new FreelancerSubmitNotification($order->load(['service', 'client', 'freelancer'])));

        return redirect()->back()
            ->with('success', 'Hasil pekerjaan berhasil dikirim. Menunggu konfirmasi client.');
    }
}
