@extends('layouts.admin')
@section('title', 'Admin - Katalog Jasa')

@section('content')
<div class="p-8 lg:p-10">

    {{-- ── Header ── --}}
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Katalog Jasa</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau dan kelola status semua jasa yang terdaftar oleh freelancer.</p>
    </div>

    {{-- ── Flash Message ── --}}
    @if(session('success'))
        <div id="flash-msg" class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm font-semibold px-5 py-3 rounded-xl mb-6">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-green-400 hover:text-green-600">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm font-semibold px-5 py-3 rounded-xl mb-6">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-indigo-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-500 mb-1">Total Jasa</p>
            <p class="text-3xl font-extrabold text-brand-dark">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-green-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-green-600 mb-1">Aktif</p>
            <p class="text-3xl font-extrabold text-green-600">{{ $stats['aktif'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-red-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-red-500 mb-1">Nonaktif</p>
            <p class="text-3xl font-extrabold text-red-500">{{ $stats['nonaktif'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-purple-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-purple-600 mb-1">Project</p>
            <p class="text-3xl font-extrabold text-purple-600">{{ $stats['project'] }}</p>
        </div>
    </div>

    {{-- ── Filter & Search ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('admin.services.index') }}"
              class="flex flex-wrap gap-3 items-end">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 mb-1.5">Cari</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="search-input" type="text" name="search" value="{{ request('search') }}"
                           placeholder="Judul jasa atau nama freelancer…"
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl outline-none focus:border-brand-primary transition-colors">
                </div>
            </div>
            {{-- Status --}}
            <div class="min-w-[140px]">
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 mb-1.5">Status</label>
                <select name="status" id="filter-status"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl outline-none focus:border-brand-primary transition-colors bg-white">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            {{-- Kategori --}}
            <div class="min-w-[160px]">
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 mb-1.5">Kategori</label>
                <select name="category_id" id="filter-category"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl outline-none focus:border-brand-primary transition-colors bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Tipe --}}
            <div class="min-w-[140px]">
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 mb-1.5">Tipe</label>
                <select name="type" id="filter-type"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl outline-none focus:border-brand-primary transition-colors bg-white">
                    <option value="">Semua Tipe</option>
                    <option value="non_project" {{ request('type') === 'non_project' ? 'selected' : '' }}>Non-Project</option>
                    <option value="project"     {{ request('type') === 'project'     ? 'selected' : '' }}>Project</option>
                </select>
            </div>
            {{-- Buttons --}}
            <div class="flex gap-2">
                <button type="submit" id="filter-submit"
                        class="bg-brand-primary text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-brand-dark transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.services.index') }}"
                   class="bg-gray-100 text-gray-600 text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold">Tidak ada jasa yang ditemukan.</p>
                <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau tambahkan jasa baru.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-4">Jasa</th>
                            <th class="px-6 py-4">Freelancer</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($services as $service)
                        <tr class="hover:bg-gray-50/50 transition-colors {{ !$service->is_active ? 'opacity-60' : '' }}">
                            {{-- Jasa --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($service->image)
                                        <img src="{{ Storage::url($service->image) }}"
                                             class="w-10 h-10 rounded-xl object-cover flex-shrink-0 bg-gray-100">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-900 truncate max-w-[180px]">{{ $service->title }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">#{{ $service->id }}</p>
                                    </div>
                                </div>
                            </td>
                            {{-- Freelancer --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($service->freelancer?->profile_photo_path)
                                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                                             class="w-7 h-7 rounded-full object-cover">
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-[10px] font-extrabold">
                                            {{ strtoupper(substr($service->freelancer?->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="text-xs font-semibold text-gray-700">{{ $service->freelancer?->name ?? '–' }}</span>
                                </div>
                            </td>
                            {{-- Kategori --}}
                            <td class="px-6 py-4">
                                <span class="bg-indigo-50 text-indigo-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">
                                    {{ $service->category?->name ?? '–' }}
                                </span>
                            </td>
                            {{-- Tipe --}}
                            <td class="px-6 py-4">
                                @if($service->type === 'project')
                                    <span class="bg-purple-50 text-purple-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Project</span>
                                @else
                                    <span class="bg-blue-50 text-blue-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Non-Project</span>
                                @endif
                            </td>
                            {{-- Harga --}}
                            <td class="px-6 py-4">
                                <p class="text-xs font-bold text-gray-800">{{ $service->price_range }}</p>
                            </td>
                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($service->is_active)
                                    <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-600 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            {{-- Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.services.show', $service) }}"
                                       title="Lihat Detail"
                                       class="p-2 rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    {{-- Toggle Aktif/Nonaktif --}}
                                    <form method="POST" action="{{ route('admin.services.toggle', $service) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                title="{{ $service->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                class="p-2 rounded-lg transition-colors {{ $service->is_active ? 'bg-amber-50 text-amber-500 hover:bg-amber-100 hover:text-amber-700' : 'bg-green-50 text-green-500 hover:bg-green-100 hover:text-green-700' }}">
                                            @if($service->is_active)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($services->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-400">
                        Menampilkan {{ $services->firstItem() }}–{{ $services->lastItem() }} dari {{ $services->total() }} jasa
                    </p>
                    {{ $services->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
