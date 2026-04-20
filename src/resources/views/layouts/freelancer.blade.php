<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillKul - Portal Freelancer')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar-scrollbar::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 999px; }
    </style>
</head>
<body class="font-sans antialiased bg-[#f8f9fc] text-gray-900">
    @php
        $user = Auth::user();
        $photo = $user && $user->profile_photo_path
            ? asset('storage/' . $user->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user?->name ?? 'User') . '&background=4f46e5&color=fff';
    @endphp

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-[#080c35] flex flex-col justify-between flex-shrink-0 fixed inset-y-0 left-0 z-40 sidebar-scrollbar overflow-y-auto hidden md:flex">
            <div class="px-6 py-8">
                {{-- Brand --}}
                <div class="mb-10">
                    <h2 class="text-lg font-extrabold text-white tracking-tight">Portal Freelancer</h2>
                    <p class="text-[10px] text-indigo-300 font-semibold mt-1">Entrepreneur Akademik</p>
                </div>

                {{-- Navigation --}}
                <nav class="space-y-1.5">
                    <a href="{{ route('freelancer.dasbor') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('freelancer.dasbor') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Ringkasan
                    </a>
                    <a href="{{ route('freelancer.jasa.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('freelancer.jasa.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Layanan Saya
                    </a>
                    <a href="{{ route('freelancer.pesanan') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('freelancer.pesanan') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Pesanan Masuk
                    </a>
                    <a href="{{ route('freelancer.invoice.create') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('freelancer.invoice.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Buat Tagihan
                    </a>
                    <a href="{{ route('freelancer.dompet') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('freelancer.dompet') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Pendapatan
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                </nav>
            </div>

            {{-- User Card --}}
            <div class="p-5">
                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 backdrop-blur-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ $photo }}" alt="{{ $user?->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-400/30">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ $user?->name ?? 'Freelancer' }}</p>
                            <p class="text-[10px] text-indigo-300">Mahasiswa Aktif</p>
                        </div>
                    </div>
                    <a href="{{ route('freelancer.jasa.create') }}" class="block w-full text-center bg-brand-primary hover:bg-brand-secondary text-white text-xs font-bold py-2.5 rounded-xl transition-colors shadow-lg shadow-indigo-900/30">
                        Mulai Proyek
                    </a>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 text-xs font-semibold text-indigo-300 hover:text-red-400 py-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <main class="flex-1">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </div>
</body>
</html>
