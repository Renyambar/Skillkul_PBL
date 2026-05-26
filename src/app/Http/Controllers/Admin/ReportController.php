<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin\ReportController
 *
 * Memungkinkan admin untuk:
 * - Melihat semua laporan yang masuk
 * - Melihat detail laporan beserta context order-nya
 * - Menyelesaikan atau menolak laporan dengan catatan admin
 */
class ReportController extends Controller
{
    /**
     * Tampilkan daftar semua laporan dengan filter.
     */
    public function index(Request $request): View
    {
        $query = Report::with(['reporter', 'reported', 'order'])
            ->latest();

        // Filter berdasarkan status laporan
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Pencarian berdasarkan nama pelapor atau yang dilaporkan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('reporter', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('reported', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $reports = $query->paginate(15)->withQueryString();

        $stats = [
            'total'       => Report::count(),
            'pending'     => Report::where('status', 'pending')->count(),
            'ditinjau'    => Report::where('status', 'ditinjau')->count(),
            'diselesaikan'=> Report::where('status', 'diselesaikan')->count(),
            'ditolak'     => Report::where('status', 'ditolak')->count(),
        ];

        return view('admin.laporan.index', compact('reports', 'stats'));
    }

    /**
     * Tampilkan detail satu laporan.
     */
    public function show(Report $report): View
    {
        $report->load(['reporter', 'reported', 'order.service']);

        // Tandai laporan sedang ditinjau jika masih pending
        if ($report->status === 'pending') {
            $report->update(['status' => 'ditinjau']);
        }

        return view('admin.laporan.show', compact('report'));
    }

    /**
     * Selesaikan atau tolak laporan.
     *
     * Admin memberikan catatan dan memilih tindakan:
     * - 'diselesaikan': laporan valid, tindakan diambil (e.g., suspend user)
     * - 'ditolak': laporan tidak valid
     *
     * Jika action = 'suspend', akun yang dilaporkan dinonaktifkan.
     */
    public function resolve(Request $request, Report $report): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'action'      => ['required', 'in:diselesaikan,ditolak'],
            'admin_notes' => ['required', 'string', 'max:2000'],
        ]);

        // Update laporan
        $report->update([
            'status'      => $request->action,
            'admin_notes' => $request->admin_notes,
        ]);

        // Jika laporan diselesaikan DAN ada opsi suspend, nonaktifkan akun
        if ($request->action === 'diselesaikan' && $request->boolean('suspend_user')) {
            $report->reported->update(['is_active' => false]);
        }

        $actionLabel = $request->action === 'diselesaikan' ? 'diselesaikan' : 'ditolak';

        return redirect()->route('admin.laporan.index')
            ->with('success', "Laporan berhasil {$actionLabel}.");
    }
}
