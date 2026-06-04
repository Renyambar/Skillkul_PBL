<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin\CategoryController
 *
 * CRUD untuk kategori jasa layanan marketplace.
 * Soft delete digunakan agar data historis tidak hilang.
 */
class CategoryController extends Controller
{
    /**
     * Daftar semua kategori (termasuk yang sudah dihapus).
     */
    public function index(): View
    {
        $categories = Category::withCount('services')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Form buat kategori baru.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'icon'        => ['nullable', 'string', 'max:50'],
        ], [
            'name.unique' => 'Nama kategori ini sudah ada.',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori \"{$validated['name']}\" berhasil ditambahkan.");
    }

    /**
     * Form edit kategori.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update data kategori.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string', 'max:255'],
            'icon'        => ['nullable', 'string', 'max:50'],
        ], [
            'name.unique' => 'Nama kategori ini sudah digunakan.',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori \"{$category->name}\" berhasil diperbarui.");
    }

    /**
     * Soft delete kategori.
     * Kategori yang dihapus tidak akan tampil di dropdown freelancer,
     * tapi data historis jasa yang sudah dibuat tetap aman.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Cegah hapus kategori yang masih memiliki jasa aktif
        $activeServicesCount = $category->services()->where('is_active', true)->count();

        if ($activeServicesCount > 0) {
            return redirect()->back()
                ->with('error', "Tidak dapat menghapus kategori \"{$category->name}\" karena masih ada {$activeServicesCount} jasa aktif yang menggunakannya.");
        }

        $category->delete(); // Soft delete

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori \"{$category->name}\" berhasil dihapus.");
    }
}
