<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SkillKul') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    <div class="flex-grow flex items-center justify-center p-6">
        <div
            class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl h-[600px]">

            <!-- Left Side (Blue Background) -->
            <div class="hidden md:flex flex-col justify-center w-1/2 p-12 bg-[#0c1c81] text-white">
                <h1 class="text-2xl font-bold mb-10">SkillKul</h1>

                <h2 class="text-4xl font-extrabold mb-4 leading-tight">Menjembatani Dunia<br>Akademis & Industri</h2>
                <p class="text-[#a4b1ff] mb-8 text-lg">
                    Platform kurasi untuk mahasiswa bertalenta dalam membangun portofolio profesional dan karier
                    wirausaha.
                </p>

                <div class="space-y-4">
                    <div class="bg-white/10 rounded-xl p-4 flex gap-4 items-center">
                        <div class="text-teal-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Verifikasi Akademik</h3>
                            <p class="text-sm text-[#a4b1ff]">Akses eksklusif untuk pemilik email .ac.id</p>
                        </div>
                    </div>

                    <div class="bg-white/10 rounded-xl p-4 flex gap-4 items-center">
                        <div class="text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Auto-Portfolio AI</h3>
                            <p class="text-sm text-[#a4b1ff]">Ubah tugas kuliah menjadi aset profesional</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side (Login Form) -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
                <h2 class="text-2xl font-bold text-[#0c1c81] mb-2">Selamat Datang Kembali</h2>
                <p class="text-gray-500 text-sm mb-8">Silakan masuk untuk melanjutkan perjalanan profesional Anda.</p>

                <div class="flex bg-gray-100 rounded-lg p-1 mb-6">
                    <button type="button" id="btn-client" onclick="switchRole('client')"
                        class="flex-1 py-2 text-sm font-semibold text-white bg-[#0c1c81] rounded-md shadow-sm transition-all duration-200">
                        Klien (Pesan Jasa)
                    </button>
                    <button type="button" id="btn-freelancer" onclick="switchRole('freelancer')"
                        class="flex-1 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700 rounded-md transition-all duration-200">
                        Freelancer (Jual Jasa)
                    </button>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" id="input-role" value="client">

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
                                placeholder="example@gmail.com"
                                class="pl-10 block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 placeholder-gray-400">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password"
                            class="block text-xs font-bold text-indigo-700 uppercase tracking-wide mb-1">Nomor
                            Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required placeholder="08xx xxxx xxxx"
                                class="pl-10 block w-full bg-gray-100 border-0 text-gray-900 rounded-lg focus:ring-[#0c1c81] sm:text-sm py-3 placeholder-gray-400">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-[#0c1c81] hover:underline">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-[#0c1c81] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0c1c81]">
                        Masuk ke Akun &rarr;
                    </button>

                    <p class="mt-6 text-center text-sm text-gray-500">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}" class="font-semibold text-[#0c1c81] hover:underline">
                            Daftar Baru
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-6 border-t border-gray-200">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <div class="mb-4 md:mb-0">
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

    <script>
        function switchRole(role) {
            document.getElementById('input-role').value = role;

            const btnClient = document.getElementById('btn-client');
            const btnFreelancer = document.getElementById('btn-freelancer');

            const activeClasses = 'flex-1 py-2 text-sm font-semibold text-white bg-[#0c1c81] rounded-md shadow-sm transition-all duration-200';
            const inactiveClasses = 'flex-1 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700 rounded-md transition-all duration-200';

            if (role === 'client') {
                btnClient.className = activeClasses;
                btnFreelancer.className = inactiveClasses;
            } else {
                btnFreelancer.className = activeClasses;
                btnClient.className = inactiveClasses;
            }
        }
    </script>
</body>

</html>