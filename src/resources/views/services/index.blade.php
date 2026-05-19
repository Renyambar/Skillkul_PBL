@extends('layouts.public')
@section('title', 'Pasar Jasa SkillKul')
@section('content')

    {{-- ── Hero Search ── --}}
    <section class="relative bg-brand-primary py-20 px-6 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px]"></div>
        <div class="max-w-4xl mx-auto relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-8 tracking-tight">
                Apa yang ingin Anda cari, {{ Auth::user()?->name ?? 'Pengunjung' }}?
            </h1>

            {{-- ── Search Form ── --}}
            <form method="GET" action="{{ route('katalog') }}" class="mb-6" id="katalog-search-form">
                <div class="bg-white/10 backdrop-blur-md p-2 rounded-2xl flex items-center shadow-2xl">
                    <div class="pl-4 text-white/70">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="katalog-search-input" value="{{ request('search') }}"
                        placeholder="Cari jasa pemrograman, desain, atau pemeriksaan ejaan..."
                        class="w-full bg-transparent py-4 px-4 text-sm text-white placeholder:text-sm placeholder-white/50 border-0 outline-none ring-0 focus:border-0 focus:outline-none focus:ring-0 font-medium">
                    {{-- Pertahankan filter tipe jika sudah dipilih --}}
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <button type="submit" id="katalog-search-btn"
                        class="bg-brand-secondary hover:bg-brand-accent hover:text-brand-dark text-white px-8 py-3.5 rounded-xl font-bold transition-colors shadow-lg whitespace-nowrap">
                        Temukan
                    </button>
                </div>

                {{-- Filter Tipe --}}
                <div class="flex flex-wrap justify-center gap-3 mt-6">
                    <a href="{{ route('katalog', array_merge(request()->except('type', 'page'), [])) }}" id="filter-semua"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-colors
                                      {{ !request('type') ? 'bg-white text-brand-primary' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                        🔍 Semua Jenis
                    </a>
                    <a href="{{ route('katalog', array_merge(request()->except('type', 'page'), ['type' => 'non_project'])) }}"
                        id="filter-non-project"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-colors flex items-center gap-1.5
                                      {{ request('type') == 'non_project' ? 'bg-white text-green-700' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                        💰 Non-Project (Harga Pas)
                    </a>
                    <a href="{{ route('katalog', array_merge(request()->except('type', 'page'), ['type' => 'project'])) }}"
                        id="filter-project"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-colors flex items-center gap-1.5
                                      {{ request('type') == 'project' ? 'bg-white text-orange-700' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                        🤝 Project (Bisa Nego)
                    </a>
                </div>
            </form>

            {{-- ── Category Pills dari DB ── --}}
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('katalog', array_merge(request()->except('category', 'page'), [])) }}"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-colors
                                  {{ !request('category') ? 'bg-white/20 text-white border border-white/40' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                    Semua Kategori
                </a>
                @forelse($categories as $cat)
                    @if($cat->name)
                        <a href="{{ route('katalog', array_merge(request()->except('category', 'page'), ['category' => $cat->name])) }}"
                            class="px-5 py-2 rounded-full text-sm font-semibold transition-colors
                                                          {{ request('category') == $cat->name ? 'bg-white/20 text-white border border-white/40' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }}">
                            {{ $cat->name }}
                        </a>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </section>

    {{-- ── Hasil Pencarian / Daftar Jasa ── --}}
    <section class="max-w-7xl mx-auto px-6 md:px-12 py-14">

        {{-- Header hasil --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                @if(request('search'))
                    <p class="text-xs font-extrabold text-brand-secondary tracking-widest uppercase mb-1">HASIL PENCARIAN</p>
                    <h2 class="text-2xl font-black text-brand-dark tracking-tight">
                        "{{ request('search') }}"
                    </h2>
                @elseif(request('category'))
                    <p class="text-xs font-extrabold text-brand-secondary tracking-widest uppercase mb-1">KATEGORI</p>
                    <h2 class="text-2xl font-black text-brand-dark tracking-tight">{{ request('category') }}</h2>
                @else
                    <p class="text-xs font-extrabold text-brand-secondary tracking-widest uppercase mb-1">PILIHAN PREMIUM</p>
                    <h2 class="text-2xl font-black text-brand-dark tracking-tight">Layanan Unggulan</h2>
                @endif
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
                @if(request('search') || request('type') || request('category'))
                    <a href="{{ route('katalog') }}"
                        class="px-4 py-2 bg-gradient-to-r from-red-50 to-pink-50 text-red-600 hover:from-red-100 hover:to-pink-100 font-bold text-sm rounded-lg border border-red-200 hover:border-red-400 transition-all duration-300 flex items-center gap-1.5 shadow-sm hover:shadow-md hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                @endif
                <div class="px-4 py-2 bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-bold text-sm rounded-lg border border-indigo-200 shadow-sm flex items-center gap-2">
                    <span>
                        <span class="text-sm font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">{{ $services->total() }}</span>
                        <span class="text-indigo-600 ml-1">jasa ditemukan</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Grid Jasa ── --}}
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-extrabold text-gray-700 mb-2">Tidak ada jasa ditemukan</h3>
                <p class="text-gray-400 text-sm max-w-sm">
                    Coba kata kunci lain atau hapus filter yang aktif.
                </p>
                <a href="{{ route('katalog') }}"
                    class="mt-6 bg-brand-primary text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-brand-dark transition-colors">
                    Lihat Semua Jasa
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 mb-10">
                @foreach($services as $service)
                    <a href="{{ route('jasa.detail', $service->id) }}"
                        class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">

                        {{-- Thumbnail --}}
                        <div class="relative h-44 overflow-hidden bg-indigo-50">
                            @if($service->image)
                                <img src="{{ Storage::url($service->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    alt="{{ $service->title }}">
                            @else
                                {{-- Placeholder gradient berdasarkan kategori --}}
                                <div
                                    class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Badge tipe --}}
                            @if($service->type === 'project')
                                <div
                                    class="absolute top-3 left-3 bg-orange-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">
                                    Bisa Nego</div>
                            @else
                                <div
                                    class="absolute top-3 left-3 bg-green-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">
                                    Harga Pas</div>
                            @endif

                            {{-- Kategori badge --}}
                            @if($service->category?->name)
                                <div
                                    class="absolute top-3 right-3 bg-white/90 text-indigo-700 text-[10px] font-extrabold px-2.5 py-1 rounded-lg backdrop-blur-sm shadow">
                                    {{ $service->category->name }}
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="p-5">
                            <h3
                                class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors leading-snug">
                                {{ $service->title }}
                            </h3>

                            {{-- Freelancer --}}
                            <div class="flex items-center gap-2 mb-4">
                                @if($service->freelancer)
                                    @if($service->freelancer->profile_photo_path)
                                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                                            class="w-6 h-6 rounded-full object-cover">
                                    @else
                                        <div
                                            class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-[10px] font-extrabold flex items-center justify-center flex-shrink-0">
                                            {{ strtoupper(substr($service->freelancer->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <span
                                        class="text-xs text-gray-500 font-medium truncate">{{ $service->freelancer->name ?? 'Freelancer' }}</span>
                                @else
                                    <div
                                        class="w-6 h-6 rounded-full bg-gray-200 text-gray-400 text-[10px] font-extrabold flex items-center justify-center flex-shrink-0">
                                        ?
                                    </div>
                                    <span class="text-xs text-gray-400 font-medium">Freelancer Tidak Ditemukan</span>
                                @endif
                                <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto flex-shrink-0">
                                    ★ <span class="text-gray-600 font-bold">4.8</span>
                                </span>
                            </div>

                            {{-- Harga --}}
                            <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                                <p class="font-extrabold text-brand-primary">{{ $service->price_range }}</p>
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

            {{-- ── Pagination ── --}}
            @if($services->hasPages())
                <div class="flex justify-center mt-4">
                    {{ $services->links() }}
                </div>
            @endif
        @endif

        {{-- ── Escrow Trust Banner ── --}}
        <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-8 mb-8 mt-10">
            <div class="flex items-start gap-5">
                <div
                    class="w-14 h-14 bg-indigo-100 text-brand-primary rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <span
                        class="inline-block bg-brand-primary/10 text-brand-primary text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-widest mb-3">Sistem
                        Escrow SkillKul</span>
                    <h3 class="text-xl font-extrabold text-brand-dark mb-2">Uangmu aman sampai tugas selesai!</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">Kami menahan dana Anda di sistem escrow yang aman.
                        Pembayaran baru akan diteruskan ke freelancer hanya setelah Anda menyetujui hasil kerjanya.</p>
                    <a href="{{ route('keamanan') }}"
                        class="bg-brand-primary text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-brand-dark transition-all">Pelajari
                        Selengkapnya</a>
                </div>
            </div>
        </div>

        {{-- ── Auto Portfolio Banner ── --}}
        <div class="bg-brand-primary rounded-3xl p-8 md:p-10 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5">
            </div>
            <div class="flex flex-col md:flex-row items-center gap-10 relative z-10">
                <div class="flex-1">
                    <span
                        class="inline-flex items-center gap-1.5 bg-white/10 text-white px-3 py-1 rounded-full text-[10px] font-extrabold tracking-widest uppercase mb-4 border border-white/10">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" />
                        </svg>
                        DIDUKUNG OLEH AI
                    </span>
                    <h3 class="text-2xl font-extrabold text-white mb-3">Pembuatan Portofolio Otomatis</h3>
                    <p class="text-indigo-200 text-sm leading-relaxed mb-6">Selesaikan tugas, bangun masa depan. Setiap
                        proyek yang selesai dan mendapat rating ≥ 4 bintang akan otomatis tercatat sebagai portofolio
                        profesional yang terverifikasi.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center gap-2 text-sm text-indigo-100"><span class="text-brand-accent">✦</span>
                            Integrasi Ulasan Terverifikasi</li>
                        <li class="flex items-center gap-2 text-sm text-indigo-100"><span class="text-brand-accent">✦</span>
                            Cetak PDF Portofolio Otomatis</li>
                        <li class="flex items-center gap-2 text-sm text-indigo-100"><span class="text-brand-accent">✦</span>
                            Ekspor ke LinkedIn/CV</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="inline-block bg-brand-accent text-brand-dark px-6 py-3 rounded-xl text-sm font-bold hover:bg-green-300 transition-colors shadow-lg">Daftar
                        Sekarang</a>
                </div>
                <div class="w-full md:w-80 bg-white/10 rounded-2xl p-6 backdrop-blur-sm border border-white/10">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 bg-brand-secondary rounded-full flex items-center justify-center text-white text-xs font-bold">
                            JD</div>
                        <div>
                            <p class="text-white text-sm font-bold">John Doe</p>
                            <p class="text-indigo-300 text-[10px]">Mahasiswa Ilmu Komputer</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="w-full h-3 bg-white/10 rounded"></div>
                        <div class="w-3/4 h-3 bg-white/10 rounded"></div>
                        <div class="w-1/2 h-3 bg-white/10 rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection