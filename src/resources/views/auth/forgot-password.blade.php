<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SkillKul') }} - Forgot Password</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-brand-darkbg flex min-h-screen flex-col transition-colors duration-300">
    <main class="flex-1 flex items-center justify-center p-6 relative">
        <!-- Abstract Blurs -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-primary/20 dark:bg-brand-primary/30 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500/20 dark:bg-purple-900/30 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="bg-white dark:bg-brand-darksurface rounded-3xl shadow-xl dark:shadow-none border border-gray-100 dark:border-brand-darkborder overflow-hidden w-full max-w-5xl grid md:grid-cols-2 relative z-10 transition-colors duration-300">
            <div class="hidden md:flex flex-col justify-center p-12 bg-[#0c1c81] dark:bg-brand-dark text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-10"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/10 dark:bg-indigo-500/10 rounded-full blur-[80px]"></div>

                <h1 class="text-2xl font-bold mb-10 relative z-10 flex items-center gap-2">
                    <img src="{{ asset('images/logo-3.png') }}" class="w-8 h-8 object-contain rounded-lg shadow-lg" alt="SkillKul Logo">
                    SkillKul
                </h1>
                <h2 class="text-4xl font-extrabold mb-4 leading-tight relative z-10">Atur ulang kata sandi dengan aman.</h2>
                <p class="text-[#a4b1ff] dark:text-gray-400 text-lg relative z-10">
                    Kami akan mengirim tautan reset ke email terdaftar Anda agar akun bisa diakses kembali.
                </p>
            </div>

            <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#0c1c81] dark:text-indigo-400">Reset Akun</p>
                    <h2 class="text-2xl font-bold text-[#0c1c81] dark:text-white mt-2">Lupa kata sandi?</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                        Masukkan email akun Anda untuk menerima tautan reset kata sandi.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email"
                            class="block text-xs font-bold text-indigo-700 dark:text-gray-400 uppercase tracking-wide mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 dark:text-gray-500 text-lg font-medium">@</span>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="email" placeholder="nama@kampus.ac.id"
                                class="pl-12 block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between gap-4 text-sm mt-6">
                        <a href="{{ route('login') }}" class="font-bold text-gray-500 dark:text-gray-400 hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">
                            Kembali ke login
                        </a>

                        <button type="submit"
                            class="inline-flex justify-center py-3.5 px-6 border border-transparent rounded-xl shadow-lg shadow-brand-primary/20 dark:shadow-indigo-900/20 text-sm font-extrabold text-white bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary dark:focus:ring-offset-gray-900">
                            Kirim Tautan Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>