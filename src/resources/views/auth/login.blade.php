<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SkillKul') }} - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-brand-light flex flex-col min-h-screen">

    <div class="flex-grow flex items-center justify-center p-4 md:p-6">
        <div
            class="bg-white rounded-[32px] shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl border border-gray-100">
            <!-- Left Side (Blue Background) -->
            <div
                class="hidden md:flex flex-col justify-center w-1/2 p-10 bg-brand-primary text-white relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-10">
                </div>
                <h1 class="text-3xl font-extrabold mb-10 tracking-tight relative z-10">SkillKul</h1>
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight tracking-tight relative z-10">
                    Menjembatani Dunia<br>Akademis & Industri</h2>
                <p class="text-indigo-200 mb-10 text-base leading-relaxed relative z-10">
                    Platform kurasi untuk mahasiswa bertalenta dalam membangun portofolio profesional dan karier
                    wirausaha.
                </p>

                <div class="space-y-4 relative z-10">
                    <div
                        class="bg-white/10 rounded-2xl p-4 flex gap-4 items-center border border-white/10 backdrop-blur-sm shadow-sm">
                        <div class="text-green-400 bg-white/10 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Verifikasi Akademik</h3>
                            <p class="text-xs text-indigo-200 mt-0.5">Akses eksklusif untuk pemilik email .ac.id</p>
                        </div>
                    </div>
                    <div
                        class="bg-white/10 rounded-2xl p-4 flex gap-4 items-center border border-white/10 backdrop-blur-sm shadow-sm">
                        <div class="text-white bg-white/10 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Portofolio Otomatis</h3>
                            <p class="text-xs text-indigo-200 mt-0.5">Ubah tugas kuliah menjadi aset profesional</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side (Login Form) -->
            <div
                class="w-full md:w-1/2 p-6 md:p-10 flex flex-col justify-center bg-white relative z-10 overflow-y-auto">
                <h2 class="text-2xl md:text-3xl font-bold text-brand-primary mb-1 tracking-tight">Selamat Datang Kembali
                </h2>
                <p class="text-gray-500 text-sm mb-6">Silakan masuk untuk melanjutkan perjalanan profesional Anda.</p>



                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf


                    <div>
                        <label for="email"
                            class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-lg font-medium">@</span>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                placeholder="contoh@gmail.com"
                                class="pl-12 block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-4 font-medium placeholder-gray-400">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password"
                            class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-2">Kata
                            Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7z">
                                    </path>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="••••••••"
                                class="pl-12 block w-full bg-gray-100 border-transparent text-gray-900 rounded-2xl focus:ring-brand-primary focus:border-brand-primary sm:text-sm py-4 font-medium placeholder-gray-400">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                        <div class="flex justify-end mt-3">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-xs font-bold text-brand-primary hover:text-brand-dark transition-colors">
                                    Lupa Kata Sandi?
                                </a>
                            @endif
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-indigo-900/20 text-sm font-bold text-white bg-brand-primary hover:bg-brand-dark hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary">
                        Masuk
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>

                    <p class="mt-6 text-center text-sm font-medium text-gray-500">
                        Belum memiliki akun? <a href="{{ route('register') }}"
                            class="font-bold text-brand-primary hover:text-brand-dark">Daftar Baru</a>
                    </p>

                    <a href="{{ route('home') }}"
                        class="mt-3 w-full flex justify-center items-center py-3 px-4 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-600 bg-gray-50 hover:bg-gray-100 transition-all">
                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
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