<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SkillKul') }} - Daftar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-brand-darkbg flex flex-col min-h-screen transition-colors duration-300">

    <div class="flex-grow flex items-center justify-center p-6 relative">
        <!-- Abstract Blurs -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-primary/20 dark:bg-brand-primary/30 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500/20 dark:bg-purple-900/30 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="bg-white dark:bg-brand-darksurface rounded-[40px] shadow-2xl dark:shadow-none overflow-hidden flex flex-col md:flex-row w-full max-w-5xl min-h-[650px] border border-gray-100 dark:border-brand-darkborder relative z-10 transition-colors duration-300">

            <div class="hidden md:flex flex-col justify-center w-1/2 p-12 bg-brand-primary dark:bg-brand-dark text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-10"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/10 dark:bg-indigo-500/10 rounded-full blur-[80px]"></div>

                <h1 class="text-3xl font-extrabold mb-10 tracking-tight relative z-10 flex items-center gap-2">
                    <div class="w-10 h-10 bg-white text-brand-primary rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    Skill<span class="text-indigo-200 dark:text-indigo-400">Kul</span>
                </h1>
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight tracking-tight relative z-10">Menjembatani Dunia<br>Akademis & Industri</h2>
                <p class="text-indigo-200 dark:text-gray-400 mb-10 text-base leading-relaxed relative z-10 font-medium">
                    Platform kurasi untuk mahasiswa bertalenta dalam membangun portofolio profesional dan karier wirausaha.
                </p>

                <div class="space-y-4 relative z-10">
                    <div class="bg-white/10 dark:bg-gray-800/50 rounded-2xl p-4 flex gap-4 items-center border border-white/10 dark:border-gray-700 backdrop-blur-sm shadow-sm">
                        <div class="text-green-400 dark:text-green-300 bg-white/10 dark:bg-green-900/30 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Verifikasi Akademik</h3>
                            <p class="text-xs text-indigo-200 dark:text-gray-400 mt-0.5 font-medium">Akses eksklusif untuk pemilik email .ac.id</p>
                        </div>
                    </div>

                    <div class="bg-white/10 dark:bg-gray-800/50 rounded-2xl p-4 flex gap-4 items-center border border-white/10 dark:border-gray-700 backdrop-blur-sm shadow-sm">
                        <div class="text-white dark:text-indigo-300 bg-white/10 dark:bg-indigo-900/30 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Portofolio Otomatis</h3>
                            <p class="text-xs text-indigo-200 dark:text-gray-400 mt-0.5 font-medium">Ubah tugas kuliah menjadi aset profesional</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-14 flex flex-col justify-center bg-white dark:bg-brand-darksurface overflow-y-auto relative z-10">
                <h2 class="text-3xl font-extrabold text-brand-dark dark:text-white mb-2 tracking-tight">Buat Akun Baru</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 font-medium">Silakan daftar untuk memulai perjalanan profesional Anda.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{ selectedRole: '{{ old('role') }}' }">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Masukkan nama lengkap"
                            class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-1.5">Email Kampus</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@mahasiswa.polinema.ac.id"
                            class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                        <p class="mt-2 text-xs text-indigo-500 dark:text-indigo-400 font-bold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Harus menggunakan email kampus (.ac.id)
                        </p>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone_number" class="block text-xs font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-1.5">Nomor Telepon</label>
                            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required
                                placeholder="08xxxxxxxxxx"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
                        </div>

                        <div>
                            <label for="role" class="block text-xs font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-1.5">Daftar Sebagai</label>
                            <select id="role" name="role" required x-model="selectedRole"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 px-4 font-medium transition-colors">
                                <option value="" disabled selected>Pilih peran</option>
                                <option value="client">Klien</option>
                                <option value="freelancer">Pekerja Lepas</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-1" />
                        </div>
                    </div>

                    {{-- NIM: hanya tampil untuk Pekerja Lepas --}}
                    <div x-show="selectedRole === 'freelancer'" x-transition style="display:none;">
                        <label for="nim" class="block text-xs font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-1.5">
                            NIM <span class="text-gray-400 dark:text-gray-500 font-normal normal-case tracking-normal text-[10px]">(Nomor Induk Mahasiswa)</span>
                        </label>
                        <input id="nim" type="text" name="nim" value="{{ old('nim') }}"
                            placeholder="Contoh: 2241760001"
                            class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Opsional — dapat dilengkapi nanti melalui profil.
                        </p>
                        <x-input-error :messages="$errors->get('nim')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-1.5">Kata Sandi</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="••••••••"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-1.5">Konfirmasi Sandi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                placeholder="••••••••"
                                class="block w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-brand-primary dark:focus:border-indigo-500 sm:text-sm py-4 px-4 font-medium placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-brand-primary/20 dark:shadow-indigo-900/20 text-sm font-extrabold text-white bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-700 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary">
                            Daftar Akun<svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <p class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">
                        Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-brand-primary dark:text-indigo-400 hover:text-brand-dark dark:hover:text-indigo-300 transition-colors">Masuk di sini</a>
                    </p>

                    <a href="{{ route('home') }}" class="w-full flex justify-center items-center py-4 px-4 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-bold text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Batalkan & Kembali ke Beranda
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>