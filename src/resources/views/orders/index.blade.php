@extends('layouts.client')
@section('title', 'Pesanan Saya - SkillKul')
@section('content')
@php
    $statusConfig = [
        'pending'         => ['label' => 'Belum Dibayar',       'bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        'waiting_payment' => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        'paid'            => ['label' => 'Dibayar',             'bg' => 'bg-sky-100 dark:bg-sky-900/30',    'text' => 'text-sky-800 dark:text-sky-400'],
        'in_progress'     => ['label' => 'Dikerjakan',          'bg' => 'bg-blue-100 dark:bg-blue-900/30',   'text' => 'text-blue-800 dark:text-blue-400'],
        'revision'        => ['label' => 'Revisi',              'bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-800 dark:text-orange-400'],
        'delivered'       => ['label' => 'Terkirim',            'bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-800 dark:text-purple-400'],
        'completed'       => ['label' => 'Selesai',             'bg' => 'bg-green-100 dark:bg-green-900/30',  'text' => 'text-green-800 dark:text-green-400'],
        'canceled'        => ['label' => 'Dibatalkan',          'bg' => 'bg-red-100 dark:bg-red-900/30',    'text' => 'text-red-800 dark:text-red-400'],
    ];
@endphp

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 transition-colors duration-300">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark dark:text-white tracking-tight">Pesanan Saya</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau status dan hasil kerja freelancer.</p>
        </div>
        <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 bg-brand-primary dark:bg-indigo-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-brand-dark dark:hover:bg-indigo-500 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Cari Jasa Baru
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-300 text-sm font-semibold rounded-xl px-5 py-4 flex items-center gap-3 transition-colors">
            <svg class="w-5 h-5 shrink-0 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-800 dark:text-red-300 text-sm font-semibold rounded-xl px-5 py-4 flex items-center gap-3 transition-colors">
            <svg class="w-5 h-5 shrink-0 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Seksi 1: Belum Dibayar ────────────────────────────── --}}
    @if($pendingOrders->isNotEmpty())
    <div class="mb-8">
        <h2 class="text-sm font-extrabold text-yellow-700 dark:text-yellow-500 uppercase tracking-widest mb-3 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse inline-block"></span>
            Menunggu Pembayaran ({{ $pendingOrders->count() }})
        </h2>
        <div class="space-y-4">
            @foreach($pendingOrders as $order)
            <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800/30 rounded-2xl p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition-colors">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-mono text-gray-400 dark:text-gray-500">#{{ substr($order->id, 0, 8) }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-400 tracking-wider">Belum Dibayar</span>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $order->service->title ?? '—' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Pekerja Lepas: {{ $order->freelancer->name ?? '—' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <p class="font-extrabold text-brand-primary dark:text-indigo-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <a href="{{ route('checkout', $order->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold px-4 py-2 rounded-xl transition-all shadow-sm whitespace-nowrap">
                        Bayar Sekarang
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Seksi 2: Pesanan Aktif ────────────────────────────── --}}
    @if($activeOrders->isEmpty() && $pendingOrders->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-16 text-center transition-colors">
            <svg class="mx-auto h-16 w-16 text-gray-200 dark:text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Belum ada pesanan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Telusuri jasa freelancer mahasiswa dan mulai pesanan pertamamu.</p>
            <a href="{{ route('katalog') }}" class="inline-flex items-center px-6 py-2.5 bg-brand-primary dark:bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-brand-dark dark:hover:bg-indigo-500 transition-all shadow-md">
                Cari Layanan
            </a>
        </div>
    @elseif($activeOrders->isNotEmpty())
        @if($pendingOrders->isNotEmpty())
        <h2 class="text-sm font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-3">Pesanan Aktif</h2>
        @endif
        <div class="space-y-4">
            @foreach($activeOrders as $order)
                @php
                    $st = $statusConfig[$order->status] ?? ['label' => ucfirst($order->status), 'bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-800 dark:text-gray-300'];
                @endphp
                <a href="{{ route('pesanan.detail', $order->id) }}" class="block bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-5 hover:shadow-md hover:border-brand-primary/50 dark:hover:border-indigo-500/50 transition-all duration-200 group">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        {{-- Info --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-xs font-mono text-gray-400 dark:text-gray-500">#{{ substr($order->id, 0, 8) }}</span>
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider {{ $st['bg'] }} {{ $st['text'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-brand-primary dark:group-hover:text-indigo-400 transition-colors">
                                {{ $order->service->title ?? 'Layanan tidak ditemukan' }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                Pekerja Lepas: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $order->freelancer->name ?? '—' }}</span>
                                &bull; {{ $order->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                            </p>
                        </div>

                        {{-- Price + Arrow --}}
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-xs text-gray-400 dark:text-gray-500">Total</p>
                                <p class="font-extrabold text-brand-primary dark:text-indigo-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 group-hover:text-brand-primary dark:group-hover:text-indigo-400 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($activeOrders->hasPages())
        <div class="mt-6">
            {{ $activeOrders->links() }}
        </div>
        @endif
    @endif
</div>
@endsection
