@extends('layouts.client')
@section('title', 'Pesanan Saya - SkillKul')
@section('content')
@php
    $statusConfig = [
        'pending'         => ['label' => 'Belum Dibayar',       'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
        'waiting_payment' => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
        'paid'            => ['label' => 'Dibayar',             'bg' => 'bg-sky-100',    'text' => 'text-sky-800'],
        'in_progress'     => ['label' => 'Dikerjakan',          'bg' => 'bg-blue-100',   'text' => 'text-blue-800'],
        'revision'        => ['label' => 'Revisi',              'bg' => 'bg-orange-100', 'text' => 'text-orange-800'],
        'delivered'       => ['label' => 'Terkirim',            'bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
        'completed'       => ['label' => 'Selesai',             'bg' => 'bg-green-100',  'text' => 'text-green-800'],
        'canceled'        => ['label' => 'Dibatalkan',          'bg' => 'bg-red-100',    'text' => 'text-red-800'],
    ];
@endphp

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Pesanan Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau status dan hasil kerja freelancer.</p>
        </div>
        <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 bg-brand-primary text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-brand-dark transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Cari Jasa Baru
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 text-sm font-semibold rounded-xl px-5 py-4 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 text-sm font-semibold rounded-xl px-5 py-4 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Seksi 1: Belum Dibayar ────────────────────────────── --}}
    @if($pendingOrders->isNotEmpty())
    <div class="mb-8">
        <h2 class="text-sm font-extrabold text-yellow-700 uppercase tracking-widest mb-3 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse inline-block"></span>
            Menunggu Pembayaran ({{ $pendingOrders->count() }})
        </h2>
        <div class="space-y-4">
            @foreach($pendingOrders as $order)
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-mono text-gray-400">#{{ substr($order->id, 0, 8) }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-yellow-100 text-yellow-800 tracking-wider">Belum Dibayar</span>
                    </div>
                    <p class="font-bold text-gray-900 text-sm">{{ $order->service->title ?? '—' }}</p>
                    <p class="text-xs text-gray-500">Pekerja Lepas: {{ $order->freelancer->name ?? '—' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <p class="font-extrabold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
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
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada pesanan</h3>
            <p class="text-sm text-gray-500 mb-6">Telusuri jasa freelancer mahasiswa dan mulai pesanan pertamamu.</p>
            <a href="{{ route('katalog') }}" class="inline-flex items-center px-6 py-2.5 bg-brand-primary text-white text-sm font-bold rounded-xl hover:bg-brand-dark transition-all shadow-md">
                Cari Layanan
            </a>
        </div>
    @elseif($activeOrders->isNotEmpty())
        @if($pendingOrders->isNotEmpty())
        <h2 class="text-sm font-extrabold text-gray-500 uppercase tracking-widest mb-3">Pesanan Aktif</h2>
        @endif
        <div class="space-y-4">
            @foreach($activeOrders as $order)
                @php
                    $st = $statusConfig[$order->status] ?? ['label' => ucfirst($order->status), 'bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                @endphp
                <a href="{{ route('pesanan.detail', $order->id) }}" class="block bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-indigo-100 transition-all duration-200 group">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        {{-- Info --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-xs font-mono text-gray-400">#{{ substr($order->id, 0, 8) }}</span>
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider {{ $st['bg'] }} {{ $st['text'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 group-hover:text-brand-primary transition-colors">
                                {{ $order->service->title ?? 'Layanan tidak ditemukan' }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Pekerja Lepas: <span class="font-medium text-gray-700">{{ $order->freelancer->name ?? '—' }}</span>
                                &bull; {{ $order->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                            </p>
                        </div>

                        {{-- Price + Arrow --}}
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-xs text-gray-400">Total</p>
                                <p class="font-extrabold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-brand-primary transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
