@extends('layouts.admin')
@section('title', 'Admin - Laporan Masuk')
@section('content')
@php
    $statusConfig = [
        'pending'      => ['label' => 'Menunggu', 'bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400', 'border' => 'border-yellow-200 dark:border-yellow-800/50'],
        'ditinjau'     => ['label' => 'Ditinjau', 'bg' => 'bg-blue-100 dark:bg-blue-900/30',   'text' => 'text-blue-700 dark:text-blue-400', 'border' => 'border-blue-200 dark:border-blue-800/50'],
        'diselesaikan' => ['label' => 'Selesai',  'bg' => 'bg-green-100 dark:bg-green-900/30',  'text' => 'text-green-700 dark:text-green-400', 'border' => 'border-green-200 dark:border-green-800/50'],
        'ditolak'      => ['label' => 'Ditolak',  'bg' => 'bg-red-100 dark:bg-red-900/30',    'text' => 'text-red-700 dark:text-red-400', 'border' => 'border-red-200 dark:border-red-800/50'],
    ];
    $kategoriConfig = [
        'penipuan'              => ['label' => 'Penipuan',             'bg' => 'bg-red-50 dark:bg-red-900/20',    'text' => 'text-red-700 dark:text-red-400', 'border' => 'border-red-100 dark:border-red-800/30'],
        'tidak_selesai'         => ['label' => 'Tidak Diselesaikan',   'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' => 'text-orange-700 dark:text-orange-400', 'border' => 'border-orange-100 dark:border-orange-800/30'],
        'kualitas_buruk'        => ['label' => 'Kualitas Buruk',       'bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'text' => 'text-yellow-700 dark:text-yellow-400', 'border' => 'border-yellow-100 dark:border-yellow-800/30'],
        'perilaku_tidak_pantas' => ['label' => 'Perilaku Tidak Pantas', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-700 dark:text-purple-400', 'border' => 'border-purple-100 dark:border-purple-800/30'],
        'lainnya'               => ['label' => 'Lainnya',              'bg' => 'bg-gray-50 dark:bg-gray-800',   'text' => 'text-gray-600 dark:text-gray-400', 'border' => 'border-gray-200 dark:border-gray-700'],
    ];
@endphp

<div class="p-8 lg:p-10 transition-colors duration-300">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight">Laporan Masuk</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium">Tinjau dan tangani laporan yang dikirimkan oleh klien.</p>
        </div>
        <div class="flex items-center gap-3">
            @if($stats['pending'] > 0)
                <span class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-100 dark:border-red-800/50 text-xs font-bold px-4 py-2 rounded-xl shadow-sm flex items-center gap-2">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                    </span>
                    {{ $stats['pending'] }} Laporan Menunggu
                </span>
            @endif
            <span class="bg-indigo-50 dark:bg-indigo-900/30 text-brand-primary dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/50 text-xs font-bold px-4 py-2 rounded-xl shadow-sm">
                Total: {{ $stats['total'] }} Laporan
            </span>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-300 rounded-2xl px-5 py-4 text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-yellow-100 dark:border-yellow-900/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-yellow-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-yellow-600 dark:text-yellow-500 mb-2 relative z-10">Menunggu</p>
            <p class="text-4xl font-black text-yellow-600 dark:text-yellow-500 relative z-10">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-blue-100 dark:border-blue-900/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-blue-600 dark:text-blue-500 mb-2 relative z-10">Ditinjau</p>
            <p class="text-4xl font-black text-blue-600 dark:text-blue-500 relative z-10">{{ $stats['ditinjau'] }}</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-green-100 dark:border-green-900/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-green-600 dark:text-green-500 mb-2 relative z-10">Diselesaikan</p>
            <p class="text-4xl font-black text-green-600 dark:text-green-500 relative z-10">{{ $stats['diselesaikan'] }}</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <p class="text-[11px] font-extrabold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 relative z-10">Ditolak</p>
            <p class="text-4xl font-black text-gray-500 dark:text-gray-400 relative z-10">{{ $stats['ditolak'] }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap gap-3 mb-8 items-center bg-white dark:bg-brand-darksurface p-4 rounded-2xl border border-gray-100 dark:border-brand-darkborder shadow-sm">
        <div class="flex flex-wrap gap-2 flex-1">
            <a href="{{ route('admin.laporan.index') }}"
               class="px-5 py-2.5 text-xs font-bold rounded-xl transition-all {{ !request('status') ? 'bg-brand-primary dark:bg-indigo-600 text-white shadow-sm shadow-indigo-200 dark:shadow-none' : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                Semua
            </a>
            @foreach(['pending' => 'Menunggu', 'ditinjau' => 'Ditinjau', 'diselesaikan' => 'Diselesaikan', 'ditolak' => 'Ditolak'] as $val => $lbl)
                <a href="{{ route('admin.laporan.index', ['status' => $val]) }}"
                   class="px-5 py-2.5 text-xs font-bold rounded-xl transition-all {{ request('status') === $val ? 'bg-brand-primary dark:bg-indigo-600 text-white shadow-sm shadow-indigo-200 dark:shadow-none' : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    {{ $lbl }}
                </a>
            @endforeach
        </div>

        {{-- Search --}}
        <div class="flex gap-2 w-full sm:w-auto mt-2 sm:mt-0">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari pelapor / terlapor..."
                       class="w-full border border-gray-200 dark:border-gray-700 rounded-xl pl-9 pr-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 placeholder-gray-400 outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 transition-colors">
            </div>
            <button type="submit" class="bg-brand-primary dark:bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-brand-dark dark:hover:bg-indigo-500 transition-colors shadow-sm shadow-indigo-200 dark:shadow-none shrink-0">
                Cari
            </button>
        </div>
    </form>

    {{-- Reports Table --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                        <th class="px-6 py-5 whitespace-nowrap">ID</th>
                        <th class="px-6 py-5 whitespace-nowrap">Pelapor</th>
                        <th class="px-6 py-5 whitespace-nowrap">Terlapor</th>
                        <th class="px-6 py-5 whitespace-nowrap">Kategori</th>
                        <th class="px-6 py-5 whitespace-nowrap">Deskripsi</th>
                        <th class="px-6 py-5 whitespace-nowrap">Status</th>
                        <th class="px-6 py-5 whitespace-nowrap">Tanggal</th>
                        <th class="px-6 py-5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($reports as $report)
                    @php
                        $st = $statusConfig[$report->status] ?? ['label' => $report->status, 'bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-600 dark:text-gray-400', 'border' => 'border-gray-200 dark:border-gray-700'];
                        $kt = $kategoriConfig[$report->category] ?? ['label' => $report->category, 'bg' => 'bg-gray-50 dark:bg-gray-800', 'text' => 'text-gray-600 dark:text-gray-400', 'border' => 'border-gray-200 dark:border-gray-700'];
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ in_array($report->status, ['diselesaikan', 'ditolak']) ? 'opacity-60 grayscale-[30%]' : '' }}">
                        <td class="px-6 py-4 font-mono text-[11px] font-bold text-gray-500 dark:text-gray-400">
                            <span class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-lg border border-gray-200 dark:border-gray-700">#{{ $report->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 flex items-center justify-center font-black text-[10px] flex-shrink-0 border border-indigo-100 dark:border-indigo-800/50">
                                    {{ strtoupper(substr($report->reporter->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-xs">{{ $report->reporter->name ?? 'Dihapus' }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium">Klien</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 flex items-center justify-center font-black text-[10px] flex-shrink-0 border border-orange-100 dark:border-orange-800/50">
                                    {{ strtoupper(substr($report->reported->name ?? 'F', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-xs">{{ $report->reported->name ?? 'Dihapus' }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium">Pekerja Lepas</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ $kt['bg'] }} {{ $kt['text'] }} {{ $kt['border'] }} border text-[10px] font-extrabold px-2.5 py-1.5 rounded-lg uppercase tracking-wider inline-block">
                                {{ $kt['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-[200px]">
                            <p class="text-[11px] text-gray-600 dark:text-gray-400 line-clamp-2 font-medium" title="{{ $report->description }}">{{ $report->description }}</p>
                            @if($report->order_id)
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1.5 font-mono font-bold">
                                    <span class="bg-gray-50 dark:bg-gray-800 px-1.5 py-0.5 rounded border border-gray-100 dark:border-gray-700">Psn: #{{ substr($report->order_id, 0, 8) }}</span>
                                </p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ $st['bg'] }} {{ $st['text'] }} {{ $st['border'] }} border text-[10px] font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-wider inline-flex items-center gap-1.5">
                                @if($report->status === 'pending') <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> @endif
                                @if($report->status === 'ditinjau') <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> @endif
                                @if($report->status === 'diselesaikan') <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> @endif
                                @if($report->status === 'ditolak') <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> @endif
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-[11px] font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $report->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.laporan.show', $report->id) }}"
                               class="inline-flex items-center justify-center bg-indigo-50 dark:bg-indigo-900/20 text-brand-primary dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/30 px-4 py-2 rounded-xl text-[11px] font-bold hover:bg-indigo-100 dark:hover:bg-indigo-900/40 hover:text-brand-dark dark:hover:text-indigo-300 transition-colors whitespace-nowrap">
                                Detail <span class="ml-1 text-sm leading-none">→</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 font-bold">Belum ada laporan yang masuk.</p>
                                    <p class="text-xs text-gray-500 mt-1 font-medium">Platform aman terkendali.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($reports->hasPages())
        <div class="border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/10 px-6 py-5">
            {{ $reports->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
