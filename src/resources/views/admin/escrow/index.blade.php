@extends('layouts.admin')
@section('title', 'Escrow Dasbor - Admin SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 transition-colors duration-300">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Escrow Dasbor</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium">Pantau dana yang sedang ditahan dan telah diproses platform.</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Total Held --}}
        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <p class="text-[11px] font-extrabold uppercase tracking-widest text-indigo-200">Dana Ditahan</p>
                <span class="bg-white/20 dark:bg-black/20 text-white text-[10px] font-bold px-2.5 py-1.5 rounded-xl backdrop-blur-sm border border-white/10">{{ $summary['held']['count'] }} order</span>
            </div>
            <p class="text-3xl font-black relative z-10 mb-1">Rp {{ number_format($summary['held']['total'], 0, ',', '.') }}</p>
            <p class="text-indigo-200 text-[11px] font-medium relative z-10">Belum release / refund</p>
        </div>

        {{-- Total Platform Fee --}}
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 dark:from-emerald-700 dark:to-teal-900 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <p class="text-[11px] font-extrabold uppercase tracking-widest text-emerald-100">Pendapatan Platform</p>
                <span class="bg-white/20 dark:bg-black/20 text-white text-[10px] font-bold px-2.5 py-1.5 rounded-xl backdrop-blur-sm border border-white/10">{{ config('skillkul.platform_fee_percent', 8) }}% fee</span>
            </div>
            <p class="text-3xl font-black relative z-10 mb-1">Rp {{ number_format($totalPlatformFee, 0, ',', '.') }}</p>
            <p class="text-emerald-100 text-[11px] font-medium relative z-10">Total fee dari escrow released</p>
        </div>

        {{-- Released --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-500/5 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <p class="text-[11px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500">Dilepas ke Pekerja</p>
                <span class="bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800/50 text-[10px] font-bold px-2.5 py-1.5 rounded-xl">{{ $summary['released']['count'] }}</span>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white relative z-10 mb-1">Rp {{ number_format($summary['released']['total'], 0, ',', '.') }}</p>
            <p class="text-gray-400 dark:text-gray-500 text-[11px] font-medium relative z-10">Escrow released</p>
        </div>

        {{-- Refunded --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-500/5 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <p class="text-[11px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500">Direfund ke Klien</p>
                <span class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-100 dark:border-red-800/50 text-[10px] font-bold px-2.5 py-1.5 rounded-xl">{{ $summary['refunded']['count'] }}</span>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white relative z-10 mb-1">Rp {{ number_format($summary['refunded']['total'], 0, ',', '.') }}</p>
            <p class="text-gray-400 dark:text-gray-500 text-[11px] font-medium relative z-10">Deadline miss / cancel</p>
        </div>
    </div>

    {{-- Escrow Table --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-brand-primary dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="font-extrabold text-gray-900 dark:text-white text-xl">Semua Record Escrow</h3>
            </div>
            <a href="{{ route('admin.transactions.index') }}"
               class="inline-flex items-center justify-center text-sm text-brand-primary dark:text-indigo-400 font-bold hover:text-brand-dark dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 px-4 py-2 rounded-xl transition-colors border border-indigo-100 dark:border-indigo-800/30">
                Lihat Ledger Transaksi <span class="ml-1 text-lg leading-none">→</span>
            </a>
        </div>

        @if($recentEscrows->isEmpty())
            <div class="p-20 text-center text-gray-400 dark:text-gray-500">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-gray-700">
                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="font-bold text-gray-600 dark:text-gray-400">Belum ada record escrow.</p>
                <p class="text-xs mt-1 font-medium">Transaksi escrow akan muncul di sini setelah ada pesanan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                            <th class="px-6 py-5 whitespace-nowrap">Order</th>
                            <th class="px-6 py-5 whitespace-nowrap">Klien → Pekerja Lepas</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Gross</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Platform Fee (8%)</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Pekerja Lepas (92%)</th>
                            <th class="px-6 py-5 text-center whitespace-nowrap">Status</th>
                            <th class="px-6 py-5 whitespace-nowrap">Tipe Release</th>
                            <th class="px-6 py-5 whitespace-nowrap">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($recentEscrows as $escrow)
                        @php
                            $statusColors = [
                                'held'     => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800/50',
                                'released' => 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800/50',
                                'refunded' => 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50',
                            ];
                            $releaseLabels = [
                                'manual_accept'   => 'Manual Accept',
                                'auto_complete'   => 'Auto Complete (48 jam)',
                                'refund_deadline' => 'Refund — Deadline',
                                'refund_cancel'   => 'Refund — Cancel',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-mono text-[11px] font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-lg inline-block border border-gray-200 dark:border-gray-700">
                                    #{{ substr($escrow->order_id, 0, 8) }}
                                </div>
                                @if($escrow->order?->service)
                                    <div class="text-[11px] text-gray-700 dark:text-gray-300 font-bold mt-2 truncate max-w-[180px]">
                                        {{ Str::limit($escrow->order->service->title, 30) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1 text-[11px] font-bold">
                                    <span class="text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-0.5 rounded border border-indigo-100 dark:border-indigo-800/30 w-fit truncate max-w-[140px]">{{ $escrow->order?->client?->name ?? '-' }}</span>
                                    <span class="text-gray-400 dark:text-gray-500 pl-1">↓</span>
                                    <span class="text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded border border-emerald-100 dark:border-emerald-800/30 w-fit truncate max-w-[140px]">{{ $escrow->order?->freelancer?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-gray-900 dark:text-white whitespace-nowrap text-sm">
                                Rp {{ number_format($escrow->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-red-500 dark:text-red-400 font-bold whitespace-nowrap text-[11px]">
                                <span class="bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-md border border-red-100 dark:border-red-800/30">
                                    Rp {{ number_format($escrow->platform_fee, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-green-600 dark:text-green-400 font-bold whitespace-nowrap text-[11px]">
                                <span class="bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-md border border-green-100 dark:border-green-800/30">
                                    Rp {{ number_format($escrow->freelancer_amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border {{ $statusColors[$escrow->status] ?? 'bg-gray-50 text-gray-600 border-gray-200' }}">
                                    @if($escrow->status === 'held') <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5 self-center"></span> @endif
                                    @if($escrow->status === 'released') <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 self-center"></span> @endif
                                    @if($escrow->status === 'refunded') <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 self-center"></span> @endif
                                    {{ ucfirst($escrow->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[11px] font-medium text-gray-500 dark:text-gray-400">
                                {{ $releaseLabels[$escrow->release_type] ?? ($escrow->release_type ?? '—') }}
                            </td>
                            <td class="px-6 py-4 text-[11px] font-medium whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @if($escrow->held_at)
                                        <div class="text-yellow-600 dark:text-yellow-500 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-0.5 rounded border border-yellow-100 dark:border-yellow-800/30 w-fit">H: {{ $escrow->held_at->format('d M y, H:i') }}</div>
                                    @endif
                                    @if($escrow->released_at)
                                        <div class="text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded border border-green-100 dark:border-green-800/30 w-fit mt-1">R: {{ $escrow->released_at->format('d M y, H:i') }}</div>
                                    @endif
                                    @if($escrow->refunded_at)
                                        <div class="text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-2 py-0.5 rounded border border-red-100 dark:border-red-800/30 w-fit mt-1">Ref: {{ $escrow->refunded_at->format('d M y, H:i') }}</div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($recentEscrows->hasPages())
            <div class="p-6 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/10">
                {{ $recentEscrows->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
