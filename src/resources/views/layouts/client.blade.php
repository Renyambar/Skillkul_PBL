<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillKul - Portal Klien')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8f9fc] text-gray-900">
    @php
        $user = Auth::user();
        $photo = $user && $user->profile_photo_path
            ? asset('storage/' . $user->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user?->name ?? 'User') . '&background=140c61&color=fff';
    @endphp

    {{-- Top Navigation --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-10">
                    <a href="/" class="text-xl font-extrabold text-brand-dark tracking-tight">Skill<span class="text-brand-primary">Kul</span></a>
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('katalog') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('katalog') || request()->routeIs('jasa.detail') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                            Pasar Layanan
                        </a>
                        <a href="{{ route('pesanan.klien') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('pesanan.*') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                            Dashboard
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    {{-- Notification Bell --}}
                    <button class="relative p-2 text-gray-400 hover:text-brand-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>
                    {{-- User Avatar Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ $photo }}" alt="{{ $user?->name }}" class="w-9 h-9 rounded-full object-cover border-2 border-indigo-100">
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-medium">Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('layouts.footer')
    @stack('scripts')
</body>
</html>
