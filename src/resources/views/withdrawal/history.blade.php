@extends('layouts.' . (auth()->user()->role === 'freelancer' ? 'freelancer' : 'client'))
@section('title', 'Riwayat Penarikan - SkillKul')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Riwayat Penarikan</h1>
            <p class="text-sm text-gray-500 mt-1">Semua request penarikan saldo Anda.</p>
        </div>
        <a href="{{ route('withdrawal.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
            + Penarikan Baru
        </a>
    </div>

    {{-- Saldo --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 mb-6 flex items-center justify-between">
        <p class="text-sm text-indigo-600 font-medium">Saldo tersedia</p>
        <p class="text-xl font-extrabold text-indigo-700">Rp {{ number_format($balance, 0, ',', '.') }}</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($withdrawals->isEmpty())
            <div class="p-16 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h4 class="text-base font-bold text-gray-900 mb-1">Belum ada penarikan</h4>
                <p class="text-sm text-gray-500">Riwayat penarikan saldo akan muncul di sini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Bank</th>
                            <th class="px-6 py-4">A/N</th>
                            <th class="px-6 py-4 text-right">Nominal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($withdrawals as $w)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">
                                {{ $w->requested_at?->format('d M Y') ?? $w->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $w->bank_name }}
                                <div class="text-xs text-gray-400 font-normal">{{ $w->account_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $w->account_holder }}</td>
                            <td class="px-6 py-4 text-right font-extrabold text-gray-900 whitespace-nowrap">
                                Rp {{ number_format($w->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $colors = [
                                        'pending'   => 'bg-yellow-50 text-yellow-700',
                                        'approved'  => 'bg-blue-50 text-blue-700',
                                        'rejected'  => 'bg-red-50 text-red-700',
                                        'completed' => 'bg-green-50 text-green-700',
                                    ];
                                    $color = $colors[$w->status] ?? 'bg-gray-50 text-gray-600';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $color }}">
                                    {{ $w->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 max-w-xs">
                                {{ $w->admin_note ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($withdrawals->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $withdrawals->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
