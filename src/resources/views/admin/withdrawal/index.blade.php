@extends('layouts.admin')
@section('title', 'Manajemen Withdrawal - Admin SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 transition-colors duration-300">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Manajemen Withdrawal</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium">Review dan proses request penarikan saldo dari pengguna.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-300 px-5 py-4 rounded-2xl text-sm font-semibold shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-800 dark:text-red-300 px-5 py-4 rounded-2xl text-sm font-semibold shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        @foreach([
            ['label' => 'Pending', 'count' => $counts['pending'], 'color' => 'yellow', 'route' => '?status=pending'],
            ['label' => 'Disetujui', 'count' => $counts['approved'], 'color' => 'blue', 'route' => '?status=approved'],
            ['label' => 'Selesai', 'count' => $counts['completed'], 'color' => 'green', 'route' => '?status=completed'],
            ['label' => 'Ditolak', 'count' => $counts['rejected'], 'color' => 'red', 'route' => '?status=rejected'],
        ] as $card)
        <a href="{{ $card['route'] }}"
           class="bg-white dark:bg-brand-darksurface rounded-3xl border border-{{ $card['color'] }}-100 dark:border-{{ $card['color'] }}-900/50 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-{{ $card['color'] }}-500/5 rounded-full blur-xl group-hover:scale-110 transition-transform"></div>
            <p class="text-[11px] font-extrabold text-{{ $card['color'] }}-500 dark:text-{{ $card['color'] }}-400 uppercase tracking-widest mb-2 relative z-10">{{ $card['label'] }}</p>
            <p class="text-4xl font-black text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400 relative z-10">
                {{ $card['count'] }}
            </p>
        </a>
        @endforeach
    </div>

    {{-- Filter Tabs --}}
    <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 dark:border-gray-800 pb-4">
        @foreach(['pending' => 'Pending', 'approved' => 'Disetujui', 'completed' => 'Selesai', 'rejected' => 'Ditolak', 'all' => 'Semua'] as $key => $label)
            <a href="?status={{ $key }}"
               class="px-5 py-2.5 text-sm font-bold rounded-xl transition-all
                   {{ $status === $key ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-200 dark:shadow-none' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Tabel Withdrawal --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden">
        @if($withdrawals->isEmpty())
            <div class="p-20 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="font-bold text-gray-600 dark:text-gray-400">Tidak ada request withdrawal.</p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 font-medium">Belum ada data untuk status ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                            <th class="px-6 py-5 whitespace-nowrap">Pemohon</th>
                            <th class="px-6 py-5 whitespace-nowrap">Bank</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Nominal</th>
                            <th class="px-6 py-5 text-center whitespace-nowrap">Status</th>
                            <th class="px-6 py-5 whitespace-nowrap">Tanggal</th>
                            <th class="px-6 py-5 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($withdrawals as $w)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors" id="withdrawal-{{ $w->id }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black text-[10px] border border-indigo-100 dark:border-indigo-800/50">
                                        {{ strtoupper(substr($w->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 dark:text-white text-xs">{{ $w->user->name }}</div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">{{ $w->user->email }}</div>
                                        <div class="text-[10px] text-indigo-500 dark:text-indigo-400 font-extrabold uppercase tracking-wider mt-1">{{ $w->user->role }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-900 dark:text-white text-xs">{{ $w->bank_name }}</div>
                                <div class="text-[11px] font-mono text-gray-500 dark:text-gray-400 mt-0.5"><span class="bg-gray-50 dark:bg-gray-800 px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-700">{{ $w->account_number }}</span></div>
                                <div class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-1 uppercase tracking-wider">a/n {{ $w->account_holder }}</div>
                            </td>
                            <td class="px-6 py-5 text-right font-black text-gray-900 dark:text-white whitespace-nowrap text-sm">
                                Rp {{ number_format($w->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $badgeColors = [
                                        'pending'   => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 border border-yellow-100 dark:border-yellow-800/50',
                                        'approved'  => 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50',
                                        'rejected'  => 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border border-red-100 dark:border-red-800/50',
                                        'completed' => 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800/50',
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider {{ $badgeColors[$w->status] ?? 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700' }}">
                                    @if($w->status === 'pending') <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5 self-center"></span> @endif
                                    @if($w->status === 'approved') <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 self-center"></span> @endif
                                    @if($w->status === 'completed') <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 self-center"></span> @endif
                                    @if($w->status === 'rejected') <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 self-center"></span> @endif
                                    {{ $w->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-[11px] font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $w->requested_at?->format('d M Y') ?? $w->created_at->format('d M Y') }}<br>
                                <span class="text-gray-400 dark:text-gray-500">{{ $w->requested_at?->format('H:i') ?? $w->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    {{-- Approve (pending only) --}}
                                    @if($w->status === 'pending')
                                        <form action="{{ route('admin.withdrawal.approve', $w->id) }}" method="POST"
                                              onsubmit="return confirm('Setujui withdrawal Rp {{ number_format($w->amount, 0, ',', '.') }} dari {{ $w->user->name }}?')">
                                            @csrf
                                            <button type="submit"
                                                class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-bold rounded-xl transition-colors shadow-sm shadow-blue-200 dark:shadow-none whitespace-nowrap">
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
                                                class="w-full sm:w-auto px-4 py-2 bg-green-600 hover:bg-green-500 text-white text-[11px] font-bold rounded-xl transition-colors shadow-sm shadow-green-200 dark:shadow-none whitespace-nowrap">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Reject (pending atau approved) --}}
                                    @if(in_array($w->status, ['pending', 'approved']))
                                        <button type="button"
                                            onclick="document.getElementById('reject-modal-{{ $w->id }}').classList.remove('hidden')"
                                            class="w-full sm:w-auto px-4 py-2 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-700 dark:text-red-400 text-[11px] font-bold rounded-xl transition-colors border border-red-200 dark:border-red-800/50 whitespace-nowrap">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Reject Modal (inline per row) --}}
                        @if(in_array($w->status, ['pending', 'approved']))
                        <tr id="reject-modal-{{ $w->id }}" class="hidden">
                            <td colspan="6" class="px-6 py-5 bg-red-50/50 dark:bg-red-900/10 border-t border-b border-red-100 dark:border-red-900/30">
                                <form action="{{ route('admin.withdrawal.reject', $w->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end max-w-4xl mx-auto bg-white dark:bg-brand-darksurface p-4 rounded-2xl shadow-sm border border-red-100 dark:border-red-900/30">
                                    @csrf
                                    <div class="flex-1 w-full">
                                        <label class="block text-[10px] font-extrabold text-red-700 dark:text-red-400 mb-2 uppercase tracking-widest">Alasan Penolakan (wajib, min. 10 karakter)</label>
                                        <input type="text" name="admin_note" minlength="10" required
                                            placeholder="Contoh: Data rekening tidak sesuai, harap cek kembali nomor rekening."
                                            class="w-full px-4 py-2.5 border border-red-200 dark:border-red-900/50 rounded-xl text-sm focus:ring-2 focus:ring-red-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 outline-none transition-colors">
                                    </div>
                                    <div class="flex gap-2 w-full sm:w-auto">
                                        <button type="submit" class="flex-1 sm:flex-none px-5 py-2.5 bg-red-600 hover:bg-red-500 text-white text-[11px] font-bold rounded-xl transition-colors shadow-sm shadow-red-200 dark:shadow-none whitespace-nowrap">
                                            Konfirmasi Tolak
                                        </button>
                                        <button type="button"
                                            onclick="document.getElementById('reject-modal-{{ $w->id }}').classList.add('hidden')"
                                            class="flex-1 sm:flex-none px-5 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 text-[11px] font-bold rounded-xl transition-colors whitespace-nowrap">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($withdrawals->hasPages())
            <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/10">
                {{ $withdrawals->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
