<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CollegeEmail;
use App\Rules\ValidNim;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * RegisteredUserController
 *
 * Menangani registrasi multi-jalur SkillKul:
 *
 * GET  /register               → choose()              — Halaman pilihan role
 * GET  /register/client        → createClient()         — Form registrasi client
 * POST /register/client        → storeClient()          — Proses simpan client
 * GET  /register/freelancer    → createFreelancer()     — Pilihan verifikasi freelancer
 * POST /register/freelancer/college → storeFreelancerCollege() — Freelancer via email .ac.id
 * POST /register/freelancer/nim    → storeFreelancerNim()     — Freelancer via NIM
 */
class RegisteredUserController extends Controller
{
    // ──────────────────────────────────────────────────────────────────────────
    // HALAMAN PILIHAN ROLE
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman pilihan role (client vs freelancer).
     * Route: GET /register
     */
    public function choose(): View
    {
        return view('auth.register-choose');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // ALUR CLIENT
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Tampilkan form registrasi client.
     * Route: GET /register/client
     */
    public function createClient(): View
    {
        return view('auth.register-client');
    }

    /**
     * Proses registrasi client.
     * Route: POST /register/client
     *
     * Ketentuan:
     * - Email bebas (Gmail, Yahoo, Outlook, dll.)
     * - Role otomatis: client
     * - verification_type: none
     * - Setelah register: email verification Laravel
     */
    public function storeClient(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'client',
            'verification_type' => 'none',
            'is_active'         => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // ALUR FREELANCER — PILIHAN VERIFIKASI
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman pilihan verifikasi freelancer.
     * Route: GET /register/freelancer
     *
     * Menampilkan pertanyaan: "Apakah Anda memiliki email mahasiswa (.ac.id)?"
     * dengan toggle Alpine.js untuk menampilkan form yang sesuai.
     */
    public function createFreelancer(): View
    {
        return view('auth.register-freelancer');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // ALUR FREELANCER — VIA EMAIL KAMPUS (.ac.id)
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Proses registrasi freelancer dengan email kampus.
     * Route: POST /register/freelancer/college
     *
     * Ketentuan:
     * - Email wajib domain .ac.id (divalidasi CollegeEmail rule)
     * - Role: freelancer
     * - verification_type: college_email
     */
    public function storeFreelancerCollege(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, new CollegeEmail],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Email kampus ini sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'freelancer',
            'verification_type' => 'college_email',
            'is_active'         => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // ALUR FREELANCER — VIA NIM
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Proses registrasi freelancer dengan NIM.
     * Route: POST /register/freelancer/nim
     *
     * Ketentuan:
     * - NIM wajib format 11-digit dengan kode institusi 41070 (divalidasi ValidNim rule)
     * - NIM harus unik
     * - Email bebas (tidak harus .ac.id)
     * - Role: freelancer
     * - verification_type: nim
     */
    public function storeFreelancerNim(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nim'      => ['required', 'string', new ValidNim, 'unique:users,nim'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nim.unique'   => 'NIM ini sudah terdaftar. Pastikan NIM yang Anda masukkan benar.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'nim'               => $request->nim,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'freelancer',
            'verification_type' => 'nim',
            'is_active'         => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
