@extends('layouts.admin')
@section('title', 'Escrow Dasbor - Admin SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Escrow Dasbor</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau dana yang sedang ditahan dan telah diproses platform.</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Total Held --}}
        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-wider text-indigo-200">Dana Ditahan</p>
                <span class="bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg">{{ $summary['held']['count'] }} order</span>
            </div>
            <p class="text-2xl font-extrabold">Rp {{ number_format($summary['held']['total'], 0, ',', '.') }}</p>
            <p class="text-indigo-200 text-xs mt-1">Belum release / refund</p>
        </div>

        {{-- Total Platform Fee --}}
        <div class="bg-gradient-to-br from-emerald-600 to-teal-600 rounded-2xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-200">Pendapatan Platform</p>
                <span class="bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg">{{ config('skillkul.platform_fee_percent', 8) }}% fee</span>
            </div>
            <p class="text-2xl font-extrabold">Rp {{ number_format($totalPlatformFee, 0, ',', '.') }}</p>
            <p class="text-emerald-200 text-xs mt-1">Total fee dari escrow released</p>
        </div>

        {{-- Released --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Dilepas ke Pekerja Lepas</p>
                <span class="bg-green-50 text-green-700 text-xs font-bold px-2 py-1 rounded-lg">{{ $summary['released']['count'] }}</span>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($summary['released']['total'], 0, ',', '.') }}</p>
            <p class="text-gray-400 text-xs mt-1">Escrow released</p>
        </div>

        {{-- Refunded --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Direfund ke Klien</p>
                <span class="bg-red-50 text-red-700 text-xs font-bold px-2 py-1 rounded-lg">{{ $summary['refunded']['count'] }}</span>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($summary['refunded']['total'], 0, ',', '.') }}</p>
            <p class="text-gray-400 text-xs mt-1">Deadline miss / cancel</p>
        </div>
    </div>

    {{-- Escrow Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900 text-lg">Semua Record Escrow</h3>
            <a href="{{ route('admin.transactions.index') }}"
               class="text-sm text-indigo-600 font-semibold hover:underline">
                Lihat Ledger Transaksi →
            </a>
        </div>

        @if($recentEscrows->isEmpty())
            <div class="p-16 text-center text-gray-400">
                <p class="font-medium">Belum ada record escrow.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-5 py-4">Order</th>
                            <th class="px-5 py-4">Klien → Pekerja Lepas</th>
                            <th class="px-5 py-4 text-right">Gross</th>
                            <th class="px-5 py-4 text-right">Platform Fee (8%)</th>
                            <th class="px-5 py-4 text-right">Pekerja Lepas (92%)</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4">Tipe Release</th>
                            <th class="px-5 py-4">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentEscrows as $escrow)
                        @php
                            $statusColors = [
                                'held'     => 'bg-yellow-50 text-yellow-700',
                                'released' => 'bg-green-50 text-green-700',
                                'refunded' => 'bg-red-50 text-red-700',
                            ];
                            $releaseLabels = [
                                'manual_accept'   => 'Manual Accept',
                                'auto_complete'   => 'Auto Complete (48 jam)',
                                'refund_deadline' => 'Refund — Deadline',
                                'refund_cancel'   => 'Refund — Cancel',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-mono text-xs text-gray-500">
                                    #{{ substr($escrow->order_id, 0, 8) }}...
                                </div>
                                @if($escrow->order?->service)
                                    <div class="text-xs text-gray-700 font-medium mt-0.5">
                                        {{ Str::limit($escrow->order->service->title, 30) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs">
                                <div class="text-gray-700">{{ $escrow->order?->client?->name ?? '-' }}</div>
                                <div class="text-gray-400">→ {{ $escrow->order?->freelancer?->name ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4 text-right font-semibold text-gray-900 whitespace-nowrap text-xs">
                                Rp {{ number_format($escrow->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-right text-red-500 font-semibold whitespace-nowrap text-xs">
                                Rp {{ number_format($escrow->platform_fee, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-right text-green-600 font-semibold whitespace-nowrap text-xs">
                                Rp {{ number_format($escrow->freelancer_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$escrow->status] ?? 'bg-gray-50 text-gray-600' }}">
                                    {{ ucfirst($escrow->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-xs text-gray-500">
                                {{ $releaseLabels[$escrow->release_type] ?? ($escrow->release_type ?? '—') }}
                            </td>
                            <td class="px-5 py-4 text-xs text-gray-400 whitespace-nowrap">
                                @if($escrow->held_at)
                                    <div>Hold: {{ $escrow->held_at->format('d M Y') }}</div>
                                @endif
                                @if($escrow->released_at)
                                    <div class="text-green-600">Release: {{ $escrow->released_at->format('d M Y') }}</div>
                                @endif
                                @if($escrow->refunded_at)
                                    <div class="text-red-500">Refund: {{ $escrow->refunded_at->format('d M Y') }}</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($recentEscrows->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $recentEscrows->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
