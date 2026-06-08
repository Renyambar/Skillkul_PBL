<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SkillKul') }} — Daftar sebagai Klien</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-brand-light flex flex-col min-h-screen">

    <div class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl min-h-[600px] border border-gray-100">

            {{-- Panel Kiri: Ilustrasi --}}
            <div class="hidden md:flex flex-col justify-center w-5/12 p-12 bg-brand-primary text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-10"></div>
                <a href="{{ route('register') }}" class="relative z-10 inline-flex items-center gap-2 text-indigo-200 hover:text-white text-sm font-medium mb-10 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Ubah pilihan peran
                </a>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight relative z-10">SkillKul</h1>
                <h2 class="text-4xl font-extrabold mb-6 leading-tight tracking-tight relative z-10">
                    Temukan Talenta<br>Terbaik Kampus
                </h2>
                <p class="text-indigo-200 mb-10 text-sm leading-relaxed relative z-10">
                    Akses ratusan mahasiswa berbakat untuk kebutuhan desain, coding, penulisan, dan banyak lagi.
                </p>

                <div class="space-y-3 relative z-10">
                    <div class="bg-white/10 rounded-2xl p-4 flex gap-3 items-center border border-white/10 backdrop-blur-sm">
                        <div class="text-yellow-300 bg-white/10 p-2 rounded-lg flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Email Bebas</h3>
                            <p class="text-xs text-indigo-200 mt-0.5">Gmail, Yahoo, Outlook — semua diterima</p>
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-2xl p-4 flex gap-3 items-center border border-white/10 backdrop-blur-sm">
                        <div class="text-green-300 bg-white/10 p-2 rounded-lg flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Transaksi Aman</h3>
                            <p class="text-xs text-indigo-200 mt-0.5">Dana dijamin hingga pekerjaan selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Kanan: Form --}}
            <div class="w-full md:w-7/12 p-8 md:p-14 flex flex-col justify-center bg-white overflow-y-auto">
                {{-- Back link (mobile only) --}}
                <a href="{{ route('register') }}" class="md:hidden inline-flex items-center gap-1 text-sm text-gray-400 hover:text-gray-700 mb-6 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>

                {{-- Badge role --}}
                <div class="inline-flex items-center gap-1.5 bg-indigo-50 text-brand-primary text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4 self-start">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Klien
                </div>

                <h2 class="text-3xl font-bold text-gray-900 mb-1 tracking-tight">Buat Akun Klien</h2>
                <p class="text-gray-500 text-sm mb-8">Gunakan email apa saja untuk mendaftar.</p>

                <form method="POST" action="{{ route('register.client.store') }}" class="space-y-5" id="form-register-client">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Masukkan nama lengkap Anda"
                            class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400 transition-colors">
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-widest mb-1.5">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="contoh@gmail.com"
                            class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400 transition-colors">
                        <p class="mt-1 text-[10px] text-gray-400">Gmail, Yahoo, Outlook, atau domain apapun diterima.</p>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    {{-- Password --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-widest mb-1.5">Kata Sandi</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="Min. 8 karakter"
                                class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400 transition-colors">
                            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-widest mb-1.5">Konfirmasi Sandi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Ulangi kata sandi"
                                class="block w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400 transition-colors">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-2">
                        <button type="submit" id="btn-submit-client"
                            class="w-full flex justify-center items-center gap-2 py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-indigo-900/20 text-sm font-bold text-white bg-brand-primary hover:bg-brand-dark hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary">
                            Buat Akun & Verifikasi Email
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>

                    <p class="text-center text-sm font-medium text-gray-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:text-brand-dark transition-colors">Masuk di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
