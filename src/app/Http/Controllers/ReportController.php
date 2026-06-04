<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * ReportController (Client-facing)
 *
 * Memungkinkan client untuk melaporkan freelancer atas:
 * - Penipuan (tidak mengerjakan padahal sudah dibayar)
 * - Kualitas buruk (hasil tidak sesuai kesepakatan)
 * - Perilaku tidak pantas
 * - dll.
 *
 * Laporan akan masuk ke dashboard admin untuk ditinjau.
 */
class ReportController extends Controller
{
    /**
     * Tampilkan form pelaporan.
     *
     * Opsional: jika order_id diberikan via query string,
     * form akan diisi otomatis dengan konteks pesanan tersebut.
     */
    public function create(Request $request): View
    {
        $order = null;

        if ($request->filled('order_id')) {
            $order = Order::with(['freelancer', 'service'])
                ->where('client_id', auth()->id())
                ->find($request->order_id);
        }

        return view('reports.create', compact('order'));
    }

    /**
     * Simpan laporan baru ke database.
     *
     * Validasi:
     * - reported_id: user yang dilaporkan harus ada dan bukan diri sendiri
     * - order_id: opsional, tapi jika diisi harus milik pelapor
     * - Satu user hanya bisa melaporkan user yang sama sekali untuk order yang sama
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'reported_id' => ['required', 'exists:users,id', 'different:' . auth()->id()],
            'order_id'    => ['nullable', 'exists:orders,id'],
            'category'    => ['required', 'in:penipuan,tidak_selesai,kualitas_buruk,perilaku_tidak_pantas,lainnya'],
            'description' => ['required', 'string', 'min:30', 'max:2000'],
            'attachment'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'reported_id.different' => 'Anda tidak dapat melaporkan diri sendiri.',
            'description.min'       => 'Deskripsi laporan minimal 30 karakter. Jelaskan kejadian secara detail.',
            'attachment.mimes'      => 'File bukti harus berformat JPG, PNG, atau PDF.',
            'attachment.max'        => 'File bukti maksimal 5MB.',
        ]);

        // Pastikan order (jika ada) memang milik client yang login
        if (! empty($validated['order_id'])) {
            $order = Order::where('id', $validated['order_id'])
                ->where('client_id', auth()->id())
                ->first();

            if (! $order) {
                return redirect()->back()
                    ->withErrors(['order_id' => 'Pesanan yang dipilih tidak ditemukan atau bukan milik Anda.'])
                    ->withInput();
            }
        }

        // Cegah laporan duplikat untuk order yang sama
        $duplicate = Report::where('reporter_id', auth()->id())
            ->where('reported_id', $validated['reported_id'])
            ->when(! empty($validated['order_id']), fn($q) => $q->where('order_id', $validated['order_id']))
            ->exists();

        if ($duplicate) {
            return redirect()->back()
                ->with('error', 'Anda sudah pernah melaporkan pengguna ini untuk pesanan yang sama.')
                ->withInput();
        }

        // Simpan file attachment jika ada
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('reports/attachments', 'public');
        }

        Report::create([
            'reporter_id'     => auth()->id(),
            'reported_id'     => $validated['reported_id'],
            'order_id'        => $validated['order_id'] ?? null,
            'category'        => $validated['category'],
            'description'     => $validated['description'],
            'attachment_path' => $attachmentPath,
            'status'          => 'pending',
        ]);

        return redirect()->route('pesanan.klien')
            ->with('success', 'Laporan Anda telah dikirim ke tim admin SkillKul. Kami akan meninjau dalam 1x24 jam.');
    }
}
