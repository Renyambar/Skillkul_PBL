@extends('layouts.public')
@section('title', 'Pasar Jasa SkillKul')
@section('content')

    {{-- ── Hero Search ── --}}
    <section class="relative bg-brand-primary dark:bg-brand-dark py-24 px-6 overflow-hidden transition-colors duration-300">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-10 w-72 h-72 bg-brand-secondary/20 rounded-full blur-[80px]"></div>
        
        <div class="max-w-4xl mx-auto relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-8 tracking-tight">
                Apa yang ingin Anda cari, <span class="text-indigo-200 dark:text-indigo-300">{{ Auth::user()?->name ?? 'Pengunjung' }}</span>?
            </h1>

            {{-- ── Search Form ── --}}
            <form method="GET" action="{{ route('katalog') }}" class="mb-8" id="katalog-search-form">
                <div class="bg-white/10 dark:bg-black/20 backdrop-blur-md p-2 rounded-2xl flex items-center shadow-2xl border border-white/10 dark:border-white/5">
                    <div class="pl-5 text-white/70">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="katalog-search-input" value="{{ request('search') }}"
                        placeholder="Cari layanan pemrograman, desain, atau pemeriksaan ejaan..."
                        class="w-full bg-transparent py-4 px-4 text-base text-white placeholder:text-white/60 border-0 outline-none ring-0 focus:border-0 focus:outline-none focus:ring-0 font-medium">
                    {{-- Pertahankan filter tipe jika sudah dipilih --}}
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <button type="submit" id="katalog-search-btn"
                        class="bg-brand-secondary hover:bg-brand-accent hover:text-brand-dark dark:hover:bg-indigo-500 dark:hover:text-white text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg whitespace-nowrap">
                        Temukan
                    </button>
                </div>

                {{-- Filter Tipe --}}
                <div class="flex flex-wrap justify-center gap-3 mt-6">
                    <a href="{{ route('katalog', array_merge(request()->except('type', 'page'), [])) }}" id="filter-semua"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all shadow-sm
                                      {{ !request('type') ? 'bg-white text-brand-primary dark:bg-brand-darksurface dark:text-white' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                        Semua Jenis
                    </a>
                    <a href="{{ route('katalog', array_merge(request()->except('type', 'page'), ['type' => 'non_project'])) }}"
                        id="filter-non-project"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all shadow-sm flex items-center gap-1.5
                                      {{ request('type') == 'non_project' ? 'bg-white text-green-700 dark:bg-green-900/40 dark:text-green-300 dark:border-green-800/50' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                        Non-Proyek (Harga Tetap)
                    </a>
                    <a href="{{ route('katalog', array_merge(request()->except('type', 'page'), ['type' => 'project'])) }}"
                        id="filter-project"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all shadow-sm flex items-center gap-1.5
                                      {{ request('type') == 'project' ? 'bg-white text-orange-700 dark:bg-orange-900/40 dark:text-orange-300 dark:border-orange-800/50' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                        Proyek (Bisa Negosiasi)
                    </a>
                </div>
            </form>

            {{-- ── Category Pills dari DB ── --}}
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('katalog', array_merge(request()->except('category', 'page'), [])) }}"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all
                                  {{ !request('category') ? 'bg-white/20 text-white border border-white/40' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                    Semua Kategori
                </a>
                @forelse($categories as $cat)
                    @if($cat->name)
                        <a href="{{ route('katalog', array_merge(request()->except('category', 'page'), ['category' => $cat->name])) }}"
                            class="px-5 py-2 rounded-full text-sm font-semibold transition-all
                                                          {{ request('category') == $cat->name ? 'bg-white/20 text-white border border-white/40 shadow-inner' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                            {{ $cat->name }}
                        </a>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </section>

    {{-- ── Hasil Pencarian / Daftar Jasa ── --}}
    <section class="max-w-7xl mx-auto px-6 md:px-12 py-16">

        {{-- Header hasil --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-6">
            <div>
                @if(request('search'))
                    <p class="text-xs font-extrabold text-brand-secondary dark:text-indigo-400 tracking-widest uppercase mb-2">HASIL PENCARIAN</p>
                    <h2 class="text-3xl font-black text-brand-dark dark:text-white tracking-tight">
                        "{{ request('search') }}"
                    </h2>
                @elseif(request('category'))
                    <p class="text-xs font-extrabold text-brand-secondary dark:text-indigo-400 tracking-widest uppercase mb-2">KATEGORI</p>
                    <h2 class="text-3xl font-black text-brand-dark dark:text-white tracking-tight">{{ request('category') }}</h2>
                @else
                    <p class="text-xs font-extrabold text-brand-secondary dark:text-indigo-400 tracking-widest uppercase mb-2">PILIHAN PREMIUM</p>
                    <h2 class="text-3xl font-black text-brand-dark dark:text-white tracking-tight">Layanan Unggulan</h2>
                @endif
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                @if(request('search') || request('type') || request('category'))
                    <a href="{{ route('katalog') }}"
                        class="px-5 py-2.5 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 text-red-600 dark:text-red-400 font-bold text-sm rounded-xl border border-red-200 dark:border-red-800/50 hover:border-red-400 transition-all duration-300 flex items-center gap-2 shadow-sm hover:shadow-md hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                @endif
                <div class="px-5 py-2.5 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 text-indigo-700 dark:text-indigo-300 font-bold text-sm rounded-xl border border-indigo-200 dark:border-indigo-800/50 shadow-sm flex items-center gap-2">
                    <span>
                        <span class="text-base font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">{{ $services->total() }}</span>
                        <span class="ml-1">layanan ditemukan</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Grid Jasa ── --}}
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm">
                <div class="w-24 h-24 bg-gray-50 dark:bg-gray-800 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">Tidak ada jasa ditemukan</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm max-w-sm">
                    Coba kata kunci lain atau hapus filter yang aktif.
                </p>
                <a href="{{ route('katalog') }}"
                    class="mt-8 bg-brand-primary text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-brand-dark dark:hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-500/30">
                    Lihat Semua Jasa
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($services as $service)
                    <a href="{{ route('jasa.detail', $service->id) }}"
                        class="group bg-white dark:bg-brand-darksurface rounded-3xl overflow-hidden border border-gray-100 dark:border-brand-darkborder shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 block">

                        {{-- Thumbnail --}}
                        <div class="relative h-48 overflow-hidden bg-indigo-50 dark:bg-indigo-900/20">
                            @if($service->image)
                                <img src="{{ Storage::url($service->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    alt="{{ $service->title }}">
                            @else
                                {{-- Placeholder gradient berdasarkan kategori --}}
                                <div
                                    class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-indigo-300 dark:text-indigo-600/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Badge tipe --}}
                            @if($service->type === 'project')
                                <div
                                    class="absolute top-4 left-4 bg-orange-500 text-white text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-lg">
                                    Bisa Negosiasi</div>
                            @else
                                <div
                                    class="absolute top-4 left-4 bg-green-500 text-white text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-lg">
                                    Harga Tetap</div>
                            @endif

                            {{-- Kategori badge --}}
                            @if($service->category?->name)
                                <div
                                    class="absolute top-4 right-4 bg-white/95 dark:bg-gray-900/95 text-indigo-700 dark:text-indigo-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg backdrop-blur-md shadow-lg border border-white/20 dark:border-gray-700">
                                    {{ $service->category->name }}
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="p-6">
                            <h3
                                class="font-bold text-lg text-gray-900 dark:text-white mb-4 line-clamp-2 group-hover:text-brand-primary dark:group-hover:text-indigo-400 transition-colors leading-snug">
                                {{ $service->title }}
                            </h3>

                            {{-- Pekerja Lepas --}}
                            <div class="flex items-center gap-3 mb-5">
                                @if($service->freelancer)
                                    @if($service->freelancer->profile_photo_path)
                                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                                            class="w-7 h-7 rounded-full object-cover ring-2 ring-indigo-50 dark:ring-indigo-900/50">
                                    @else
                                        <div
                                            class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 text-[10px] font-extrabold flex items-center justify-center flex-shrink-0 ring-2 ring-indigo-50 dark:ring-indigo-900/50">
                                            {{ strtoupper(substr($service->freelancer->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <span
                                        class="text-xs text-gray-600 dark:text-gray-400 font-medium truncate">{{ $service->freelancer->name ?? 'Pekerja Lepas' }}</span>
                                @else
                                    <div
                                        class="w-7 h-7 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 text-[10px] font-extrabold flex items-center justify-center flex-shrink-0">
                                        ?
                                    </div>
                                    <span class="text-xs text-gray-400 font-medium">Tidak Ditemukan</span>
                                @endif
                                <span class="flex items-center gap-1 text-yellow-500 text-xs ml-auto flex-shrink-0 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-md">
                                    ★ <span class="text-gray-700 dark:text-gray-300 font-bold">4.8</span>
                                </span>
                            </div>

                            {{-- Harga --}}
                            <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-800 pt-4">
                                <p class="font-extrabold text-brand-primary dark:text-indigo-400 text-lg">{{ $service->price_range }}</p>
                                <div
                                    class="w-9 h-9 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-brand-primary dark:group-hover:bg-indigo-500 group-hover:text-white text-gray-400 dark:text-gray-500 transition-colors">
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

            {{-- ── Pagination ── --}}
            @if($services->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $services->links() }}
                </div>
            @endif
        @endif

        {{-- ── Escrow Trust Banner ── --}}
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-3xl p-8 md:p-10 mb-10 mt-14 shadow-sm">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-8">
                <div
                    class="w-16 h-16 bg-white dark:bg-indigo-900/50 text-brand-primary dark:text-indigo-400 rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <span
                        class="inline-block bg-brand-primary/10 dark:bg-indigo-500/20 text-brand-primary dark:text-indigo-300 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-widest mb-3">Sistem
                        Rekening Bersama (Escrow) SkillKul</span>
                    <h3 class="text-2xl font-extrabold text-brand-dark dark:text-white mb-2">Dana Anda aman sampai tugas selesai!</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed max-w-3xl">Kami menahan dana Anda di dalam sistem rekening bersama (escrow) yang aman. Pembayaran baru akan diteruskan ke pekerja lepas setelah Anda menyetujui hasil pekerjaannya secara tuntas.</p>
                </div>
                <div>
                    <a href="{{ route('keamanan') }}"
                        class="bg-brand-primary text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-brand-dark dark:hover:bg-indigo-500 transition-all shadow-md whitespace-nowrap block text-center">Pelajari
                        Selengkapnya</a>
                </div>
            </div>
        </div>

        {{-- ── Auto Portofolio Banner ── --}}
        <div class="bg-brand-primary dark:bg-brand-dark rounded-3xl p-8 md:p-12 relative overflow-hidden shadow-xl">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
            </div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 dark:bg-indigo-500/20 rounded-full blur-[80px]"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16 relative z-10">
                <div class="flex-1">
                    <span
                        class="inline-flex items-center gap-1.5 bg-white/10 dark:bg-gray-800/50 text-white px-4 py-1.5 rounded-full text-[10px] font-extrabold tracking-widest uppercase mb-6 border border-white/10">
                        <svg class="w-3 h-3 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" />
                        </svg>
                        KURASI OTOMATIS
                    </span>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">Pembuatan Portofolio Otomatis</h3>
                    <p class="text-indigo-200 dark:text-gray-300 text-base leading-relaxed mb-8 max-w-2xl font-medium">
                    Selesaikan tugas, bangun masa depan. Setiap proyek yang selesai dan mendapat penilaian (rating) &ge; 4 bintang, secara otomatis akan tercatat sebagai portofolio profesional yang terverifikasi.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm text-indigo-100 dark:text-gray-200 font-medium"><span class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-brand-accent text-xs">✓</span>
                            Integrasi Ulasan Terverifikasi</li>
                        <li class="flex items-center gap-3 text-sm text-indigo-100 dark:text-gray-200 font-medium"><span class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-brand-accent text-xs">✓</span>
                            Cetak PDF Portofolio Otomatis</li>
                        <li class="flex items-center gap-3 text-sm text-indigo-100 dark:text-gray-200 font-medium"><span class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-brand-accent text-xs">✓</span>
                            Ekspor ke LinkedIn / CV</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="inline-block bg-brand-accent text-brand-dark px-8 py-3.5 rounded-xl text-sm font-extrabold hover:bg-green-300 dark:hover:bg-green-400 transition-colors shadow-lg">Mulai Sekarang</a>
                </div>
                
                {{-- Decorative Card --}}
                <div class="w-full md:w-80 bg-white/10 dark:bg-gray-800/40 rounded-3xl p-6 md:p-8 backdrop-blur-md border border-white/20 dark:border-white/5 shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 bg-brand-secondary rounded-2xl flex items-center justify-center text-white text-sm font-bold shadow-inner">
                            JD</div>
                        <div>
                            <p class="text-white text-base font-bold">John Doe</p>
                            <p class="text-indigo-200 dark:text-gray-400 text-xs font-medium">Mahasiswa Ilmu Komputer</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="w-full h-3 bg-white/20 dark:bg-white/10 rounded-full"></div>
                        <div class="w-5/6 h-3 bg-white/20 dark:bg-white/10 rounded-full"></div>
                        <div class="w-4/6 h-3 bg-white/20 dark:bg-white/10 rounded-full"></div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-white/10 flex justify-between items-center">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-400 border-2 border-brand-primary"></div>
                            <div class="w-8 h-8 rounded-full bg-purple-400 border-2 border-brand-primary"></div>
                            <div class="w-8 h-8 rounded-full bg-pink-400 border-2 border-brand-primary"></div>
                        </div>
                        <div class="flex items-center gap-1 text-yellow-400 text-sm font-bold">
                            ★ 5.0
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection