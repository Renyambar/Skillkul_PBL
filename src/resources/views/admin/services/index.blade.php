@extends('layouts.admin')
@section('title', 'Admin - Katalog Layanan')

@section('content')
<div class="p-8 lg:p-10 transition-colors duration-300">

    {{-- ── Header ── --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight">Katalog Layanan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium">Pantau dan kelola status semua layanan yang terdaftar oleh pekerja lepas.</p>
    </div>

    {{-- ── Flash Message ── --}}
    @if(session('success'))
        <div id="flash-msg" class="flex items-center gap-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-300 text-sm font-semibold px-5 py-4 rounded-2xl mb-6 shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-green-400 dark:text-green-500 hover:text-green-600 dark:hover:text-green-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-800 dark:text-red-300 text-sm font-semibold px-5 py-4 rounded-2xl mb-6 shadow-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-indigo-100 dark:border-indigo-900/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-indigo-500 dark:text-indigo-400 mb-2 relative z-10">Total Layanan</p>
            <p class="text-4xl font-black text-brand-dark dark:text-white relative z-10">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-green-100 dark:border-green-900/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-green-600 dark:text-green-500 mb-2 relative z-10">Aktif</p>
            <p class="text-4xl font-black text-green-600 dark:text-green-500 relative z-10">{{ $stats['aktif'] }}</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-red-100 dark:border-red-900/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-red-500 dark:text-red-400 mb-2 relative z-10">Nonaktif</p>
            <p class="text-4xl font-black text-red-500 dark:text-red-400 relative z-10">{{ $stats['nonaktif'] }}</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-purple-100 dark:border-purple-900/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-purple-600 dark:text-purple-400 mb-2 relative z-10">Proyek</p>
            <p class="text-4xl font-black text-purple-600 dark:text-purple-400 relative z-10">{{ $stats['project'] }}</p>
        </div>
    </div>

    {{-- ── Filter & Search ── --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('admin.services.index') }}"
              class="flex flex-wrap gap-4 items-end">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2">Cari</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="search-input" type="text" name="search" value="{{ request('search') }}"
                           placeholder="Judul layanan atau nama pekerja lepas…"
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 transition-colors">
                </div>
            </div>
            {{-- Status --}}
            <div class="min-w-[140px]">
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2">Status</label>
                <select name="status" id="filter-status"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 appearance-none font-medium transition-colors">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            {{-- Kategori --}}
            <div class="min-w-[160px]">
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2">Kategori</label>
                <select name="category_id" id="filter-category"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 appearance-none font-medium transition-colors">
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
                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2">Tipe</label>
                <select name="type" id="filter-type"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 appearance-none font-medium transition-colors">
                    <option value="">Semua Tipe</option>
                    <option value="non_project" {{ request('type') === 'non_project' ? 'selected' : '' }}>Non-Proyek</option>
                    <option value="project"     {{ request('type') === 'project'     ? 'selected' : '' }}>Proyek</option>
                </select>
            </div>
            {{-- Buttons --}}
            <div class="flex gap-3">
                <button type="submit" id="filter-submit"
                        class="bg-brand-primary dark:bg-indigo-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-brand-dark dark:hover:bg-indigo-500 transition-colors shadow-sm shadow-indigo-200 dark:shadow-none">
                    Filter
                </button>
                <a href="{{ route('admin.services.index') }}"
                   class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden">
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="text-gray-600 dark:text-gray-400 font-bold">Tidak ada layanan yang ditemukan.</p>
                <p class="text-gray-500 dark:text-gray-500 text-xs mt-1 font-medium">Coba ubah filter pencarian Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                            <th class="px-6 py-5 whitespace-nowrap">Layanan</th>
                            <th class="px-6 py-5 whitespace-nowrap">Pekerja Lepas</th>
                            <th class="px-6 py-5 whitespace-nowrap">Kategori</th>
                            <th class="px-6 py-5 whitespace-nowrap">Tipe</th>
                            <th class="px-6 py-5 whitespace-nowrap">Harga</th>
                            <th class="px-6 py-5 whitespace-nowrap">Status</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($services as $service)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ !$service->is_active ? 'opacity-60 grayscale-[30%]' : '' }}">
                            {{-- Layanan --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($service->image)
                                        <img src="{{ Storage::url($service->image) }}"
                                             class="w-12 h-12 rounded-xl object-cover flex-shrink-0 bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0 border border-indigo-100 dark:border-indigo-800/50">
                                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-900 dark:text-white truncate max-w-[200px]">{{ $service->title }}</p>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 font-mono font-medium">#{{ $service->id }}</p>
                                    </div>
                                </div>
                            </td>
                            {{-- Pekerja Lepas --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($service->freelancer?->profile_photo_path)
                                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                                             class="w-8 h-8 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-[10px] font-black border border-indigo-100 dark:border-indigo-800/50">
                                            {{ strtoupper(substr($service->freelancer?->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $service->freelancer?->name ?? '–' }}</span>
                                </div>
                            </td>
                            {{-- Kategori --}}
                            <td class="px-6 py-4">
                                <span class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50 text-indigo-700 dark:text-indigo-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider inline-block">
                                    {{ $service->category?->name ?? '–' }}
                                </span>
                            </td>
                            {{-- Tipe --}}
                            <td class="px-6 py-4">
                                @if($service->type === 'project')
                                    <span class="bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800/50 text-purple-700 dark:text-purple-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider inline-block">Proyek</span>
                                @else
                                    <span class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 text-blue-700 dark:text-blue-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider inline-block">Non-Proyek</span>
                                @endif
                            </td>
                            {{-- Harga --}}
                            <td class="px-6 py-4">
                                <p class="text-xs font-black text-gray-900 dark:text-white">{{ $service->price_range }}</p>
                            </td>
                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($service->is_active)
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/50 text-green-700 dark:text-green-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/50 text-red-600 dark:text-red-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
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
                                       class="p-2 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-brand-primary dark:hover:text-indigo-400 transition-colors border border-gray-200 dark:border-gray-700">
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
                                                class="p-2 rounded-xl transition-colors border {{ $service->is_active ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-500 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/40 hover:text-amber-700 dark:hover:text-amber-300 border-amber-200 dark:border-amber-800/50' : 'bg-green-50 dark:bg-green-900/20 text-green-500 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40 hover:text-green-700 dark:hover:text-green-300 border-green-200 dark:border-green-800/50' }}">
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
                <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400 font-medium">
                    <p class="text-xs">
                        Menampilkan {{ $services->firstItem() }}–{{ $services->lastItem() }} dari <strong class="text-brand-dark dark:text-white font-black">{{ $services->total() }}</strong> layanan
                    </p>
                    <div>
                        {{ $services->links() }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
