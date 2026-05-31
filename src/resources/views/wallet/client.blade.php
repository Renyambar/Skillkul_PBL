@extends('layouts.client')
@section('title', 'Dompet Saya - SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Dompet Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Saldo dari refund order yang dibatalkan.</p>
        </div>
        <a href="{{ route('withdrawal.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Tarik Saldo
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    {{-- Kartu Saldo --}}
    <div class="bg-gradient-to-br from-emerald-600 to-teal-600 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden mb-8">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-1/4 w-32 h-32 bg-emerald-400/20 rounded-full blur-xl"></div>
        <div class="relative z-10">
            <p class="text-emerald-200 text-xs font-bold uppercase tracking-widest mb-3">SALDO WALLET</p>
            <h2 class="text-4xl md:text-5xl font-extrabold mb-2 tracking-tight">
                Rp {{ number_format($balance ?? 0, 0, ',', '.') }}
            </h2>
            <p class="text-emerald-200 text-xs mb-6">
                Saldo dari refund order. Bisa digunakan untuk order baru atau ditarik.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('katalog') }}"
                   class="bg-white text-emerald-700 px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm inline-flex items-center gap-2">
                    Gunakan untuk Order Baru
                </a>
                <a href="{{ route('withdrawal.create') }}"
                   class="bg-white/20 text-white border border-white/30 px-6 py-3 rounded-xl text-sm font-bold hover:bg-white/30 transition-colors inline-flex items-center gap-2">
                    Tarik Saldo
                </a>
            </div>
        </div>
    </div>

    {{-- Riwayat Ledger --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-gray-900 text-lg">Riwayat Transaksi Wallet</h3>
        </div>

        @if($transactions->isEmpty())
            <div class="p-16 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h4 class="text-base font-bold text-gray-900 mb-1">Belum ada transaksi</h4>
                <p class="text-sm text-gray-500">
                    Refund dari order yang dibatalkan akan muncul di sini.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-right">Jumlah</th>
                            <th class="px-6 py-4 text-right">Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($transactions as $tx)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">
                                {{ $tx->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-gray-800 font-medium max-w-xs">
                                <div class="truncate">{{ $tx->description }}</div>
                                @if($tx->order)
                                    <div class="text-xs text-gray-400 mt-0.5">
                                        Order #{{ substr($tx->order_id, 0, 8) }}...
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    {{ $tx->category === 'refund' ? 'bg-green-50 text-green-700' :
                                       ($tx->category === 'withdrawal' ? 'bg-orange-50 text-orange-700' :
                                       'bg-gray-50 text-gray-600') }}">
                                    {{ $tx->category_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-extrabold whitespace-nowrap
                                {{ $tx->type === 'credit' ? 'text-green-600' : 'text-red-500' }}">
                                {{ $tx->type === 'credit' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-gray-700 font-semibold whitespace-nowrap">
                                Rp {{ number_format($tx->balance_after, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
