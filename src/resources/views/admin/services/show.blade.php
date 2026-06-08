@extends('layouts.admin')
@section('title', 'Admin - Detail Jasa')

@section('content')
<div class="p-8 lg:p-10 transition-colors duration-300">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-8">
        <a href="{{ route('admin.services.index') }}" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Katalog Jasa</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-800 dark:text-gray-200">Detail Jasa</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- ── Left: Main Info ── --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- Cover --}}
            @if($service->image)
                <img src="{{ Storage::url($service->image) }}"
                     class="w-full h-72 object-cover rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm">
            @else
                <div class="w-full h-72 rounded-3xl bg-indigo-50/50 dark:bg-indigo-900/10 flex flex-col items-center justify-center border border-indigo-100/50 dark:border-indigo-800/30">
                    <svg class="w-16 h-16 text-indigo-200 dark:text-indigo-800/50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-indigo-400 dark:text-indigo-600/50 font-bold tracking-wide">Belum ada gambar</p>
                </div>
            @endif

            {{-- Title + badges --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-8">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <h1 class="text-2xl lg:text-3xl font-black text-brand-dark dark:text-white leading-snug">{{ $service->title }}</h1>
                    @if($service->is_active)
                        <span class="flex-shrink-0 inline-flex items-center gap-1.5 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Aktif
                        </span>
                    @else
                        <span class="flex-shrink-0 inline-flex items-center gap-1.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>Nonaktif
                        </span>
                    @endif
                </div>
                <div class="flex flex-wrap gap-2.5 mb-6">
                    <span class="bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-widest">
                        {{ $service->category?->name ?? '–' }}
                    </span>
                    @if($service->type === 'project')
                        <span class="bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 border border-purple-100 dark:border-purple-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-widest">Proyek</span>
                    @else
                        <span class="bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-widest">Non-Proyek</span>
                    @endif
                    <span class="bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 text-[10px] font-extrabold px-3 py-1.5 rounded-lg font-mono">#{{ $service->id }}</span>
                </div>
                <p class="text-3xl font-black text-brand-primary dark:text-indigo-400">{{ $service->price_range }}</p>
                <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-2">Dibuat {{ $service->created_at->diffForHumans() }}</p>
            </div>

            {{-- Deskripsi --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-8">
                <h2 class="text-[11px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    Deskripsi
                </h2>
                <div class="prose prose-sm dark:prose-invert max-w-none">
                    <p class="text-[13px] text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap font-medium">{{ $service->description }}</p>
                </div>
            </div>

            {{-- Statistik pesanan --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-8">
                <h2 class="text-[11px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Statistik Pesanan
                </h2>
                <div class="grid grid-cols-3 gap-4 lg:gap-6">
                    <div class="text-center p-5 bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50 rounded-2xl relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-gray-200/50 dark:bg-gray-700/30 rounded-full blur-xl group-hover:scale-110 transition-transform"></div>
                        <p class="text-3xl font-black text-brand-dark dark:text-white relative z-10">{{ $service->orders->count() }}</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 font-extrabold uppercase tracking-widest mt-2 relative z-10">Total</p>
                    </div>
                    <div class="text-center p-5 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/50 rounded-2xl relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-green-500/10 rounded-full blur-xl group-hover:scale-110 transition-transform"></div>
                        <p class="text-3xl font-black text-green-600 dark:text-green-400 relative z-10">{{ $service->orders->where('status', 'selesai')->count() }}</p>
                        <p class="text-[10px] text-green-600 dark:text-green-500 font-extrabold uppercase tracking-widest mt-2 relative z-10">Selesai</p>
                    </div>
                    <div class="text-center p-5 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/50 rounded-2xl relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-amber-500/10 rounded-full blur-xl group-hover:scale-110 transition-transform"></div>
                        <p class="text-3xl font-black text-amber-600 dark:text-amber-400 relative z-10">{{ $service->orders->whereIn('status', ['menunggu', 'diproses'])->count() }}</p>
                        <p class="text-[10px] text-amber-600 dark:text-amber-500 font-extrabold uppercase tracking-widest mt-2 relative z-10">Proses</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right: Sidebar ── --}}
        <div class="w-full lg:w-80 flex-shrink-0 space-y-6">

            {{-- Pekerja Lepas --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6">
                <h2 class="text-[11px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Pekerja Lepas
                </h2>
                <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    @if($service->freelancer?->profile_photo_path)
                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                             class="w-14 h-14 rounded-xl object-cover shadow-sm">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xl font-black flex-shrink-0 shadow-inner">
                            {{ strtoupper(substr($service->freelancer?->name ?? '?', 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white text-sm truncate">{{ $service->freelancer?->name ?? '–' }}</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate mt-0.5">{{ $service->freelancer?->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 space-y-4">
                <h2 class="text-[11px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Aksi Cepat
                </h2>

                <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 font-bold text-sm px-5 py-3.5 rounded-xl transition-all shadow-sm
                                   {{ $service->is_active
                                       ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50 hover:bg-amber-100 dark:hover:bg-amber-900/40 shadow-amber-200/50 dark:shadow-none'
                                       : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/50 hover:bg-green-100 dark:hover:bg-green-900/40 shadow-green-200/50 dark:shadow-none' }}">
                        @if($service->is_active)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Nonaktifkan Jasa
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Aktifkan Jasa
                        @endif
                    </button>
                </form>
            </div>

            {{-- Timestamp --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 space-y-4">
                <h2 class="text-[11px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Informasi Waktu
                </h2>
                <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50 space-y-3">
                    <div>
                        <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Dibuat</p>
                        <p class="text-[13px] text-gray-900 dark:text-white font-bold mt-1">{{ $service->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700/50">
                        <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Diperbarui</p>
                        <p class="text-[13px] text-gray-900 dark:text-white font-bold mt-1">{{ $service->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
