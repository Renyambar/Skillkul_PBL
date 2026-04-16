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
</head>

<body class="font-sans antialiased bg-gray-50 flex min-h-screen flex-col">
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden w-full max-w-5xl grid md:grid-cols-2">
            <div class="hidden md:flex flex-col justify-center p-12 bg-[#0c1c81] text-white">
                <h1 class="text-2xl font-bold mb-10">SkillKul</h1>
                <h2 class="text-4xl font-extrabold mb-4 leading-tight">Atur ulang kata sandi dengan aman.</h2>
                <p class="text-[#a4b1ff] text-lg">
                    Kami akan mengirim tautan reset ke email terdaftar Anda agar akun bisa diakses kembali.
                </p>
            </div>

            <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#0c1c81]">Reset Akun</p>
                    <h2 class="text-2xl font-bold text-[#0c1c81] mt-2">Lupa kata sandi?</h2>
                    <p class="text-gray-500 text-sm mt-2">
                        Masukkan email akun Anda untuk menerima tautan reset kata sandi.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email"
                            class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="email" placeholder="nama@kampus.ac.id"
                                class="pl-10 block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 placeholder-gray-400">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between gap-4 text-sm">
                        <a href="{{ route('login') }}" class="font-medium text-gray-500 hover:text-gray-700">
                            Kembali ke login
                        </a>

                        <button type="submit"
                            class="inline-flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-[#0c1c81] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0c1c81]">
                            Kirim Tautan Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>