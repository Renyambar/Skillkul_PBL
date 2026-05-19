@extends('layouts.freelancer')
@section('title', 'Dompet - SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pendapatan & Dompet</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola saldo penghasilan dari hasil pekerjaan Anda.</p>
        </div>
    </div>

    {{-- Kartu Saldo Utama --}}
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden mb-8">
        {{-- Dekorasi Background --}}
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-1/4 w-32 h-32 bg-indigo-400/20 rounded-full blur-xl"></div>
        
        {{-- Icon Dompet SVG --}}
        <div class="absolute top-8 right-8 text-white/20">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
            </svg>
        </div>
        
        <div class="relative z-10">
            <p class="text-indigo-200 text-xs font-bold uppercase tracking-widest mb-3">SALDO TERSEDIA</p>
            <h2 class="text-4xl md:text-5xl font-extrabold mb-8 tracking-tight">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</h2>
            <button class="bg-white text-indigo-700 px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Tarik Dana
            </button>
        </div>
    </div>

    {{-- Tabel Riwayat Mutasi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900 text-lg">Riwayat Mutasi Pendapatan</h3>
        </div>
        
        @if($transactions->isEmpty())
            <div class="p-16 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h4 class="text-base font-bold text-gray-900 mb-1">Belum ada transaksi masuk</h4>
                <p class="text-sm text-gray-500">Pendapatan bersih dari pesanan yang selesai akan secara otomatis masuk ke dompet digital Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Jasa</th>
                            <th class="px-6 py-4">Klien</th>
                            <th class="px-6 py-4 text-right">Potongan Admin (5%)</th>
                            <th class="px-6 py-4 text-right">Masuk (Bersih)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($transactions as $t)
                            @php
                                $total = $t->total_price ?? 0;
                                $potongan = $total * 0.05;
                                $masuk = $total * 0.95;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-5 text-gray-500 text-xs">{{ $t->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-5 font-bold text-gray-900">{{ $t->service->title ?? 'Layanan' }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 bg-indigo-50 rounded-full flex items-center justify-center text-[10px] font-bold text-indigo-600">{{ substr($t->client->name ?? 'C', 0, 1) }}</div>
                                        <span class="text-gray-700 font-medium">{{ $t->client->name ?? 'Client' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right font-semibold text-red-500 text-xs">- Rp {{ number_format($potongan, 0, ',', '.') }}</td>
                                <td class="px-6 py-5 text-right font-extrabold text-green-600">+ Rp {{ number_format($masuk, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Wrapper --}}
            @if($transactions->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
