@extends('layouts.admin')
@section('title', 'Admin - Detail Jasa')

@section('content')
<div class="p-8 lg:p-10">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.services.index') }}" class="hover:text-brand-primary transition-colors font-semibold">Katalog Jasa</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-semibold">Detail Jasa</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- ── Left: Main Info ── --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- Cover --}}
            @if($service->image)
                <img src="{{ Storage::url($service->image) }}"
                     class="w-full h-56 object-cover rounded-2xl border border-gray-100 shadow-sm">
            @else
                <div class="w-full h-56 rounded-2xl bg-indigo-50 flex flex-col items-center justify-center border border-indigo-100">
                    <svg class="w-12 h-12 text-indigo-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-indigo-300 font-semibold">Belum ada gambar</p>
                </div>
            @endif

            {{-- Title + badges --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-start justify-between gap-4 mb-3">
                    <h1 class="text-xl font-extrabold text-brand-dark leading-snug">{{ $service->title }}</h1>
                    @if($service->is_active)
                        <span class="flex-shrink-0 inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Aktif
                        </span>
                    @else
                        <span class="flex-shrink-0 inline-flex items-center gap-1.5 bg-red-100 text-red-600 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>Nonaktif
                        </span>
                    @endif
                </div>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-indigo-50 text-indigo-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">
                        {{ $service->category?->name ?? '–' }}
                    </span>
                    @if($service->type === 'project')
                        <span class="bg-purple-50 text-purple-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Proyek</span>
                    @else
                        <span class="bg-blue-50 text-blue-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Non-Proyek</span>
                    @endif
                    <span class="bg-gray-100 text-gray-500 text-[10px] font-extrabold px-2.5 py-1 rounded-md font-mono">#{{ $service->id }}</span>
                </div>
                <p class="text-2xl font-extrabold text-brand-primary">{{ $service->price_range }}</p>
                <p class="text-sm text-gray-500 mt-1">Dibuat {{ $service->created_at->diffForHumans() }}</p>
            </div>

            {{-- Deskripsi --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-3">Deskripsi</h2>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $service->description }}</p>
            </div>

            {{-- Statistik pesanan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-4">Statistik Pesanan</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <p class="text-2xl font-extrabold text-brand-dark">{{ $service->orders->count() }}</p>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-widest mt-1">Total</p>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-xl">
                        <p class="text-2xl font-extrabold text-green-600">{{ $service->orders->where('status', 'selesai')->count() }}</p>
                        <p class="text-[10px] text-green-500 font-semibold uppercase tracking-widest mt-1">Selesai</p>
                    </div>
                    <div class="text-center p-3 bg-amber-50 rounded-xl">
                        <p class="text-2xl font-extrabold text-amber-600">{{ $service->orders->whereIn('status', ['menunggu', 'diproses'])->count() }}</p>
                        <p class="text-[10px] text-amber-500 font-semibold uppercase tracking-widest mt-1">Proses</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right: Sidebar ── --}}
        <div class="w-full lg:w-80 flex-shrink-0 space-y-4">

            {{-- Pekerja Lepas --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h2 class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-4">Pekerja Lepas</h2>
                <div class="flex items-center gap-3">
                    @if($service->freelancer?->profile_photo_path)
                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                             class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-lg font-extrabold flex-shrink-0">
                            {{ strtoupper(substr($service->freelancer?->name ?? '?', 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ $service->freelancer?->name ?? '–' }}</p>
                        <p class="text-[10px] text-gray-400">{{ $service->freelancer?->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-2">
                <h2 class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-3">Aksi Cepat</h2>

                <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 font-bold text-sm px-4 py-3 rounded-xl transition-colors
                                   {{ $service->is_active
                                       ? 'bg-amber-50 text-amber-700 hover:bg-amber-100'
                                       : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                        @if($service->is_active)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Nonaktifkan Jasa
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Aktifkan Jasa
                        @endif
                    </button>
                </form>
            </div>

            {{-- Timestamp --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-3">
                <h2 class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-1">Info</h2>
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Dibuat</p>
                    <p class="text-sm text-gray-700 font-semibold mt-0.5">{{ $service->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Diperbarui</p>
                    <p class="text-sm text-gray-700 font-semibold mt-0.5">{{ $service->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
