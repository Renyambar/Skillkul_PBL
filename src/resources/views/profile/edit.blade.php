@php $layout = auth()->user()->role === 'freelancer' ? 'layouts.freelancer' : 'layouts.client'; @endphp
@extends($layout)
@section('title', 'Pengaturan Profil - SkillKul')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Pengaturan Profil</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi akun, keamanan, dan preferensi Anda.</p>
    </div>

    {{-- ============================================ --}}
    {{-- 1. INFORMASI PROFIL --}}
    {{-- ============================================ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-brand-dark">Informasi Profil</h2>
                <p class="text-xs text-gray-500">Perbarui foto, nama, email, dan informasi pribadi Anda.</p>
            </div>
        </div>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('patch')

            {{-- Photo Upload --}}
            <div class="flex items-center gap-5">
                <img src="{{ $user->profile_photo_path ? Storage::url($user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=140c61&color=fff' }}"
                    alt="{{ $user->name }}"
                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=140c61&color=fff';"
                    class="w-20 h-20 rounded-2xl object-cover border-2 border-indigo-100 shadow-sm">
                <div class="flex-1">
                    <label for="profile_photo" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Foto Profil</label>
                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-brand-primary hover:file:bg-indigo-100 transition-all cursor-pointer">
                    <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                    <x-input-error class="mt-1" :messages="$errors->get('profile_photo')" />
                </div>
            </div>

            {{-- Name & Email Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium">
                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                </div>
                <div>
                    <label for="email" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium">
                    <x-input-error class="mt-1" :messages="$errors->get('email')" />

                    @if (method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail())
                        <div class="mt-2 flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-200">Belum Diverifikasi</span>
                            <button form="send-verification" class="text-xs font-bold text-brand-primary hover:text-brand-dark transition-colors underline">Kirim Ulang</button>
                        </div>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 text-xs font-semibold text-green-600">✓ Link verifikasi baru telah dikirim ke email Anda.</p>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Phone & Bio --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="phone_number" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Nomor WhatsApp</label>
                    <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}"
                        placeholder="08xx xxxx xxxx"
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium">
                    <x-input-error class="mt-1" :messages="$errors->get('phone_number')" />
                </div>
                <div>
                    <label for="profile_description" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Bio / Deskripsi Profil</label>
                    <textarea id="profile_description" name="profile_description" rows="3"
                        placeholder="Ceritakan tentang diri Anda..."
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium resize-none">{{ old('profile_description', $user->profile_description) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('profile_description')" />
                </div>
            </div>

            {{-- Save Button --}}
            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm font-semibold text-green-600">✓ Profil berhasil diperbarui!</p>
                @endif
            </div>
        </form>
    </div>

    {{-- ============================================ --}}
    {{-- 2. UBAH KATA SANDI --}}
    {{-- ============================================ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-brand-dark">Ubah Kata Sandi</h2>
                <p class="text-xs text-gray-500">Pastikan akun Anda menggunakan kata sandi yang kuat dan unik.</p>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('put')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="update_password_current_password" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Kata Sandi Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password"
                        placeholder="••••••••"
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                </div>
                <div>
                    <label for="update_password_password" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Kata Sandi Baru</label>
                    <input id="update_password_password" name="password" type="password"
                        placeholder="••••••••"
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                </div>
                <div>
                    <label for="update_password_password_confirmation" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Konfirmasi Kata Sandi</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        placeholder="••••••••"
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Perbarui Kata Sandi
                </button>
                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm font-semibold text-green-600">✓ Kata sandi berhasil diperbarui!</p>
                @endif
            </div>
        </form>
    </div>

    {{-- ============================================ --}}
    {{-- 3. HAPUS AKUN --}}
    {{-- ============================================ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6 md:p-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.072 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-red-700">Area Berbahaya</h2>
                <p class="text-xs text-gray-500">Tindakan ini tidak dapat dibatalkan. Semua data akan dihapus secara permanen.</p>
            </div>
        </div>

        <div class="bg-red-50/50 rounded-xl p-4 border border-red-100 mb-4">
            <p class="text-sm text-red-700 leading-relaxed">Jika akun dihapus, seluruh data dan informasi di dalamnya akan hilang secara permanen. Pastikan Anda telah mengunduh data penting sebelum melanjutkan.</p>
        </div>

        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            Hapus Akun Saya
        </button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.072 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Konfirmasi Penghapusan Akun</h2>
                        <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>

                <p class="text-sm text-gray-600 leading-relaxed mb-5">Semua data termasuk pesanan, riwayat transaksi, dan profil Anda akan dihapus secara permanen. Masukkan kata sandi untuk mengonfirmasi.</p>

                <div>
                    <label for="password" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Kata Sandi</label>
                    <input id="password" name="password" type="password" placeholder="Masukkan kata sandi Anda"
                        class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-red-500 focus:border-red-500 sm:text-sm py-3 px-4 font-medium">
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm">
                        Ya, Hapus Akun Saya
                    </button>
                </div>
            </form>
        </x-modal>
    </div>

</div>
@endsection
