<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillKul - Portal Klien')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-brand-darkbg text-gray-900 dark:text-gray-100 transition-colors duration-300">
    @php
        $user = Auth::user();
        $photo = $user && $user->profile_photo_path
            ? asset('storage/' . $user->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user?->name ?? 'User') . '&background=140c61&color=fff';
    @endphp

    {{-- Top Navigation --}}
    <nav class="bg-white/80 dark:bg-brand-darksurface/80 backdrop-blur-md border-b border-gray-100 dark:border-brand-darkborder sticky top-0 z-50 shadow-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-10">
                    <a href="/" class="text-xl font-extrabold text-brand-dark dark:text-white tracking-tight flex items-center gap-2">
                        <div class="w-8 h-8 bg-brand-primary rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        Skill<span class="text-brand-primary dark:text-indigo-400">Kul</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center gap-1 mx-auto">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-brand-primary dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'text-gray-600 dark:text-gray-400 hover:text-brand-primary dark:hover:text-indigo-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}">
                        Beranda
                    </a>
                    <a href="{{ route('katalog') }}"
                        class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('katalog') || request()->routeIs('jasa.detail') ? 'text-brand-primary dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'text-gray-600 dark:text-gray-400 hover:text-brand-primary dark:hover:text-indigo-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}">
                        Layanan
                    </a>
                    <a href="{{ route('pesanan.klien') }}"
                        class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('pesanan.*') ? 'text-brand-primary dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'text-gray-600 dark:text-gray-400 hover:text-brand-primary dark:hover:text-indigo-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}">
                        Pesanan Saya
                    </a>
                </div>
                <div class="flex items-center gap-4">
                @php $unreadNotifCount = auth()->user()?->unreadNotifications()->count() ?? 0; @endphp
                    
                    {{-- Dark Mode Toggle --}}
                    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2.5 transition-colors">
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>

                    {{-- Notification Bell --}}
                    <a href="{{ route('notifikasi.index') }}" class="relative p-2 text-gray-400 hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        @if($unreadNotifCount > 0)
                            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                                {{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}
                            </span>
                        @endif
                    </a>
                    {{-- User Avatar Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ $photo }}" alt="{{ $user?->name }}"
                                class="w-9 h-9 rounded-full object-cover border-2 border-indigo-100 dark:border-indigo-900">
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-brand-darksurface rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 py-2 z-50">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 font-medium">Profil
                                Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 font-medium">Keluar</button>
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
    
    @stack('scripts')
</body>
</html>