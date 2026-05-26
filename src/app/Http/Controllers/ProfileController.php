<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function show($username): View
    {
        $user = User::where('name', $username)->firstOrFail();
        return view('profile.public', [
            'user' => $user,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $validated['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        unset($validated['profile_photo']);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Toggle exam mode for the user.
     *
     * Hanya mengubah kolom `is_exam_mode` — satu-satunya sumber kebenaran
     * untuk mode ujian. Ketika aktif, semua jasa freelancer disembunyikan
     * dari katalog publik dan tidak bisa menerima pesanan baru.
     */
    public function toggleExamMode(Request $request)
    {
        $user = $request->user();

        $newState = ! $user->is_exam_mode;

        $user->update([
            'is_exam_mode' => $newState,
        ]);

        $message = $newState
            ? 'Mode Ujian diaktifkan. Semua jasa Anda disembunyikan sementara.'
            : 'Mode Ujian dinonaktifkan. Jasa Anda kembali tersedia di katalog.';

        return Redirect::back()->with('success', $message);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
