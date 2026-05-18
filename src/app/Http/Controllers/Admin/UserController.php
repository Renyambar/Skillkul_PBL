<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin\UserController
 *
 * Hanya untuk monitoring dan manajemen user oleh admin.
 * Admin dapat melihat daftar user, memfilter berdasarkan role/nama,
 * serta men-toggle status aktif akun.
 */
class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user dengan filter & statistik.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // ── Query dasar: semua user, urutkan terbaru ──────────────
        $query = User::latest();

        // Filter berdasarkan role (client / freelancer / admin)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter pencarian: nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Paginasi: 15 user per halaman, pertahankan query string di URL
        $users = $query->paginate(15)->withQueryString();

        // ── Statistik ringkasan ───────────────────────────────────
        $stats = [
            'total'      => User::count(),
            'freelancer' => User::where('role', 'freelancer')->count(),
            'client'     => User::where('role', 'client')->count(),
            'admin'      => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Toggle status aktif / nonaktif akun user.
     *
     * Menggunakan kolom email_verified_at sebagai penanda aktif:
     * - Ada nilai  = akun aktif (terverifikasi)
     * - null       = akun dinonaktifkan oleh admin
     *
     * Catatan: Jika proyek membutuhkan kolom is_active terpisah,
     * tambahkan migrasi & sesuaikan logika di sini.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(User $user): \Illuminate\Http\RedirectResponse
    {
        // Admin tidak bisa menonaktifkan sesama admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak dapat dinonaktifkan.');
        }

        // Toggle: jika sudah verified → null (nonaktif), jika null → now() (aktif)
        $user->update([
            'email_verified_at' => $user->email_verified_at ? null : now(),
        ]);

        $statusLabel = $user->email_verified_at ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun \"{$user->name}\" berhasil {$statusLabel}.");
    }
}
