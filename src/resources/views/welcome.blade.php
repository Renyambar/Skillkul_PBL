<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SkillKul - Jembatan Akademis &amp; Industri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-brand-light">

    @php
        $user = Auth::user();
        $photo = $user && $user->profile_photo_path
            ? asset('storage/' . $user->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user?->name ?? 'User') . '&background=140c61&color=fff';
    @endphp

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-10">
                    <a href="/" class="text-2xl font-bold text-brand-dark tracking-tight">Skill<span
                            class="text-brand-primary">Kul</span></a>
                </div>
                <div class="hidden md:flex items-center gap-1 mx-auto">
                    <a href="{{ route('katalog') }}"
                        class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('katalog') || request()->routeIs('jasa.detail') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                        Layanan
                    </a>
                    <a href="{{ route('tentang') }}"
                        class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('tentang') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                        Tentang
                    </a>
                    <a href="{{ route('keamanan') }}"
                        class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('keamanan') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                        Keamanan
                    </a>
                    @auth
                        <a href="{{ route('pesanan.klien') }}"
                            class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('pesanan.*') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-brand-primary bg-indigo-50' : 'text-gray-600 hover:text-brand-primary hover:bg-gray-50' }}">
                            Beranda
                        </a>
                    @endauth
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        {{-- Notification Bell --}}
                        <button class="relative p-2 text-gray-400 hover:text-brand-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </button>
                        {{-- User Avatar Dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                                <img src="{{ $photo }}" alt="{{ $user?->name }}"
                                    class="w-9 h-9 rounded-full object-cover border-2 border-indigo-100">
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-medium">Profil
                                    Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Guest Actions --}}
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-primary px-3 py-2 rounded-lg transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-brand-primary text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-brand-dark transition-colors shadow-sm">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="max-w-7xl mx-auto px-6 md:px-16 py-20 md:py-28 grid md:grid-cols-2 gap-16 items-center bg-brand-light">
        <div class="space-y-8">
            <span
                class="inline-flex items-center bg-[#f2eefd] text-brand-primary px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-[#ede7fd]">
                WADAH AKADEMIK TERKURASI
            </span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-brand-primary leading-tight tracking-tighter">
                Menjembatani Dunia <br>Akademis &amp; Industri
            </h1>
            <p class="text-gray-600 md:text-lg max-w-lg leading-relaxed">
                Platform kurasi untuk mahasiswa bertalenta dalam membangun portofolio profesional dan karier wirausaha
                sejak masa kuliah.
            </p>

            {{-- ── Search Bar Fungsional ── --}}
            <form method="GET" action="{{ route('katalog') }}" class="flex gap-2 max-w-lg" id="hero-search-form">
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" id="hero-search-input"
                        placeholder="Cari jasa desain, coding, penulisan…"
                        class="w-full pl-10 pr-4 py-3.5 text-sm bg-white border border-gray-200 rounded-xl outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition-all shadow-sm font-medium text-gray-700 placeholder-gray-400">
                </div>
                <button type="submit" id="hero-search-btn"
                    class="bg-brand-primary text-white px-6 py-3.5 rounded-xl text-sm font-bold hover:bg-brand-dark transition-all shadow-lg shadow-indigo-900/20 whitespace-nowrap flex-shrink-0">
                    Cari Jasa
                </button>
            </form>

            {{-- Quick category links --}}
            <div class="flex flex-wrap gap-2">
                @foreach($categories->take(4) as $cat)
                    <a href="{{ route('katalog', ['category' => $cat->name]) }}"
                        class="text-xs font-semibold text-brand-primary bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                        {{ $cat->name }}
                    </a>
                @endforeach
                @if($categories->count() > 4)
                    <a href="{{ route('katalog') }}"
                        class="text-xs font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 border border-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                        +{{ $categories->count() - 4 }} lainnya
                    </a>
                @endif
            </div>

            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ route('katalog') }}"
                    class="bg-brand-primary text-white px-6 py-4 rounded-xl text-sm font-semibold flex items-center gap-2 hover:bg-brand-dark transition-all shadow-lg shadow-indigo-900/20">
                    Mulai Jelajahi Jasa
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="{{ route('register') }}"
                    class="bg-gray-200 text-gray-800 px-6 py-4 rounded-xl text-sm font-semibold hover:bg-gray-300 transition-all border border-gray-300">
                    Daftar Jadi Pekerja Lepas
                </a>
            </div>
        </div>
        <div class="relative group">
            <div class="rounded-3xl overflow-hidden shadow-2xl relative border-8 border-white">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                    alt="Students collaborating" class="w-full h-auto object-cover transform scale-100" />
            </div>
            <div class="absolute -bottom-8 -left-8 glass p-5 rounded-2xl shadow-xl border border-white max-w-[240px]">
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-green-100 text-green-600 p-1 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <span class="font-bold text-sm text-brand-dark">Bakat Terverifikasi</span>
                </div>
                <p class="text-[10px] text-gray-600 leading-tight">Hanya mahasiswa berprestasi dengan portofolio
                    terkurasi.</p>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="max-w-7xl mx-auto px-6 md:px-16 py-20 bg-brand-light">
        <div class="text-center mb-16 space-y-3">
            <h2 class="text-3xl md:text-4xl font-extrabold text-brand-primary tracking-tight">Fitur Utama untuk Masa
                Depanmu</h2>
            <p class="text-gray-600 text-base max-w-2xl mx-auto">Inovasi digital yang dirancang khusus untuk ekosistem
                pendidikan dan profesional.</p>
        </div>

        <div class="grid md:grid-cols-5 gap-6">
            <!-- Innovator's Tool -->
            <div class="md:col-span-3 bg-brand-primary rounded-3xl p-10 text-white relative overflow-hidden shadow-xl">
                <span
                    class="inline-block bg-white/20 px-3 py-1 rounded-full text-[10px] font-bold tracking-wide mb-6">FITUR
                    INOVATIF</span>
                <h3 class="text-2xl md:text-3xl font-bold mb-4 tracking-tight">Auto-Portofolio Generator</h3>
                <p class="text-indigo-200 text-sm max-w-sm leading-relaxed mb-16 relative z-10">
                    Sistem otomatis yang merangkum proyek menjadi
                    portofolio profesional siap kerja.
                </p>
                <div
                    class="flex gap-4 absolute bottom-0 right-10 transform translate-y-10 group-hover:translate-y-8 transition-transform duration-500 opacity-80">
                    <div
                        class="w-28 h-40 border-2 border-white/20 rounded-t-xl bg-gradient-to-b from-white/10 to-transparent flex flex-col p-3 gap-2">
                        <div class="w-full h-3 bg-white/20 rounded-sm"></div>
                        <div class="w-2/3 h-2 bg-white/10 rounded-sm"></div>
                    </div>
                    <div
                        class="w-32 h-44 border-2 border-white/20 rounded-t-xl bg-gradient-to-b from-white/10 to-transparent flex flex-col p-3 gap-2">
                        <div class="w-full h-3 bg-white/20 rounded-sm"></div>
                        <div class="w-1/2 h-2 bg-white/10 rounded-sm"></div>
                        <div class="w-full h-20 bg-white/5 rounded-sm mt-2 border border-white/10"></div>
                    </div>
                </div>
            </div>

            <!-- Mode Ujian -->
            <div class="md:col-span-2 bg-white rounded-3xl p-10 shadow-md flex flex-col justify-between">
                <div>
                    <div
                        class="w-12 h-12 bg-[#eee8fe] text-[#865dfd] rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-primary mb-3">Mode Ujian</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-8">Anti-overwork. Nonaktifkan pesanan sementara
                        saat minggu UAS/UTS agar kamu tetap fokus pada studi.</p>
                </div>
                <div class="bg-gray-100 rounded-xl p-4 flex justify-between items-center">
                    <span class="text-xs font-bold text-brand-dark">Status Akademik</span>
                    <button class="w-10 h-6 bg-brand-primary rounded-full relative p-[2px]">
                        <div class="w-5 h-5 bg-white rounded-full ml-auto shadow-sm"></div>
                    </button>
                </div>
            </div>

            <!-- Escrow -->
            <div
                class="md:col-span-5 w-full bg-white rounded-3xl p-10 shadow-md flex flex-col md:flex-row items-center justify-between gap-10 mt-2">
                <div class="space-y-4 md:w-1/2">
                    <span
                        class="inline-flex items-center bg-green-200 text-green-800 px-3 py-1 rounded-md text-[10px] font-bold">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        AMAN & TERPERCAYA
                    </span>
                    <h3 class="text-2xl font-bold text-brand-primary">Pembayaran Escrow Midtrans</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Dana aman 100%. Kami menjaga dana Anda di sistem rekening bersama dan hanya melepaskannya ke
                        mahasiswa setelah tugas dikonfirmasi selesai serta sesuai standar.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium pt-2">
                        <div class="w-5 h-5 bg-gray-400 rounded-sm flex items-center justify-center text-white"><svg
                                class="w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg></div>
                        <span>Didukung oleh Arsitektur Midtrans</span>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-2xl p-6 border border-gray-200 border-dashed md:w-1/2 w-full">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-xs font-semibold text-gray-500">Total Proyek</span>
                        <span class="text-lg font-bold text-brand-primary">Rp 2.500.000</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center border border-green-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-green-700">Dana Tertahan (Escrow)</span>
                        </div>
                        <div class="flex items-center gap-3 opacity-50">
                            <div
                                class="w-5 h-5 rounded-full border border-gray-400 border-dotted flex items-center justify-center">
                                <span class="text-[8px] text-gray-600">...</span>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Pelepasan ke Pekerja Lepas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Jasa Terbaru Section ── -->
    <section class="max-w-7xl mx-auto px-6 md:px-16 py-20 bg-brand-light">
        <div class="flex justify-between items-end mb-10">
            <div>
                <p class="text-xs font-extrabold text-brand-secondary tracking-widest uppercase mb-1">TERBARU DI
                    SKILLKUL</p>
                <h2 class="text-3xl font-extrabold text-brand-dark tracking-tight">Jasa Unggulan</h2>
            </div>
            <a href="{{ route('katalog') }}"
                class="text-sm font-bold text-brand-primary hover:text-brand-dark transition-colors flex items-center gap-1">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        @if($featuredServices->isEmpty())
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold">Belum ada jasa yang terdaftar.</p>
                <a href="{{ route('register') }}"
                    class="mt-4 inline-block text-sm font-bold text-brand-primary hover:underline">Jadilah freelancer
                    pertama!</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredServices as $svc)
                    <a href="{{ route('jasa.detail', $svc->id) }}"
                        class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">

                        {{-- Thumbnail --}}
                        <div class="relative h-44 overflow-hidden bg-indigo-50">
                            @if($svc->image)
                                <img src="{{ Storage::url($svc->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    alt="{{ $svc->title }}">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-indigo-100 via-purple-50 to-blue-100 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Badge tipe --}}
                            @if($svc->type === 'project')
                                <div
                                    class="absolute top-3 left-3 bg-orange-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">
                                    Bisa Nego</div>
                            @else
                                <div
                                    class="absolute top-3 left-3 bg-green-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">
                                    Harga Pas</div>
                            @endif

                            {{-- Kategori --}}
                            @if($svc->category)
                                <div
                                    class="absolute top-3 right-3 bg-white/90 text-indigo-700 text-[10px] font-extrabold px-2.5 py-1 rounded-lg backdrop-blur-sm shadow">
                                    {{ $svc->category->name }}
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="p-5">
                            <h3
                                class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors leading-snug">
                                {{ $svc->title }}
                            </h3>

                            {{-- Pekerja Lepas --}}
                            <div class="flex items-center gap-2 mb-4">
                                @if($svc->freelancer?->profile_photo_path)
                                    <img src="{{ Storage::url($svc->freelancer->profile_photo_path) }}"
                                        class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <div
                                        class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-[10px] font-extrabold flex items-center justify-center flex-shrink-0">
                                        {{ strtoupper(substr($svc->freelancer?->name ?? '?', 0, 1)) }}
                                    </div>
                                @endif
                                <span
                                    class="text-xs text-gray-500 font-medium truncate">{{ $svc->freelancer?->name ?? 'Pekerja Lepas' }}</span>
                                <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto flex-shrink-0">
                                    ★ <span class="text-gray-600 font-bold">4.8</span>
                                </span>
                            </div>

                            {{-- Harga --}}
                            <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                                <p class="font-extrabold text-brand-primary">{{ $svc->price_range }}</p>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white text-gray-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('katalog') }}"
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 text-brand-primary font-bold text-sm px-8 py-4 rounded-xl hover:bg-brand-primary hover:text-white hover:border-brand-primary transition-all shadow-sm">
                    Lihat Semua Jasa di Katalog
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        @endif
    </section>

    <!-- Cara Kerja Section -->
    <section class="max-w-7xl mx-auto px-6 md:px-16 py-20 bg-brand-light">
        <div class="grid md:grid-cols-2 gap-16 items-start">
            <div>
                <h2 class="text-3xl font-extrabold text-brand-primary tracking-tight mb-4">Cara Kerja di SkillKul</h2>
                <p class="text-gray-500 text-sm mb-10">Ekosistem yang saling menguntungkan untuk pertumbuhan
                    profesional.</p>
                <div class="space-y-10">
                    <div class="flex gap-4">
                        <div
                            class="w-8 h-8 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold shrink-0">
                            1</div>
                        <div>
                            <h4 class="text-lg font-bold text-brand-dark mb-1">Klien: Buat Lowongan Proyek</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Temukan talent mahasiswa terbaik melalui
                                halaman Layanan atau biarkan sistem kami mencarikan yang paling cocok.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="w-8 h-8 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold shrink-0">
                            2</div>
                        <div>
                            <h4 class="text-lg font-bold text-brand-dark mb-1">Kolaborasi Aktif</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Pantau progres proyek secara real-time
                                melalui dashboard interaktif kami.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pekerja Lepas Card -->
            <div class="bg-gray-100 rounded-3xl p-8 md:p-10 shadow-sm border border-gray-200">
                <h3 class="text-xl font-bold text-brand-primary mb-8">Untuk Pekerja Lepas (Mahasiswa)</h3>
                <div class="space-y-6">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-brand-dark mb-1">Bangun Reputasi</h4>
                            <p class="text-[12px] text-gray-500 leading-relaxed">Setiap proyek yang selesai akan
                                menambah portofolio otomatis Anda secara instan.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-brand-dark mb-1">Pendapatan Pasti</h4>
                            <p class="text-[12px] text-gray-500 leading-relaxed">Jaminan pembayaran melalui sistem
                                escrow segera setelah tugas diverifikasi.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <a href="{{ route('register') }}"
                        class="block w-full text-center bg-[#240e61] text-white py-4 rounded-xl text-sm font-semibold hover:bg-brand-dark transition-colors">
                        Mulai Karier Wirausahamu
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="bg-[#1f2178] py-24 relative overflow-hidden">
        <!-- Shield Watermark -->
        <div class="absolute right-0 top-1/2 transform -translate-y-1/2 text-white/5 opacity-10 blur-[1px]">
            <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>

        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <div class="flex justify-center gap-1 mb-6 text-green-400">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                    </path>
                </svg>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                    </path>
                </svg>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                    </path>
                </svg>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                    </path>
                </svg>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                    </path>
                </svg>
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight mx-auto max-w-4xl tracking-tight">
                "SkillKul bukan sekadar platform pencarian kerja. Ini adalah jaminan keamanan bagi klien sekaligus
                panggung pembuktian bagi mahasiswa."
            </h2>
            <div class="mt-10 flex flex-col items-center">
                <div class="w-16 h-16 rounded-full border-2 border-green-400 overflow-hidden mb-3">
                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" alt="Budi Santoso"
                        class="w-full h-full object-cover">
                </div>
                <h4 class="text-white font-bold">Budi Santoso</h4>
                <p class="text-indigo-300 text-sm">CEO, TechForward Indonesia</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="max-w-4xl mx-auto px-6 py-20 bg-brand-light relative z-10 -mt-10">
        <div
            class="bg-white rounded-[40px] shadow-2xl p-16 text-center border border-gray-100 flex flex-col items-center shadow-indigo-100/50">
            <h2 class="text-4xl md:text-5xl font-bold text-brand-primary mb-4 tracking-tight">Siap Memulai Perjalanan
                Profesionalmu?</h2>
            <p class="text-gray-500 text-lg mb-10 text-center max-w-lg">Bergabunglah dengan ribuan mahasiswa dan klien
                yang telah terhubung di ekosistem SkillKul.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('katalog') }}"
                    class="bg-brand-primary text-white px-8 py-4 rounded-xl text-sm font-semibold hover:bg-[#0c0734] transition-colors min-w-[200px]">Cari
                    Jasa Mahasiswa</a>
                <a href="{{ route('register') }}"
                    class="bg-[#2a0868] text-white px-8 py-4 rounded-xl text-sm font-semibold hover:bg-brand-dark transition-colors min-w-[200px]">Daftar
                    Jadi Pekerja Lepas</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('layouts.footer')

</body>

</html>