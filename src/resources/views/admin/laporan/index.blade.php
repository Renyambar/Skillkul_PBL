@extends('layouts.admin')
@section('title', 'Admin - Laporan Masuk')
@section('content')
@php
    $statusConfig = [
        'pending'      => ['label' => 'Menunggu', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'ditinjau'     => ['label' => 'Ditinjau', 'bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
        'diselesaikan' => ['label' => 'Selesai',  'bg' => 'bg-green-100',  'text' => 'text-green-700'],
        'ditolak'      => ['label' => 'Ditolak',  'bg' => 'bg-red-100',    'text' => 'text-red-700'],
    ];
    $kategoriConfig = [
        'penipuan'              => ['label' => 'Penipuan',             'bg' => 'bg-red-100',    'text' => 'text-red-700'],
        'tidak_selesai'         => ['label' => 'Tidak Diselesaikan',   'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
        'kualitas_buruk'        => ['label' => 'Kualitas Buruk',       'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'perilaku_tidak_pantas' => ['label' => 'Perilaku Tdk Pantas', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
        'lainnya'               => ['label' => 'Lainnya',              'bg' => 'bg-gray-100',   'text' => 'text-gray-600'],
    ];
@endphp

<div class="p-8 lg:p-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Laporan Masuk</h1>
            <p class="text-sm text-gray-500 mt-1">Tinjau dan tangani laporan yang dikirimkan oleh klien.</p>
        </div>
        <div class="flex items-center gap-3">
            @if($stats['pending'] > 0)
                <span class="bg-red-100 text-red-700 text-xs font-bold px-4 py-2 rounded-lg">
                    🚨 {{ $stats['pending'] }} Laporan Menunggu
                </span>
            @endif
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-4 py-2 rounded-lg">
                Total: {{ $stats['total'] }} Laporan
            </span>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-3 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-yellow-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-yellow-600 mb-1">Menunggu</p>
            <p class="text-3xl font-extrabold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-blue-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-blue-600 mb-1">Ditinjau</p>
            <p class="text-3xl font-extrabold text-blue-600">{{ $stats['ditinjau'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-green-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-green-600 mb-1">Diselesaikan</p>
            <p class="text-3xl font-extrabold text-green-600">{{ $stats['diselesaikan'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-gray-500 mb-1">Ditolak</p>
            <p class="text-3xl font-extrabold text-gray-500">{{ $stats['ditolak'] }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.laporan.index') }}"
           class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ !request('status') ? 'bg-brand-primary text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Semua
        </a>
        @foreach(['pending' => 'Menunggu', 'ditinjau' => 'Ditinjau', 'diselesaikan' => 'Diselesaikan', 'ditolak' => 'Ditolak'] as $val => $lbl)
            <a href="{{ route('admin.laporan.index', ['status' => $val]) }}"
               class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ request('status') === $val ? 'bg-brand-primary text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                {{ $lbl }}
            </a>
        @endforeach

        {{-- Search --}}
        <div class="ml-auto flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama pengguna..."
                   class="border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-700 outline-none focus:border-brand-primary transition-colors">
            <button type="submit" class="bg-brand-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-brand-dark transition-colors">
                Cari
            </button>
        </div>
    </form>

    {{-- Reports Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Terlapor</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reports as $report)
                    @php
                        $st = $statusConfig[$report->status] ?? ['label' => $report->status, 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
                        $kt = $kategoriConfig[$report->category] ?? ['label' => $report->category, 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors {{ in_array($report->status, ['diselesaikan', 'ditolak']) ? 'opacity-60' : '' }}">
                        <td class="px-6 py-5 font-mono text-xs text-gray-500">#{{ $report->id }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($report->reporter->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">{{ $report->reporter->name ?? 'Dihapus' }}</p>
                                    <p class="text-[10px] text-gray-400">Klien</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($report->reported->name ?? 'F', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">{{ $report->reported->name ?? 'Dihapus' }}</p>
                                    <p class="text-[10px] text-gray-400">Pekerja Lepas</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="{{ $kt['bg'] }} {{ $kt['text'] }} text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider whitespace-nowrap">
                                {{ $kt['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5 max-w-xs">
                            <p class="text-xs text-gray-600 line-clamp-2">{{ $report->description }}</p>
                            @if($report->order_id)
                                <p class="text-[10px] text-gray-400 mt-1 font-mono">Order: #{{ substr($report->order_id, 0, 8) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <span class="{{ $st['bg'] }} {{ $st['text'] }} text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider whitespace-nowrap">
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-xs text-gray-500 whitespace-nowrap">
                            {{ $report->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                        </td>
                        <td class="px-6 py-5 text-right">
                            <a href="{{ route('admin.laporan.show', $report->id) }}"
                               class="bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors whitespace-nowrap">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-semibold text-sm">Belum ada laporan yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($reports->hasPages())
        <div class="border-t border-gray-100 px-6 py-4">
            {{ $reports->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
