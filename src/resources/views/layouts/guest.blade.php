<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SkillKul') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        <style>
            .glass-card {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
            .dark .glass-card {
                background: rgba(21, 26, 40, 0.85);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            .bg-pattern {
                background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
                background-size: 20px 20px;
            }
            .dark .bg-pattern {
                background-image: radial-gradient(#334155 1px, transparent 1px);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-gray-50 dark:bg-brand-darkbg transition-colors duration-300 relative overflow-x-hidden min-h-screen flex flex-col justify-center items-center">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-brand-primary/20 dark:bg-brand-primary/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-purple-300/40 dark:bg-purple-900/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-pink-300/30 dark:bg-pink-900/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

        <div class="w-full flex justify-center mb-8 relative z-10">
            <a href="/" class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight flex items-center gap-2 drop-shadow-sm">
                <div class="w-10 h-10 bg-brand-primary text-white rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                Skill<span class="text-brand-primary dark:text-indigo-400">Kul</span>
            </a>
        </div>

        <div class="w-full sm:max-w-md px-8 py-10 glass-card shadow-2xl overflow-hidden sm:rounded-[2rem] relative z-10 transform transition-all hover:scale-[1.01] duration-300">
            {{ $slot }}
        </div>
        
        <p class="mt-8 text-sm text-gray-500 dark:text-gray-400 relative z-10 font-medium">
            &copy; {{ date('Y') }} SkillKul. All rights reserved.
        </p>
    </body>
</html>
