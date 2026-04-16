<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SkillKul') }} - Daftar</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    <div class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl min-h-[650px]">

            <div class="hidden md:flex flex-col justify-center w-1/2 p-12 bg-[#0c1c81] text-white">
                <h1 class="text-2xl font-bold mb-10">SkillKul</h1>

                <h2 class="text-4xl font-extrabold mb-4 leading-tight">Menjembatani Dunia<br>Akademis & Industri</h2>
                <p class="text-[#a4b1ff] mb-8 text-lg">
                    Platform kurasi untuk mahasiswa bertalenta dalam membangun portofolio profesional dan karier wirausaha.
                </p>

                <div class="space-y-4">
                    <div class="bg-white/10 rounded-xl p-4 flex gap-4 items-center border border-white/5">
                        <div class="text-teal-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-sm">Verifikasi Akademik</h3>
                            <p class="text-xs text-[#a4b1ff]">Akses eksklusif untuk pemilik email .ac.id</p>
                        </div>
                    </div>

                    <div class="bg-white/10 rounded-xl p-4 flex gap-4 items-center border border-white/5">
                        <div class="text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-sm">Auto-Portfolio AI</h3>
                            <p class="text-xs text-[#a4b1ff]">Ubah tugas kuliah menjadi aset profesional</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white overflow-y-auto">
                <h2 class="text-2xl font-bold text-[#0c1c81] mb-2">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm mb-6">Silakan daftar untuk memulai perjalanan profesional Anda.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Masukkan nama lengkap"
                            class="block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 px-4 placeholder-gray-400">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="example@gmail.com"
                            class="block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 px-4 placeholder-gray-400">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone_number" class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Nomor Telepon</label>
                            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required
                                placeholder="08xx xxxx xxxx"
                                class="block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 px-4 placeholder-gray-400">
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
                        </div>

                        <div>
                            <label for="role" class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Daftar Sebagai</label>
                            <select id="role" name="role" required
                                class="block w-full bg-gray-100 border-0 text-gray-500 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 px-4">
                                <option value="" disabled selected>Pilih role</option>
                                <option value="client">Klien</option>
                                <option value="freelancer">Freelancer</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="••••••••"
                                class="block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 px-4 placeholder-gray-400">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Konfirmasi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                placeholder="••••••••"
                                class="block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 px-4 placeholder-gray-400">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-[#0c1c81] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0c1c81] transition-all">
                            Daftar Akun Baru &rarr;
                        </button>
                    </div>

                    <p class="mt-4 text-center text-sm text-gray-500">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="font-semibold text-[#0c1c81] hover:underline">
                            Masuk di sini
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-white py-6 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <div class="mb-4 md:mb-0 text-center md:text-left">
                <p class="font-bold text-[#0c1c81] mb-1">SkillKul</p>
                <p>&copy; 2024 SkillKul: The Academic Entrepreneur. Bridging academia and industry.</p>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-gray-900">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-gray-900">Kebijakan Privasi</a>
                <a href="#" class="hover:text-gray-900">Kontak Kami</a>
            </div>
        </div>
    </footer>

</body>
</html>