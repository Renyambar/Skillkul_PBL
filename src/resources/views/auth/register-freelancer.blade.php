<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SkillKul') }} — Daftar sebagai Pekerja Lepas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="font-sans antialiased bg-brand-light dark:bg-brand-darkbg flex flex-col min-h-screen transition-colors duration-300">

    <div class="flex-grow flex items-center justify-center p-6">
        {{--
            Alpine.js x-data untuk mengelola state:
            - verification: null | 'college' | 'nim'
        --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl border border-gray-100 dark:border-brand-darkborder transition-colors duration-300"
             x-data="{
                 verification: '{{ old('_verification_type', '') }}',
                 setVerification(type) {
                     this.verification = type;
                 }
             }">

            {{-- Panel Kiri --}}
            <div class="hidden md:flex flex-col justify-center w-5/12 p-12 bg-brand-primary dark:bg-indigo-900 text-white relative overflow-hidden flex-shrink-0 transition-colors duration-300">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-10"></div>
                <a href="{{ route('register') }}" class="relative z-10 inline-flex items-center gap-2 text-indigo-200 dark:text-indigo-300 hover:text-white text-sm font-medium mb-10 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Ubah pilihan peran
                </a>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight relative z-10">SkillKul</h1>
                <h2 class="text-4xl font-extrabold mb-6 leading-tight tracking-tight relative z-10">
                    Monetisasi<br>Keahlian Anda
                </h2>
                <p class="text-indigo-200 dark:text-indigo-300 mb-10 text-sm leading-relaxed relative z-10">
                    Khusus untuk mahasiswa aktif. Verifikasi identitas Anda untuk mulai menerima pesanan.
                </p>

                <div class="space-y-3 relative z-10">
                    <div class="bg-white/10 rounded-2xl p-4 flex gap-3 items-center border border-white/10">
                        <div class="text-green-300 bg-white/10 p-2 rounded-lg flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Verifikasi Mahasiswa</h3>
                            <p class="text-xs text-indigo-200 dark:text-indigo-300 mt-0.5">Via email .ac.id atau NIM</p>
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-2xl p-4 flex gap-3 items-center border border-white/10">
                        <div class="text-yellow-300 bg-white/10 p-2 rounded-lg flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Portofolio Otomatis</h3>
                            <p class="text-xs text-indigo-200 dark:text-indigo-300 mt-0.5">Ubah proyek menjadi aset profesional</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Kanan --}}
            <div class="w-full md:w-7/12 p-8 md:p-14 flex flex-col justify-center bg-white dark:bg-brand-darksurface overflow-y-auto transition-colors duration-300">

                {{-- Back (mobile) --}}
                <a href="{{ route('register') }}" class="md:hidden inline-flex items-center gap-1 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 mb-6 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>

                {{-- Badge --}}
                <div class="inline-flex items-center gap-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-brand-primary dark:text-indigo-400 text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4 self-start transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Pekerja Lepas
                </div>

                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-1 tracking-tight">Daftar sebagai Pekerja Lepas</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Langkah 1 dari 2 — Pilih metode verifikasi mahasiswa.</p>

                {{-- ════════════════════════════════════════════════════════════
                     LANGKAH 1: Pilihan Verifikasi
                     ════════════════════════════════════════════════════════════ --}}
                <div x-show="verification === ''" x-transition.opacity class="space-y-4">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                        Apakah Anda memiliki email mahasiswa (<span class="text-brand-primary dark:text-indigo-400 font-bold">.ac.id</span>)?
                    </p>

                    {{-- Pilihan: YA — Email Kampus --}}
                    <button type="button" id="btn-choice-college"
                        @click="setVerification('college')"
                        class="group w-full text-left flex items-center gap-4 p-5 rounded-2xl border-2 border-gray-100 dark:border-gray-800 hover:border-brand-primary dark:hover:border-indigo-500 bg-white dark:bg-gray-800/30 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-all duration-200">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 group-hover:bg-brand-primary dark:group-hover:bg-indigo-600 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-6 h-6 text-brand-primary dark:text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 dark:text-white text-sm">Ya, saya punya email kampus</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar menggunakan email <span class="font-semibold text-gray-700 dark:text-gray-300">nama@mahasiswa.kampus.ac.id</span></p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 group-hover:text-brand-primary dark:group-hover:text-indigo-400 flex-shrink-0 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- Pilihan: TIDAK — NIM --}}
                    <button type="button" id="btn-choice-nim"
                        @click="setVerification('nim')"
                        class="group w-full text-left flex items-center gap-4 p-5 rounded-2xl border-2 border-gray-100 dark:border-gray-800 hover:border-brand-primary dark:hover:border-indigo-500 bg-white dark:bg-gray-800/30 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-all duration-200">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 group-hover:bg-brand-primary dark:group-hover:bg-indigo-600 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-6 h-6 text-brand-primary dark:text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 dark:text-white text-sm">Tidak, saya daftar dengan NIM</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gunakan NIM dan email pribadi Anda</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 group-hover:text-brand-primary dark:group-hover:text-indigo-400 flex-shrink-0 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <p class="text-center text-sm text-gray-500 dark:text-gray-400 pt-2">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-brand-primary dark:text-indigo-400 hover:text-brand-dark dark:hover:text-indigo-300 transition-colors">Masuk di sini</a>
                    </p>
                </div>

                {{-- ════════════════════════════════════════════════════════════
                     FORM A: Pekerja Lepas via Email Kampus (.ac.id)
                     ════════════════════════════════════════════════════════════ --}}
                <div x-show="verification === 'college'" x-transition.opacity style="display:none;">
                    {{-- Back to choice --}}
                    <button type="button" @click="setVerification('')"
                        class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 mb-5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Ubah pilihan verifikasi
                    </button>

                    <div class="inline-flex items-center gap-1.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Verifikasi via Email Kampus
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 leading-relaxed">Email kampus Anda (<span class="font-semibold text-brand-primary dark:text-indigo-400">.ac.id</span>) berfungsi sebagai bukti status mahasiswa.</p>

                    <form method="POST" action="{{ route('register.freelancer.college') }}" class="space-y-4" id="form-freelancer-college">
                        @csrf
                        {{-- Hidden field to restore tab after validation error --}}
                        <input type="hidden" name="_verification_type" value="college">

                        <div>
                            <label for="name_college" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                            <input id="name_college" type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Masukkan nama lengkap"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="email_college" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Email Kampus</label>
                            <input id="email_college" type="email" name="email" value="{{ old('email') }}" required
                                placeholder="nama@mahasiswa.kampus.ac.id"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            <p class="mt-1 text-[10px] text-indigo-500 dark:text-indigo-400 font-medium">⚠ Wajib menggunakan domain .ac.id</p>
                            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password_college" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Kata Sandi</label>
                                <input id="password_college" type="password" name="password" required autocomplete="new-password"
                                    placeholder="Min. 8 karakter"
                                    class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                            </div>
                            <div>
                                <label for="password_confirmation_college" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Konfirmasi Sandi</label>
                                <input id="password_confirmation_college" type="password" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Ulangi sandi"
                                    class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" id="btn-submit-college"
                                class="w-full flex justify-center items-center gap-2 py-4 px-4 rounded-2xl shadow-lg shadow-indigo-900/20 text-sm font-bold text-white bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-700 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary dark:focus:ring-offset-gray-900">
                                Daftar & Verifikasi Email
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ════════════════════════════════════════════════════════════
                     FORM B: Pekerja Lepas via NIM
                     ════════════════════════════════════════════════════════════ --}}
                <div x-show="verification === 'nim'" x-transition.opacity style="display:none;">
                    {{-- Back to choice --}}
                    <button type="button" @click="setVerification('')"
                        class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 mb-5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Ubah pilihan verifikasi
                    </button>

                    <div class="inline-flex items-center gap-1.5 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                        </svg>
                        Verifikasi via NIM
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 leading-relaxed">
                        Masukkan NIM Anda sebagai bukti status mahasiswa.
                        <span class="font-medium text-gray-700 dark:text-gray-300">Format: <code class="bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs font-mono">24410700001</code></span>
                    </p>

                    <form method="POST" action="{{ route('register.freelancer.nim') }}" class="space-y-4" id="form-freelancer-nim">
                        @csrf
                        <input type="hidden" name="_verification_type" value="nim">

                        <div>
                            <label for="name_nim" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                            <input id="name_nim" type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Masukkan nama lengkap"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="nim" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">
                                NIM <span class="text-gray-400 dark:text-gray-500 font-normal normal-case tracking-normal">(Nomor Induk Mahasiswa)</span>
                            </label>
                            <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required
                                placeholder="Contoh: 24410700001"
                                maxlength="11"
                                pattern="\d{11}"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 font-mono tracking-widest transition-colors">
                            <p class="mt-1 text-[10px] text-gray-400 dark:text-gray-500">11 digit angka · 2 digit tahun masuk · 41070 kode institusi · 4 digit nomor urut</p>
                            <x-input-error :messages="$errors->get('nim')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="email_nim" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Email Pribadi</label>
                            <input id="email_nim" type="email" name="email" value="{{ old('email') }}" required
                                placeholder="contoh@gmail.com"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            <p class="mt-1 text-[10px] text-gray-400 dark:text-gray-500">Link verifikasi akan dikirim ke email ini.</p>
                            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password_nim" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Kata Sandi</label>
                                <input id="password_nim" type="password" name="password" required autocomplete="new-password"
                                    placeholder="Min. 8 karakter"
                                    class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                            </div>
                            <div>
                                <label for="password_confirmation_nim" class="block text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">Konfirmasi Sandi</label>
                                <input id="password_confirmation_nim" type="password" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Ulangi sandi"
                                    class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-3 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" id="btn-submit-nim"
                                class="w-full flex justify-center items-center gap-2 py-4 px-4 rounded-2xl shadow-lg shadow-indigo-900/20 text-sm font-bold text-white bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-700 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary dark:focus:ring-offset-gray-900">
                                Daftar & Verifikasi Email
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Alpine.js: Auto-restore form tab on validation error --}}
    @if(old('_verification_type') === 'college' || $errors->has('email') && str_contains(old('email', ''), '.ac.id'))
    <script>
        document.addEventListener('alpine:init', () => {});
    </script>
    @endif

</body>
</html>
