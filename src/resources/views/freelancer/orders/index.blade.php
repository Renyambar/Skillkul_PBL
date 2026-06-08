@extends('layouts.freelancer')
@section('title', 'Pesanan Masuk - SkillKul')
@section('content')
@php
    $statusConfig = [
        'pending'     => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        'paid'        => ['label' => 'Dibayar', 'bg' => 'bg-sky-100 dark:bg-sky-900/30', 'text' => 'text-sky-800 dark:text-sky-400'],
        'in_progress' => ['label' => 'Dalam Proses', 'bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
        'delivered'   => ['label' => 'Terkirim', 'bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-800 dark:text-purple-400'],
        'completed'   => ['label' => 'Selesai', 'bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
        'canceled'    => ['label' => 'Dibatalkan', 'bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 transition-colors duration-300">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Pesanan Masuk</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau, kelola, dan proses semua pesanan dari klien Anda.</p>
        </div>
        <a href="{{ route('freelancer.invoice.create') ?? '#' }}" class="inline-flex items-center gap-2 bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-500 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Buat Tagihan Baru
        </a>
    </div>

    @if($orders->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-12 text-center transition-colors">
            <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Belum ada pesanan masuk</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Anda belum memiliki pesanan aktif saat ini.</p>
        </div>
    @else
        {{-- Card List --}}
        <div class="grid grid-cols-1 gap-6">
            @foreach($orders as $order)
                @php 
                    $st = $statusConfig[$order->status] ?? ['label' => 'Unknown', 'bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-800 dark:text-gray-300']; 
                @endphp
                <div class="bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 hover:shadow-md transition-all duration-200">
                    
                    {{-- Order Info --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <span class="text-xs font-mono text-gray-500 dark:text-gray-400">#{{ substr($order->id, 0, 8) }}</span>
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider {{ $st['bg'] }} {{ $st['text'] }}">
                                {{ $st['label'] }}
                            </span>
                            @if($order->type === 'project')
                                <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Proyek</span>
                            @else
                                <span class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Non-Proyek</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $order->service->title ?? 'Layanan tidak ditemukan' }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            Klien: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $order->client->name ?? 'User tidak ditemukan' }}</span>
                        </p>
                        <p class="text-xs text-gray-400 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Price and Action --}}
                    <div class="flex flex-col lg:items-end w-full lg:w-96 gap-4 border-t lg:border-t-0 pt-4 lg:pt-0 border-gray-100 dark:border-gray-800">
                        <div class="text-left lg:text-right w-full flex lg:flex-col justify-between lg:justify-start items-center lg:items-end">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Total Nilai</p>
                            <p class="text-lg font-extrabold text-brand-primary dark:text-indigo-400">Rp {{ number_format($order->total_price ?? $order->price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="w-full">
                            @if(in_array($order->status, ['in_progress', 'paid', 'revision']))
                                <div x-data="{ open: false }" class="w-full">
                                    <button @click="open = !open" class="w-full inline-flex justify-center items-center px-5 py-2.5 {{ $order->status === 'revision' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-500' }} text-white text-sm font-bold rounded-xl transition-colors focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900/50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        {{ $order->status === 'revision' ? 'Kirim Revisi' : 'Kirim Hasil' }}
                                    </button>
                                    
                                    <div x-show="open" x-transition class="mt-3 bg-indigo-50 dark:bg-indigo-900/10 rounded-xl p-4 border border-indigo-100 dark:border-indigo-800/30 text-left w-full">
                                        <form action="{{ route('freelancer.pesanan.submitResult', $order->id) }}" method="POST">
                                            @csrf
                                            <label class="block text-[10px] font-extrabold text-indigo-800 dark:text-indigo-400 uppercase tracking-widest mb-2">Link Hasil Kerja (Google Drive)</label>
                                            <input type="url" name="freelancer_result_link" placeholder="Link Google Drive hasil kerja" required class="w-full bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white outline-none focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-1 focus:ring-brand-primary dark:focus:ring-indigo-500 mb-3 transition-colors">
                                            <button type="submit" class="w-full bg-green-600 dark:bg-green-500 text-white py-2 rounded-lg text-xs font-bold hover:bg-green-700 dark:hover:bg-green-600 transition-colors">Serahkan Hasil</button>
                                        </form>
                                    </div>
                                </div>

                            @elseif($order->status === 'delivered')
                                <div class="w-full bg-purple-50 dark:bg-purple-900/10 border border-purple-100 dark:border-purple-800/30 rounded-xl px-4 py-3 text-center">
                                    <span class="text-purple-700 dark:text-purple-400 text-xs font-bold flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Menunggu konfirmasi klien
                                    </span>
                                </div>
                            @elseif($order->status === 'completed')
                                <div class="w-full bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-800/30 rounded-xl px-4 py-3 text-center">
                                    <span class="text-green-700 dark:text-green-400 text-sm font-bold flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Selesai ✓
                                    </span>
                                </div>
                            @else
                                <div class="w-full text-center py-2">
                                    <span class="text-gray-400 dark:text-gray-500 text-xs font-medium">–</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8 dark:text-gray-300">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
