@extends('layouts.client')
@section('title', 'Pesanan Saya - SkillKul')
@section('content')
@php
    // Status config sesuai dengan instruksi badge Tailwind
    $statusConfig = [
        'pending'     => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
        'paid'        => ['label' => 'Dibayar', 'bg' => 'bg-sky-100', 'text' => 'text-sky-800'],
        'in_progress' => ['label' => 'Dalam Proses', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
        'delivered'   => ['label' => 'Terkirim', 'bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
        'completed'   => ['label' => 'Selesai', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
        'canceled'    => ['label' => 'Dibatalkan', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Pesanan Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau status pesanan dan hasil kerja freelancer.</p>
        </div>
    </div>

    @if($orders->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada pesanan</h3>
            <p class="text-sm text-gray-500">Anda belum membuat pesanan apapun. Silakan telusuri layanan yang tersedia di pasar layanan.</p>
            <a href="{{ route('katalog') }}" class="mt-6 inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors">
                Cari Layanan
            </a>
        </div>
    @else
        {{-- Card List --}}
        <div class="grid grid-cols-1 gap-6">
            @foreach($orders as $order)
                @php 
                    $st = $statusConfig[$order->status] ?? ['label' => 'Unknown', 'bg' => 'bg-gray-100', 'text' => 'text-gray-800']; 
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:shadow-md transition-all duration-200">
                    
                    {{-- Order Info --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-xs font-mono text-gray-500">#{{ substr($order->id, 0, 8) }}</span>
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider {{ $st['bg'] }} {{ $st['text'] }}">
                                {{ $st['label'] }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $order->service->title ?? 'Layanan tidak ditemukan' }}</h3>
                        <p class="text-sm text-gray-500 mb-2">
                            Freelancer: <span class="font-medium text-gray-700">{{ $order->freelancer->name ?? 'User tidak ditemukan' }}</span>
                        </p>
                        <p class="text-xs text-gray-400 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Price and Action --}}
                    <div class="flex flex-col md:items-end w-full md:w-auto gap-4 md:gap-3 border-t md:border-t-0 pt-4 md:pt-0 border-gray-100">
                        <div class="text-left md:text-right">
                            <p class="text-xs text-gray-500 mb-0.5">Total Harga</p>
                            <p class="text-lg font-extrabold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('pesanan.detail', $order->id) }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 hover:text-indigo-600 transition-colors focus:ring-4 focus:ring-gray-100 w-full md:w-auto">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
