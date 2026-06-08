<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillKul - Admin')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8f9fc] text-gray-900">
    <div class="flex min-h-screen">
        {{-- Admin Sidebar --}}
        <aside class="w-64 bg-[#080c35] flex flex-col justify-between flex-shrink-0 fixed inset-y-0 left-0 z-40 hidden md:flex">
            <div class="px-6 py-8">
                <div class="mb-10">
                    <h2 class="text-lg font-extrabold text-white tracking-tight">Skill<span class="text-indigo-400">Kul</span> Admin</h2>
                    <p class="text-[10px] text-indigo-300 font-semibold mt-1">Panel Administrasi</p>
                </div>
                <nav class="space-y-1.5">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Pengguna
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.laporan.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                        Laporan Masuk
                        @php $pendingReports = \App\Models\Report::where('status','pending')->count(); @endphp
                        @if($pendingReports > 0)
                            <span class="ml-auto bg-red-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingReports }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.services.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Jasa & Layanan
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Kategori Layanan
                    </a>

                    <div class="pt-2 pb-1 px-4">
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-500">Kelola Keuangan</p>
                    </div>
                    <a href="{{ route('admin.withdrawal.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.withdrawal.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Pencairan Saldo 
                        @php $pendingWd = \App\Models\Withdrawal::where('status','pending')->count(); @endphp
                        @if($pendingWd > 0)
                            <span class="ml-auto bg-yellow-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingWd }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.escrow.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.escrow.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Dana Transaksi
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.transactions.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Riwayat Transaksi Keuangan
                    </a>
                </nav>
            </div>
            <div class="p-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 text-xs font-semibold text-indigo-300 hover:text-red-400 py-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <main class="flex-1">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </div>
</body>
</html>
