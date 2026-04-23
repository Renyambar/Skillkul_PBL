<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // ─── Index: Daftar semua jasa (pantau) ───────────────────
    public function index(Request $request)
    {
        $query = Service::with(['freelancer', 'category'])
            ->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('freelancer', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $services   = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        $stats = [
            'total'    => Service::count(),
            'aktif'    => Service::where('is_active', true)->count(),
            'nonaktif' => Service::where('is_active', false)->count(),
            'project'  => Service::where('type', 'project')->count(),
        ];

        return view('admin.services.index', compact('services', 'categories', 'stats'));
    }

    // ─── Show: Detail jasa ───────────────────────────────────
    public function show(Service $service)
    {
        $service->load(['freelancer', 'category', 'orders']);
        return view('admin.services.show', compact('service'));
    }

    // ─── Toggle: Aktifkan / Nonaktifkan ──────────────────────
    public function toggle(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $status = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Jasa \"{$service->title}\" berhasil {$status}.");
    }
}
