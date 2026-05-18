<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillKul')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8f9fc] text-gray-900">

    {{-- Top Navigation --}}
    <nav class="w-full bg-white flex justify-between items-center py-5 px-6 md:px-16 border-b border-gray-100 z-50 sticky top-0 shadow-sm">
        <a href="/" class="text-2xl font-bold text-brand-dark tracking-tight">Skill<span class="text-brand-primary">Kul</span></a>
        <div class="hidden md:flex space-x-10 text-sm font-medium text-gray-600">
            <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') || request()->routeIs('jasa.detail') ? 'text-brand-dark border-b-2 border-brand-primary pb-1 font-semibold' : 'hover:text-brand-primary pb-1 transition-colors' }}">Layanan</a>
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'text-brand-dark border-b-2 border-brand-primary pb-1 font-semibold' : 'hover:text-brand-primary pb-1 transition-colors' }}">Tentang</a>
            <a href="{{ route('keamanan') }}" class="{{ request()->routeIs('keamanan') ? 'text-brand-dark border-b-2 border-brand-primary pb-1 font-semibold' : 'hover:text-brand-primary pb-1 transition-colors' }}">Keamanan</a>
        </div>
        <div class="flex space-x-3 items-center">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-brand-primary text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-dark transition-all shadow-md">Beranda</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-black transition-colors px-4 py-2">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-brand-primary text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-dark transition-all shadow-md">Daftar</a>
                @endif
            @endauth
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('layouts.footer')
</body>
</html>
