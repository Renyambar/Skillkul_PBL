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
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-brand-darkbg text-gray-900 dark:text-gray-100 transition-colors duration-300">

    {{-- Top Navigation --}}
    <nav class="w-full bg-white/90 dark:bg-brand-darksurface/90 backdrop-blur-md flex justify-between items-center py-4 px-6 md:px-16 border-b border-gray-100 dark:border-brand-darkborder z-50 sticky top-0 shadow-sm transition-colors duration-300">
        <a href="/" class="text-2xl font-extrabold text-brand-dark dark:text-white tracking-tight flex items-center gap-2">
            <img src="{{ asset('images/logo-3.png') }}" class="w-10 h-10 object-contain rounded-xl shadow-lg shadow-indigo-500/10" alt="SkillKul Logo">
            <span class="hidden sm:inline">Skill<span class="text-brand-primary dark:text-indigo-400">Kul</span></span>
        </a>
        <div class="hidden md:flex space-x-10 text-sm font-bold text-gray-600 dark:text-gray-400">
            <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') || request()->routeIs('jasa.detail') ? 'text-brand-primary dark:text-indigo-400 border-b-2 border-brand-primary dark:border-indigo-400 pb-1' : 'hover:text-brand-primary dark:hover:text-indigo-400 pb-1 transition-colors' }}">Layanan</a>
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'text-brand-primary dark:text-indigo-400 border-b-2 border-brand-primary dark:border-indigo-400 pb-1' : 'hover:text-brand-primary dark:hover:text-indigo-400 pb-1 transition-colors' }}">Tentang Kami</a>
            <a href="{{ route('keamanan') }}" class="{{ request()->routeIs('keamanan') ? 'text-brand-primary dark:text-indigo-400 border-b-2 border-brand-primary dark:border-indigo-400 pb-1' : 'hover:text-brand-primary dark:hover:text-indigo-400 pb-1 transition-colors' }}">Keamanan</a>
        </div>
        <div class="flex space-x-3 items-center" x-data="{
            isDarkMode: localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
            toggleDarkMode() {
                this.isDarkMode = !this.isDarkMode;
                if (this.isDarkMode) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            }
        }">
            <!-- Dark Mode Toggle -->
            <button @click="toggleDarkMode()" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-full text-sm p-2.5 transition-colors mr-2">
                <svg x-show="isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="display: none;"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 1.32a1 1 0 011.415 0l.708.708a1 1 0 01-1.414 1.415l-.708-.708a1 1 0 010-1.415zM16 10a1 1 0 01-1-1h-1a1 1 0 110-2h1a1 1 0 011 1zM14.22 17.68a1 1 0 010-1.415l.708-.708a1 1 0 011.414 1.415l-.708.708a1 1 0 01-1.415 0zM10 16a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zm-4.22-1.32a1 1 0 01-1.415 0l-.708-.708a1 1 0 011.414-1.415l.708.708a1 1 0 010 1.415zM4 10a1 1 0 011 1h1a1 1 0 110 2H5a1 1 0 01-1-1zM5.78 2.32a1 1 0 010 1.415l-.708.708a1 1 0 01-1.414-1.415l.708-.708a1 1 0 011.415 0zM10 5a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                <svg x-show="!isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>

            @auth
                <a href="{{ route('dashboard') }}" class="bg-brand-primary text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-brand-dark dark:hover:bg-indigo-900 transition-colors shadow-sm shadow-indigo-500/30">Kembali</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-indigo-400 transition-colors px-4 py-2">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-brand-primary text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-brand-dark dark:hover:bg-indigo-900 transition-colors shadow-sm shadow-indigo-500/30">Daftar</a>
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
