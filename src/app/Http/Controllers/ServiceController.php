<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // ─── Katalog: Daftar semua jasa aktif (publik) ───────────
    public function index(Request $request)
    {
        $query = Service::with(['freelancer', 'category'])
            ->where('is_active', true)
            ->latest();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('freelancer', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter tipe
        if ($request->filled('type') && in_array($request->type, ['non_project', 'project'])) {
            $query->where('type', $request->type);
        }

        // Filter kategori
        if ($request->filled('category') && $request->category !== 'semua') {
            $query->whereHas('category', fn($c) => $c->where('name', $request->category));
        }

        $services   = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('services.index', compact('services', 'categories'));
    }

    // ─── Detail jasa (publik) ─────────────────────────────────
    public function show($id)
    {
        $service = Service::with(['freelancer', 'category', 'reviews'])->findOrFail($id);

        // Cek apakah freelancer sedang sibuk (mode ujian / ada order in_progress)
        $isBusy = $service->freelancer?->is_busy ?? false;

        return view('services.show', compact('service', 'isBusy'));
    }

    // ─── Daftar jasa milik freelancer (dinamis) ──────────────
    public function myServices()
    {
        $services = Service::with(['category', 'orders'])
            ->where('freelancer_id', auth()->id())
            ->latest()
            ->get();

        $stats = [
            'total'    => $services->count(),
            'aktif'    => $services->where('is_active', true)->count(),
            'nonaktif' => $services->where('is_active', false)->count(),
            'pesanan'  => $services->sum(fn($s) => $s->orders->count()),
        ];

        return view('freelancer.services.index', compact('services', 'stats'));
    }

    // ─── Form buka jasa (freelancer) ─────────────────────────
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('freelancer.services.create', compact('categories'));
    }

    // ─── Simpan jasa baru (freelancer) ────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|in:non_project,project',
            'price'       => 'required|numeric|min:0',
            'price_max'   => 'nullable|numeric|min:0|gt:price',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['freelancer_id'] = auth()->id();
        $validated['is_active']     = true;

        Service::create($validated);

        return redirect()->route('freelancer.jasa.index')
            ->with('success', 'Jasa berhasil dipublikasikan!');
    }

    // ─── Form edit jasa (freelancer) ─────────────────────────
    public function edit(Service $service)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($service->freelancer_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit jasa ini.');
        }

        $categories = Category::orderBy('name')->get();
        return view('freelancer.services.edit', compact('service', 'categories'));
    }

    // ─── Simpan perubahan jasa (freelancer) ───────────────────
    public function update(Request $request, Service $service)
    {
        // Pastikan hanya pemilik yang bisa update
        if ($service->freelancer_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit jasa ini.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|in:non_project,project',
            'price'       => 'required|numeric|min:0',
            'price_max'   => 'nullable|numeric|min:0|gt:price',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('freelancer.jasa.index')
            ->with('success', 'Jasa berhasil diperbarui!');
    }

    // ─── Hapus jasa (freelancer) ──────────────────────────────
    public function destroy(Service $service)
    {
        // Pastikan hanya pemilik yang bisa hapus
        if ($service->freelancer_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus jasa ini.');
        }

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('freelancer.jasa.index')
            ->with('success', 'Jasa berhasil dihapus.');
    }
}

