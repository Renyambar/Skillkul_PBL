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
    <style>
        .sidebar-scrollbar::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 999px; }
    </style>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-brand-darkbg text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="flex min-h-screen">
        {{-- Admin Sidebar --}}
        <aside class="w-64 bg-brand-dark flex flex-col justify-between flex-shrink-0 fixed inset-y-0 left-0 z-40 sidebar-scrollbar overflow-y-auto hidden md:flex border-r border-brand-darkborder/30 shadow-2xl">
            <div class="px-6 py-8 relative z-10">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-5 pointer-events-none"></div>
                
                <div class="mb-10 relative">
                    <h2 class="text-lg font-extrabold text-white tracking-tight flex items-center gap-2">
                        <div class="w-8 h-8 bg-brand-primary rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        Skill<span class="text-indigo-400">Kul</span>
                    </h2>
                    <p class="text-[10px] text-indigo-300 font-semibold mt-2 ml-10">Panel Administrasi</p>
                </div>
                
                <nav class="space-y-1.5 relative">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Pengguna
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.laporan.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                        Laporan Masuk
                        @php $pendingReports = \App\Models\Report::where('status','pending')->count(); @endphp
                        @if($pendingReports > 0)
                            <span class="ml-auto bg-red-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm">{{ $pendingReports }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.services.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Katalog Layanan
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Kategori Layanan
                    </a>

                    <div class="pt-4 pb-2 px-4">
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-400">Kelola Keuangan</p>
                    </div>
                    
                    <a href="{{ route('admin.withdrawal.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.withdrawal.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Pencairan Saldo 
                        @php $pendingWd = \App\Models\Withdrawal::where('status','pending')->count(); @endphp
                        @if($pendingWd > 0)
                            <span class="ml-auto bg-orange-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm">{{ $pendingWd }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.escrow.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.escrow.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Dana Transaksi
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.transactions.*') ? 'bg-brand-primary text-white shadow-lg shadow-indigo-900/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Riwayat Transaksi Keuangan
                    </a>
                </nav>
            </div>
            
            <div class="p-5 relative z-10">
                {{-- Dark Mode Toggle inside sidebar --}}
                <div class="mb-4 flex justify-center">
                    <button id="theme-toggle" type="button" class="flex items-center gap-2 bg-white/5 hover:bg-white/10 text-indigo-200 hover:text-white px-4 py-2 rounded-xl transition-colors text-xs font-semibold backdrop-blur-sm border border-white/5 w-full justify-center">
                        <svg id="theme-toggle-dark-icon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                        <span id="theme-toggle-text">Mode Tampilan</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 text-xs font-semibold text-indigo-300 hover:text-red-400 py-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col min-h-screen relative">
            <main class="flex-1">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </div>
    
    {{-- Dark Mode Script Initializer --}}
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>
