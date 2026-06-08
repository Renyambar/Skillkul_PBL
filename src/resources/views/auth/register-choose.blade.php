<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SkillKul') }} — Daftar Sebagai</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-brand-light flex flex-col min-h-screen">

    <div class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-4xl">

            {{-- Header --}}
            <div class="text-center mb-12">
                <a href="{{ route('home') }}" class="inline-block mb-6">
                    <span class="text-3xl font-extrabold text-brand-primary tracking-tight">SkillKul</span>
                </a>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">
                    Anda ingin bergabung sebagai apa?
                </h1>
                <p class="text-gray-500 text-base max-w-md mx-auto">
                    Pilih peran yang sesuai. Anda selalu bisa membuat akun baru dengan peran berbeda di kemudian hari.
                </p>
            </div>

            {{-- Kartu Pilihan Role --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Kartu: Mencari Jasa (Klien) --}}
                <a href="{{ route('register.client') }}"
                   class="group relative bg-white rounded-[32px] border-2 border-gray-100 shadow-lg hover:border-brand-primary hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 p-10 flex flex-col items-center text-center cursor-pointer overflow-hidden">

                    {{-- Gradient background on hover --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-[30px]"></div>

                    <div class="relative z-10">
                        {{-- Icon --}}
                        <div class="w-20 h-20 bg-indigo-100 group-hover:bg-brand-primary rounded-3xl flex items-center justify-center mb-6 mx-auto transition-colors duration-300 shadow-md">
                            <svg class="w-10 h-10 text-brand-primary group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>

                        {{-- Title --}}
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">
                            Saya Mencari Jasa
                        </h2>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">
                            Temukan mahasiswa berbakat untuk mengerjakan desain, coding, penulisan, dan berbagai kebutuhan Anda.
                        </p>

                        {{-- Bullets --}}
                        <ul class="text-left space-y-2 mb-8">
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Daftar menggunakan email apa saja
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Akses katalog jasa mahasiswa
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Bayar aman dengan Midtrans
                            </li>
                        </ul>

                        {{-- CTA Button --}}
                        <div class="w-full flex items-center justify-center gap-2 py-3 px-6 bg-gray-100 group-hover:bg-brand-primary rounded-2xl text-sm font-bold text-gray-700 group-hover:text-white transition-all duration-300">
                            Daftar sebagai Klien
                            <svg class="w-4 h-4 -translate-x-1 group-hover:translate-x-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Kartu: Menjual Jasa (Pekerja Lepas) --}}
                <a href="{{ route('register.freelancer') }}"
                   class="group relative bg-white rounded-[32px] border-2 border-gray-100 shadow-lg hover:border-brand-primary hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 p-10 flex flex-col items-center text-center cursor-pointer overflow-hidden">

                    {{-- Gradient background on hover --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-[30px]"></div>

                    {{-- Badge --}}
                    <div class="absolute top-4 right-4 z-20 bg-brand-primary text-white text-[10px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full shadow">
                        Khusus Mahasiswa
                    </div>

                    <div class="relative z-10 pt-4">
                        {{-- Icon --}}
                        <div class="w-20 h-20 bg-indigo-100 group-hover:bg-brand-primary rounded-3xl flex items-center justify-center mb-6 mx-auto transition-colors duration-300 shadow-md">
                            <svg class="w-10 h-10 text-brand-primary group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        {{-- Title --}}
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">
                            Saya Menjual Jasa
                        </h2>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">
                            Jadikan keahlian kuliah Anda sumber penghasilan. Bangun portofolio profesional sambil belajar.
                        </p>

                        {{-- Bullets --}}
                        <ul class="text-left space-y-2 mb-8">
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Verifikasi via email kampus atau NIM
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Auto-generate portofolio dari proyek
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Cairkan pendapatan ke dompet
                            </li>
                        </ul>

                        {{-- CTA Button --}}
                        <div class="w-full flex items-center justify-center gap-2 py-3 px-6 bg-brand-primary group-hover:bg-brand-dark rounded-2xl text-sm font-bold text-white transition-all duration-300 shadow-lg shadow-indigo-900/20">
                            Daftar sebagai Pekerja Lepas
                            <svg class="w-4 h-4 -translate-x-1 group-hover:translate-x-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                </a>

            </div>

            {{-- Footer links --}}
            <div class="mt-8 text-center space-y-3">
                <p class="text-sm text-gray-500">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:text-brand-dark transition-colors">Masuk di sini</a>
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
