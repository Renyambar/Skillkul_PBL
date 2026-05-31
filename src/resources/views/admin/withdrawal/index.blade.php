@extends('layouts.admin')
@section('title', 'Manajemen Withdrawal - Admin SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Manajemen Withdrawal</h1>
        <p class="text-sm text-gray-500 mt-1">Review dan proses request penarikan saldo dari pengguna.</p>
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

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Pending', 'count' => $counts['pending'], 'color' => 'yellow', 'route' => '?status=pending'],
            ['label' => 'Disetujui', 'count' => $counts['approved'], 'color' => 'blue', 'route' => '?status=approved'],
            ['label' => 'Selesai', 'count' => $counts['completed'], 'color' => 'green', 'route' => '?status=completed'],
            ['label' => 'Ditolak', 'count' => $counts['rejected'], 'color' => 'red', 'route' => '?status=rejected'],
        ] as $card)
        <a href="{{ $card['route'] }}"
           class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ $card['label'] }}</p>
            <p class="text-3xl font-extrabold
                {{ $card['color'] === 'yellow' ? 'text-yellow-600' :
                   ($card['color'] === 'blue' ? 'text-blue-600' :
                   ($card['color'] === 'green' ? 'text-green-600' : 'text-red-600')) }}">
                {{ $card['count'] }}
            </p>
        </a>
        @endforeach
    </div>

    {{-- Filter Tabs --}}
    <div class="flex gap-2 mb-4 border-b border-gray-200 pb-2">
        @foreach(['pending' => 'Pending', 'approved' => 'Disetujui', 'completed' => 'Selesai', 'rejected' => 'Ditolak', 'all' => 'Semua'] as $key => $label)
            <a href="?status={{ $key }}"
               class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors
                   {{ $status === $key ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Tabel Withdrawal --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($withdrawals->isEmpty())
            <div class="p-16 text-center text-gray-400">
                <p class="font-medium">Tidak ada request withdrawal dengan status ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-5 py-4">Pemohon</th>
                            <th class="px-5 py-4">Bank</th>
                            <th class="px-5 py-4 text-right">Nominal</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4">Tanggal</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($withdrawals as $w)
                        <tr class="hover:bg-gray-50/50 transition-colors" id="withdrawal-{{ $w->id }}">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-gray-900">{{ $w->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $w->user->email }}</div>
                                <div class="text-xs text-indigo-500 font-medium capitalize mt-0.5">{{ $w->user->role }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-gray-900">{{ $w->bank_name }}</div>
                                <div class="text-xs text-gray-500">{{ $w->account_number }}</div>
                                <div class="text-xs text-gray-400">a/n {{ $w->account_holder }}</div>
                            </td>
                            <td class="px-5 py-4 text-right font-extrabold text-gray-900 whitespace-nowrap">
                                Rp {{ number_format($w->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $badgeColors = [
                                        'pending'   => 'bg-yellow-50 text-yellow-700',
                                        'approved'  => 'bg-blue-50 text-blue-700',
                                        'rejected'  => 'bg-red-50 text-red-700',
                                        'completed' => 'bg-green-50 text-green-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeColors[$w->status] ?? 'bg-gray-50 text-gray-600' }}">
                                    {{ $w->status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-xs text-gray-500">
                                {{ $w->requested_at?->format('d M Y') ?? $w->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Approve (pending only) --}}
                                    @if($w->status === 'pending')
                                        <form action="{{ route('admin.withdrawal.approve', $w->id) }}" method="POST"
                                              onsubmit="return confirm('Setujui withdrawal Rp {{ number_format($w->amount, 0, ',', '.') }} dari {{ $w->user->name }}?')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors">
                                                Setujui
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Complete (approved only) --}}
                                    @if($w->status === 'approved')
                                        <form action="{{ route('admin.withdrawal.complete', $w->id) }}" method="POST"
                                              onsubmit="return confirm('Konfirmasi transfer Rp {{ number_format($w->amount, 0, ',', '.') }} sudah dikirim ke {{ $w->bank_name }} {{ $w->account_number }}?')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-colors">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Reject (pending atau approved) --}}
                                    @if(in_array($w->status, ['pending', 'approved']))
                                        <button type="button"
                                            onclick="document.getElementById('reject-modal-{{ $w->id }}').classList.remove('hidden')"
                                            class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-lg transition-colors border border-red-200">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Reject Modal (inline per row) --}}
                        @if(in_array($w->status, ['pending', 'approved']))
                        <tr id="reject-modal-{{ $w->id }}" class="hidden">
                            <td colspan="6" class="px-5 py-4 bg-red-50">
                                <form action="{{ route('admin.withdrawal.reject', $w->id) }}" method="POST" class="flex gap-3 items-end">
                                    @csrf
                                    <div class="flex-1">
                                        <label class="block text-xs font-bold text-red-700 mb-1">Alasan Penolakan (wajib, min. 10 karakter)</label>
                                        <input type="text" name="admin_note" minlength="10" required
                                            placeholder="Contoh: Data rekening tidak sesuai, harap cek kembali nomor rekening."
                                            class="w-full px-3 py-2 border border-red-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500">
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg">
                                        Konfirmasi Tolak
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('reject-modal-{{ $w->id }}').classList.add('hidden')"
                                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded-lg">
                                        Batal
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endif
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
