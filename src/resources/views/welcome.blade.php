@extends('layouts.public')
@section('title', 'SkillKul - Jembatan Akademis & Industri')
@section('content')

    <!-- Hero Section -->
    <section class="relative max-w-7xl mx-auto px-6 md:px-16 py-20 md:py-32 grid md:grid-cols-2 gap-16 items-center">
        <!-- Background Blur shapes -->
        <div class="absolute top-0 left-10 w-72 h-72 bg-brand-primary/20 dark:bg-brand-primary/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-10 w-72 h-72 bg-purple-300/30 dark:bg-purple-900/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>

        <div class="space-y-8 relative z-10">
            <span class="inline-flex items-center bg-indigo-50 dark:bg-indigo-900/30 text-brand-primary dark:text-indigo-300 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-indigo-100 dark:border-indigo-800 shadow-sm">
                WADAH AKADEMIK TERKURASI
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-brand-dark dark:text-white leading-[1.1] tracking-tight">
                Menjembatani<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-purple-500 dark:from-indigo-400 dark:to-purple-400">Dunia Akademik</span><br>
                &amp; Industri
            </h1>
            <p class="text-gray-600 dark:text-gray-400 md:text-lg max-w-lg leading-relaxed font-medium">
                Platform penyedia layanan terkurasi bagi mahasiswa berbakat untuk membangun portofolio profesional dan karier wirausaha sejak masa kuliah.
            </p>

            {{-- ── Search Bar Fungsional ── --}}
            <form method="GET" action="{{ route('katalog') }}" class="flex flex-col sm:flex-row gap-3 max-w-lg" id="hero-search-form">
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" id="hero-search-input"
                        placeholder="Cari jasa desain, pemrograman, penulisan…"
                        class="w-full pl-12 pr-4 py-4 text-sm bg-white dark:bg-gray-800 border-2 border-transparent dark:border-gray-700 rounded-2xl outline-none focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-4 focus:ring-brand-primary/10 dark:focus:ring-indigo-500/20 transition-all shadow-lg shadow-gray-200/50 dark:shadow-none font-medium text-gray-700 dark:text-gray-200 placeholder-gray-400">
                </div>
                <button type="submit" id="hero-search-btn"
                    class="bg-brand-primary dark:bg-indigo-600 text-white px-8 py-4 rounded-2xl text-sm font-bold hover:bg-brand-dark dark:hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-900/20 dark:shadow-indigo-900/40 whitespace-nowrap flex-shrink-0">
                    Cari Jasa
                </button>
            </form>

            {{-- Quick category links --}}
            <div class="flex flex-wrap gap-2">
                @if(isset($categories))
                    @foreach($categories->take(4) as $cat)
                        <a href="{{ route('katalog', ['category' => $cat->name]) }}"
                            class="text-xs font-bold text-brand-primary dark:text-indigo-300 bg-white dark:bg-gray-800 hover:bg-indigo-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 px-4 py-2 rounded-xl transition-all shadow-sm hover:shadow-md">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                    @if($categories->count() > 4)
                        <a href="{{ route('katalog') }}"
                            class="text-xs font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-transparent dark:border-gray-700 px-4 py-2 rounded-xl transition-colors">
                            lainnya
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="relative group z-10 hidden md:block">
            <div class="rounded-[2.5rem] overflow-hidden shadow-2xl relative border-[8px] border-white dark:border-gray-800 transform rotate-2 group-hover:rotate-0 transition-transform duration-500">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                    alt="Students collaborating" class="w-full h-auto object-cover transform scale-105 group-hover:scale-100 transition-transform duration-700" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            </div>
            
            <!-- Floating Badge -->
            <div class="absolute -bottom-6 -left-10 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-white/50 dark:border-gray-700 max-w-[240px] transform -rotate-3 group-hover:rotate-0 transition-transform duration-500">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 p-2 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="font-extrabold text-sm text-brand-dark dark:text-white">Talenta Terverifikasi</span>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400 font-medium leading-relaxed">Hanya mahasiswa berprestasi dengan portofolio yang telah terkurasi.</p>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="py-24 bg-white dark:bg-brand-darksurface border-y border-gray-100 dark:border-brand-darkborder transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 md:px-16">
            <div class="text-center mb-20 space-y-4">
                <p class="text-xs font-extrabold text-brand-primary dark:text-indigo-400 tracking-widest uppercase">EKSKLUSIF DI SKILLKUL</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-brand-dark dark:text-white tracking-tight">Fitur Utama untuk Masa Depan Anda</h2>
                <p class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl mx-auto font-medium">Inovasi digital yang dirancang khusus untuk ekosistem pendidikan dan profesional.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Innovator's Tool -->
                <div class="md:col-span-2 bg-gradient-to-br from-brand-primary to-purple-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-indigo-900/20 group">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    <div class="relative z-10">
                        <span class="inline-block bg-white/20 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold tracking-wider mb-6 border border-white/10">FITUR INOVATIF</span>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-4 tracking-tight">Pembuat Portofolio Otomatis</h3>
                        <p class="text-indigo-200 text-base max-w-md leading-relaxed mb-16">
                            Sistem otomatis yang merangkum proyek menjadi portofolio profesional yang siap kerja.
                        </p>
                    </div>
                    <!-- Abstract Design Elements -->
                    <div class="absolute bottom-0 right-10 transform translate-y-10 group-hover:translate-y-4 transition-transform duration-700 opacity-90 flex gap-4">
                        <div class="w-32 h-48 border border-white/20 rounded-t-2xl bg-white/10 backdrop-blur-md flex flex-col p-4 gap-3 shadow-2xl">
                            <div class="w-full h-4 bg-white/30 rounded flex items-center px-2 gap-1"><div class="w-2 h-2 rounded-full bg-red-400"></div><div class="w-2 h-2 rounded-full bg-yellow-400"></div><div class="w-2 h-2 rounded-full bg-green-400"></div></div>
                            <div class="w-3/4 h-3 bg-white/20 rounded"></div>
                            <div class="w-1/2 h-3 bg-white/20 rounded"></div>
                        </div>
                        <div class="w-40 h-56 border border-white/20 rounded-t-2xl bg-white/10 backdrop-blur-md flex flex-col p-4 gap-3 shadow-2xl mt-8">
                            <div class="w-full h-4 bg-white/30 rounded flex items-center px-2 gap-1"><div class="w-2 h-2 rounded-full bg-red-400"></div><div class="w-2 h-2 rounded-full bg-yellow-400"></div><div class="w-2 h-2 rounded-full bg-green-400"></div></div>
                            <div class="w-full h-24 bg-white/10 rounded mt-2"></div>
                            <div class="w-2/3 h-3 bg-white/20 rounded"></div>
                        </div>
                    </div>
                </div>

                <!-- Mode Ujian -->
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-[2.5rem] p-10 border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-2xl font-extrabold text-brand-dark dark:text-white mb-4">Mode Ujian</h3>
                        <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-medium">Nonaktifkan pesanan sementara waktu selama pekan UTS/UAS agar Anda dapat tetap fokus pada studi akademik.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 mt-8 flex justify-between items-center shadow-sm border border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-bold text-brand-dark dark:text-white">Status Akademik</span>
                        <div class="w-12 h-7 bg-brand-primary dark:bg-indigo-500 rounded-full relative p-1 cursor-pointer">
                            <div class="w-5 h-5 bg-white rounded-full ml-auto shadow-md"></div>
                        </div>
                    </div>
                </div>

                <!-- Escrow -->
                <div class="md:col-span-3 bg-white dark:bg-gray-800/50 rounded-[2.5rem] p-10 border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col md:flex-row items-center justify-between gap-12 hover:shadow-xl transition-shadow duration-300">
                    <div class="space-y-6 md:w-1/2">
                        <span class="inline-flex items-center bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider border border-green-200 dark:border-green-800">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            AMAN & TERPERCAYA
                        </span>
                        <h3 class="text-3xl font-extrabold text-brand-dark dark:text-white">Pembayaran Rekening Bersama (Escrow) Midtrans</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed font-medium">
                            Dana aman 100%. Kami menjaga dana Anda di dalam sistem rekening bersama dan hanya akan meneruskannya setelah tugas dikonfirmasi selesai serta memenuhi standar.
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-[2rem] p-8 border border-gray-200 dark:border-gray-700 md:w-1/2 w-full relative overflow-hidden">
                        <!-- Abstract glow -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-green-400/10 rounded-full blur-2xl"></div>
                        
                        <div class="flex justify-between items-end mb-8 relative z-10">
                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Total Proyek</span>
                            <span class="text-3xl font-extrabold text-brand-primary dark:text-indigo-400">Rp2.500.000</span>
                        </div>
                        <div class="space-y-5 relative z-10">
                            <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="font-bold text-gray-900 dark:text-white">Dana Ditahan (Escrow)</span>
                            </div>
                            <div class="flex items-center gap-4 p-4 opacity-60">
                                <div class="w-10 h-10 rounded-full border-2 border-gray-300 dark:border-gray-600 border-dashed flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-600 dark:text-gray-400">Menunggu Konfirmasi Klien...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Jasa Terbaru Section ── -->
    <section class="max-w-7xl mx-auto px-6 md:px-16 py-24">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
            <div>
                <p class="text-xs font-extrabold text-brand-primary dark:text-indigo-400 tracking-widest uppercase mb-2">TERBARU DI SKILLKUL</p>
                <h2 class="text-4xl font-extrabold text-brand-dark dark:text-white tracking-tight">Layanan Unggulan</h2>
            </div>
            <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-brand-dark dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>

        @if(!isset($featuredServices) || $featuredServices->isEmpty())
            <div class="text-center py-20 bg-white dark:bg-brand-darksurface rounded-[2.5rem] border border-gray-100 dark:border-brand-darkborder shadow-sm">
                <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-dark dark:text-white mb-2">Belum ada jasa yang terdaftar</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Jadilah pekerja lepas pertama yang menawarkan jasamu!</p>
                <a href="{{ route('register') }}" class="bg-brand-primary text-white px-8 py-3.5 rounded-xl text-sm font-bold shadow-md hover:bg-brand-dark transition-colors">Daftar Sekarang</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredServices as $svc)
                    <a href="{{ route('jasa.detail', $svc->id) }}"
                        class="group bg-white dark:bg-brand-darksurface rounded-3xl overflow-hidden border border-gray-100 dark:border-brand-darkborder shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 block">

                        {{-- Thumbnail --}}
                        <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-gray-800">
                            @if($svc->image)
                                <img src="{{ Storage::url($svc->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $svc->title }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-brand-primary/30 dark:text-indigo-400/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Badges --}}
                            <div class="absolute top-4 left-4 flex gap-2">
                                @if($svc->type === 'project')
                                    <span class="bg-orange-500/90 backdrop-blur-sm text-white text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-sm">Bisa Negosiasi</span>
                                @else
                                    <span class="bg-green-500/90 backdrop-blur-sm text-white text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-sm">Harga Tetap</span>
                                @endif
                            </div>

                            @if($svc->category)
                                <div class="absolute top-4 right-4 bg-white/90 dark:bg-gray-900/90 text-brand-dark dark:text-white text-[10px] font-extrabold px-3 py-1.5 rounded-lg backdrop-blur-md shadow-sm">
                                    {{ $svc->category->name }}
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="p-6">
                            <h3 class="text-lg font-extrabold text-brand-dark dark:text-white mb-4 line-clamp-2 group-hover:text-brand-primary dark:group-hover:text-indigo-400 transition-colors leading-snug">
                                {{ $svc->title }}
                            </h3>

                            {{-- Pekerja Lepas --}}
                            <div class="flex items-center gap-3 mb-5">
                                @if($svc->freelancer?->profile_photo_path)
                                    <img src="{{ Storage::url($svc->freelancer->profile_photo_path) }}" class="w-8 h-8 rounded-full object-cover shadow-sm">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-brand-primary/10 dark:bg-indigo-500/20 text-brand-primary dark:text-indigo-400 font-extrabold flex items-center justify-center text-xs">
                                        {{ strtoupper(substr($svc->freelancer?->name ?? 'P', 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-sm text-gray-600 dark:text-gray-400 font-bold truncate">{{ $svc->freelancer?->name ?? 'Pekerja Lepas' }}</span>
                                <div class="flex items-center gap-1 ml-auto bg-gray-50 dark:bg-gray-800 px-2 py-1 rounded-md border border-gray-100 dark:border-gray-700">
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">4.8</span>
                                </div>
                            </div>

                            {{-- Harga --}}
                            <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-4">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Mulai dari</p>
                                    <p class="font-extrabold text-xl text-brand-primary dark:text-indigo-400">{{ $svc->price_range }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-brand-primary dark:group-hover:bg-indigo-600 group-hover:text-white text-gray-400 dark:text-gray-500 transition-colors shadow-sm">
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Testimonial Section -->
    <section class="bg-brand-dark py-32 relative overflow-hidden">
        <!-- Abstract glowing orbs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-primary/40 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-[100px]"></div>
        
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <div class="flex justify-center gap-2 mb-10 text-brand-accent">
                @for($i=0; $i<5; $i++)
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                @endfor
            </div>
            <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-[1.3] mx-auto max-w-4xl tracking-tight mb-12">
                "SkillKul bukan sekadar platform pencarian kerja. Platform ini memberikan jaminan keamanan bagi klien, sekaligus menjadi panggung pembuktian bagi mahasiswa."
            </h2>
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 rounded-full border-4 border-brand-accent/30 overflow-hidden mb-4 p-1">
                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=82d385&color=fff" alt="Budi Santoso" class="w-full h-full object-cover rounded-full">
                </div>
                <h4 class="text-white font-extrabold text-xl">Budi Santoso</h4>
                <p class="text-indigo-300 font-medium mt-1">CEO, TechForward Indonesia</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="max-w-5xl mx-auto px-6 py-24 relative z-10 -mt-16 mb-20">
        <div class="bg-gradient-to-r from-brand-primary to-indigo-800 rounded-[3rem] shadow-2xl p-12 md:p-20 text-center border border-white/10 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight relative z-10">Siap Memulai Perjalanan Profesional Anda?</h2>
            <p class="text-indigo-100 text-lg md:text-xl mb-12 max-w-2xl mx-auto relative z-10">Bergabunglah dengan ribuan mahasiswa dan klien yang telah terhubung di dalam ekosistem SkillKul.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                <a href="{{ route('katalog') }}" class="bg-white text-brand-dark px-8 py-4 rounded-2xl text-base font-bold hover:bg-gray-50 transition-colors shadow-lg">
                    Cari Layanan Mahasiswa
                </a>
                <a href="{{ route('register') }}" class="bg-brand-dark text-white px-8 py-4 rounded-2xl text-base font-bold hover:bg-black transition-colors shadow-lg border border-white/10">
                    Daftar Sebagai Pekerja Lepas (Freelancer)
                </a>
            </div>
        </div>
    </section>

@endsection