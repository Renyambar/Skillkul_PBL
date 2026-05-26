<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CollegeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * Validation enforces:
     * - Email must be a valid college email (.ac.id domain)
     * - Role can only be 'client' or 'freelancer' (not admin — admin is seeded)
     * - NIM is optional at registration (can be completed via onboarding)
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, new CollegeEmail],
            'nim'          => ['nullable', 'string', 'max:20', 'unique:users,nim'],
            'phone_number' => ['required', 'string', 'max:15'],
            'role'         => ['required', 'in:client,freelancer'],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nim.unique' => 'NIM ini sudah terdaftar. Pastikan NIM yang Anda masukkan benar.',
        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'nim'          => $request->nim ?: null,
            'phone_number' => $request->phone_number,
            'role'         => $request->role,
            'password'     => Hash::make($request->password),
            'is_active'    => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
