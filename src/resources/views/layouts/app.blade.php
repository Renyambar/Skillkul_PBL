<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SkillKul') }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <!-- Logo & Kiri -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2">
                        <!-- Placeholder Logo -->
                        <div class="w-8 h-8 bg-blue-600 text-white flex items-center justify-center rounded-lg font-bold text-xl">
                            S
                        </div>
                        <span class="font-bold text-xl text-blue-600 tracking-tight">SkillKul</span>
                    </a>
                </div>

                <!-- Pencarian (Tengah) - Sembunyi di Mobile -->
                <div class="hidden sm:flex flex-1 justify-center items-center px-8">
                    <div class="w-full max-w-lg relative">
                        <form action="{{ route('services.index') }}" method="GET">
                            <input type="text" name="search" placeholder="Cari jasa mahasiswa..."
                                class="w-full bg-gray-100 border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 rounded-full py-2 px-4 pl-10 text-sm transition-colors duration-200">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </form>
                    </div>
                </div>

                <!-- Menu Navigasi (Kanan) -->
                <div class="hidden sm:flex sm:items-center sm:gap-4">
                    <a href="{{ route('services.index') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md transition">Katalog Jasa</a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md transition">Dashboard</a>

                        <!-- Dropdown Profil Simple -->
                        <div class="relative ml-3">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-full transition">
                                <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                {{ Auth::user()->name }}
                            </a>
                        </div>
                    @else
                        <a href="/login" class="text-sm font-medium text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md transition">Masuk</a>
                        <a href="/register" class="text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-full transition shadow-sm hover:shadow">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 p-2" aria-label="Toggle menu">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Search (Tampil di layar kecil saja jika menu ditekan, disini kita buat simple bar) -->
        <div class="sm:hidden px-4 pb-3 pt-1 border-t border-gray-100">
            <form action="{{ route('services.index') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Cari jasa..."
                    class="w-full bg-gray-100 border-transparent focus:bg-white focus:border-blue-500 rounded-full py-2 px-4 pl-10 text-sm">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Jika menggunakan $slot (seperti Laravel Breeze), ganti ke {{ $slot }} -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 pt-12 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">

                <!-- Brand & Deskripsi -->
                <div class="col-span-1 md:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white flex items-center justify-center rounded-lg font-bold text-xl">S</div>
                        <span class="font-bold text-2xl text-white tracking-tight">SkillKul</span>
                    </a>
                    <p class="text-gray-400 leading-relaxed max-w-sm mb-6">
                        Marketplace Jasa Mahasiswa. Wadah terbaik untuk menemukan freelancer berkualitas dari kalangan mahasiswa, dengan pembayaran aman (Escrow) dan proses transaksi yang mudah.
                    </p>
                </div>

                <!-- Tautan Cepat -->
                <div>
                    <h3 class="text-white font-semibold mb-4 uppercase tracking-wider text-xs">Jelajahi</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-gray-400 hover:text-blue-400 transition">Katalog Jasa</a></li>
                        <li><a href="/login" class="text-gray-400 hover:text-blue-400 transition">Masuk</a></li>
                        <li><a href="/register" class="text-gray-400 hover:text-blue-400 transition">Daftar Akun</a></li>
                    </ul>
                </div>

                <!-- Legalitas -->
                <div>
                    <h3 class="text-white font-semibold mb-4 uppercase tracking-wider text-xs">Bantuan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Cara Pembayaran</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-gray-500 text-xs">
                <p>&copy; {{ date('Y') }} SkillKul. All rights reserved.</p>
                <div class="flex gap-4">
                    <!-- Placeholder Social Media -->
                    <a href="#" class="hover:text-blue-400 transition">Instagram</a>
                    <a href="#" class="hover:text-blue-400 transition">Twitter</a>
                    <a href="#" class="hover:text-blue-400 transition">LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
