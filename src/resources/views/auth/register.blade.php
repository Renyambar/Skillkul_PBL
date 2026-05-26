<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SkillKul') }} - Daftar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-brand-light flex flex-col min-h-screen">

    <div class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl min-h-[650px] border border-gray-100">

            <div class="hidden md:flex flex-col justify-center w-1/2 p-12 bg-brand-primary text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-10"></div>
                <h1 class="text-3xl font-extrabold mb-10 tracking-tight relative z-10">SkillKul</h1>
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight tracking-tight relative z-10">Menjembatani Dunia<br>Akademis & Industri</h2>
                <p class="text-indigo-200 mb-10 text-base leading-relaxed relative z-10">
                    Platform kurasi untuk mahasiswa bertalenta dalam membangun portofolio profesional dan karier wirausaha.
                </p>

                <div class="space-y-4 relative z-10">
                    <div class="bg-white/10 rounded-2xl p-4 flex gap-4 items-center border border-white/10 backdrop-blur-sm shadow-sm">
                        <div class="text-green-400 bg-white/10 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Verifikasi Akademik</h3>
                            <p class="text-xs text-indigo-200 mt-0.5">Akses eksklusif untuk pemilik email .ac.id</p>
                        </div>
                    </div>

                    <div class="bg-white/10 rounded-2xl p-4 flex gap-4 items-center border border-white/10 backdrop-blur-sm shadow-sm">
                        <div class="text-white bg-white/10 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Auto-Portfolio AI</h3>
                            <p class="text-xs text-indigo-200 mt-0.5">Ubah tugas kuliah menjadi aset profesional</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-14 flex flex-col justify-center bg-white overflow-y-auto">
                <h2 class="text-3xl font-bold text-brand-primary mb-2 tracking-tight">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm mb-6">Silakan daftar untuk memulai perjalanan profesional Anda.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ selectedRole: '{{ old('role') }}' }">
                    @csrf

                    <div>
                        <label for="name" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Masukkan nama lengkap"
                            class="block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="email" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Email Kampus</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@mahasiswa.polinema.ac.id"
                            class="block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400">
                        <p class="mt-1 text-[10px] text-indigo-500 font-medium">⚠ Harus menggunakan email kampus (.ac.id)</p>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone_number" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Nomor Telepon</label>
                            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required
                                placeholder="08xxxxxxxxxx"
                                class="block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400">
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
                        </div>

                        <div>
                            <label for="role" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Daftar Sebagai</label>
                            <select id="role" name="role" required x-model="selectedRole"
                                class="block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium">
                                <option value="" disabled selected>Pilih peran</option>
                                <option value="client">Klien</option>
                                <option value="freelancer">Freelancer</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-1" />
                        </div>
                    </div>

                    {{-- NIM: hanya tampil untuk Freelancer --}}
                    <div x-show="selectedRole === 'freelancer'" x-transition style="display:none;">
                        <label for="nim" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">
                            NIM <span class="text-gray-400 font-normal normal-case tracking-normal">(Nomor Induk Mahasiswa)</span>
                        </label>
                        <input id="nim" type="text" name="nim" value="{{ old('nim') }}"
                            placeholder="Contoh: 2241760001"
                            class="block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400">
                        <p class="mt-1 text-[10px] text-gray-400">Opsional — dapat dilengkapi nanti melalui profil Anda.</p>
                        <x-input-error :messages="$errors->get('nim')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Kata Sandi</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="••••••••"
                                class="block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-1.5">Konfirmasi Kata Sandi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                placeholder="••••••••"
                                class="block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-3 px-4 font-medium placeholder-gray-400">
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-indigo-900/20 text-sm font-bold text-white bg-brand-primary hover:bg-brand-dark hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary">
                            Daftar<svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <p class="mt-4 text-center text-sm font-medium text-gray-500">
                        Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:text-brand-dark">Masuk di sini</a>
                    </p>

                    <a href="{{ route('home') }}" class="mt-3 w-full flex justify-center items-center py-3 px-4 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-600 bg-gray-50 hover:bg-gray-100 transition-all">
                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Batalkan & Kembali ke Beranda
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')
</body>
</html>