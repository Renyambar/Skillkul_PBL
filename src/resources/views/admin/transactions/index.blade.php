@extends('layouts.admin')
@section('title', 'Ledger Transaksi - Admin SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 transition-colors duration-300">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Ledger Transaksi Wallet</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium">Catatan immutable semua perubahan saldo wallet di seluruh platform.</p>
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-green-100 dark:border-green-900/50 p-6 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold text-green-600 dark:text-green-500 uppercase tracking-widest mb-2 relative z-10">Total Kredit (Masuk)</p>
            <p class="text-3xl font-black text-green-600 dark:text-green-400 relative z-10">+ Rp {{ number_format($totalCredits, 0, ',', '.') }}</p>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2 font-medium relative z-10">Escrow release + Refund</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-red-100 dark:border-red-900/50 p-6 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold text-red-500 dark:text-red-400 uppercase tracking-widest mb-2 relative z-10">Total Debit (Keluar)</p>
            <p class="text-3xl font-black text-red-500 dark:text-red-400 relative z-10">- Rp {{ number_format($totalDebits, 0, ',', '.') }}</p>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2 font-medium relative z-10">Withdrawal completed</p>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-indigo-100 dark:border-indigo-900/50 p-6 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/5 rounded-full blur-xl"></div>
            <p class="text-[11px] font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-2 relative z-10">Net Saldo Platform</p>
            <p class="text-3xl font-black text-indigo-600 dark:text-indigo-400 relative z-10">
                Rp {{ number_format($totalCredits - $totalDebits, 0, ',', '.') }}
            </p>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2 font-medium relative z-10">Kredit - Debit</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.transactions.index') }}"
          class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 mb-8 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-[10px] font-extrabold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Tipe</label>
            <select name="type" class="w-full sm:w-auto px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 appearance-none font-medium transition-colors">
                <option value="">Semua</option>
                <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Credit (Masuk)</option>
                <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>Debit (Keluar)</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-extrabold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Kategori</label>
            <select name="category" class="w-full sm:w-auto px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 appearance-none font-medium transition-colors">
                <option value="">Semua</option>
                <option value="escrow_release" {{ request('category') === 'escrow_release' ? 'selected' : '' }}>Escrow Release</option>
                <option value="refund" {{ request('category') === 'refund' ? 'selected' : '' }}>Refund</option>
                <option value="withdrawal" {{ request('category') === 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                <option value="withdrawal_reversal" {{ request('category') === 'withdrawal_reversal' ? 'selected' : '' }}>Withdrawal Reversal</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-extrabold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">User ID</label>
            <input type="number" name="user_id" value="{{ request('user_id') }}"
                placeholder="ID user..."
                class="w-full sm:w-32 px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 outline-none transition-colors">
        </div>
        <div class="flex gap-3 mt-2 sm:mt-0 w-full sm:w-auto">
            <button type="submit"
                class="flex-1 sm:flex-none px-6 py-2.5 bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition-colors shadow-sm shadow-indigo-200 dark:shadow-none text-center">
                Filter
            </button>
            @if(request()->hasAny(['type', 'category', 'user_id']))
                <a href="{{ route('admin.transactions.index') }}"
                   class="flex-1 sm:flex-none px-5 py-2.5 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-sm font-bold rounded-xl transition-colors text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Ledger Table --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h3 class="font-black text-gray-900 dark:text-white">
                {{ $transactions->total() }} entri
                @if(request()->hasAny(['type', 'category', 'user_id']))
                    <span class="text-sm text-indigo-500 dark:text-indigo-400 font-medium ml-1">(difilter)</span>
                @endif
            </h3>
            <span class="text-[11px] text-gray-500 dark:text-gray-400 font-mono bg-gray-50 dark:bg-gray-800 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700">Ledger bersifat immutable — tidak dapat diubah</span>
        </div>

        @if($transactions->isEmpty())
            <div class="p-20 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="font-bold text-gray-600 dark:text-gray-400">Tidak ada transaksi sesuai filter.</p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 font-medium">Coba ubah filter pencarian Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                            <th class="px-6 py-5 whitespace-nowrap">#</th>
                            <th class="px-6 py-5 whitespace-nowrap">User</th>
                            <th class="px-6 py-5 whitespace-nowrap">Keterangan</th>
                            <th class="px-6 py-5 text-center whitespace-nowrap">Tipe</th>
                            <th class="px-6 py-5 text-center whitespace-nowrap">Kategori</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Jumlah</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Saldo Sebelum</th>
                            <th class="px-6 py-5 text-right whitespace-nowrap">Saldo Sesudah</th>
                            <th class="px-6 py-5 whitespace-nowrap">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($transactions as $tx)
                        @php
                            $categoryColors = [
                                'escrow_release'      => 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800/50',
                                'refund'              => 'bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 border border-teal-100 dark:border-teal-800/50',
                                'withdrawal'          => 'bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 border border-orange-100 dark:border-orange-800/50',
                                'withdrawal_reversal' => 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 border border-purple-100 dark:border-purple-800/50',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-[11px] font-mono font-bold">
                                <span class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-lg border border-gray-200 dark:border-gray-700">{{ $tx->id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 dark:text-white text-xs">{{ $tx->user?->name ?? '—' }}</div>
                                <div class="text-gray-500 dark:text-gray-400 text-[10px] font-medium capitalize mt-0.5">{{ $tx->user?->role }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-[200px]">
                                <div class="text-xs text-gray-700 dark:text-gray-300 font-medium truncate" title="{{ $tx->description }}">{{ $tx->description }}</div>
                                @if($tx->order_id)
                                    <div class="text-[10px] text-gray-500 dark:text-gray-400 font-mono mt-1.5">
                                        <span class="bg-gray-50 dark:bg-gray-800 px-1.5 py-0.5 rounded border border-gray-100 dark:border-gray-700 font-bold">Ord #{{ substr($tx->order_id, 0, 8) }}</span>
                                    </div>
                                @endif
                                @if($tx->withdrawal_id)
                                    <div class="text-[10px] text-orange-500 dark:text-orange-400 font-mono mt-1.5">
                                        <span class="bg-orange-50 dark:bg-orange-900/20 px-1.5 py-0.5 rounded border border-orange-100 dark:border-orange-800/50 font-bold">W/D #{{ $tx->withdrawal_id }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-extrabold border
                                    {{ $tx->type === 'credit' ? 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-100 dark:border-green-800/50' : 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border-red-100 dark:border-red-800/50' }}">
                                    @if($tx->type === 'credit') <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> @endif
                                    @if($tx->type === 'debit') <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> @endif
                                    {{ strtoupper($tx->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider {{ $categoryColors[$tx->category] ?? 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700' }}">
                                    {{ $tx->category_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-[13px] whitespace-nowrap
                                {{ $tx->type === 'credit' ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                                {{ $tx->type === 'credit' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-[11px] font-mono text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                Rp {{ number_format($tx->balance_before, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-[11px] font-mono font-bold text-gray-800 dark:text-gray-200 whitespace-nowrap bg-gray-50/50 dark:bg-gray-800/20">
                                Rp {{ number_format($tx->balance_after, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-[11px] font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $tx->created_at->format('d M Y') }}<br>
                                <span class="text-gray-400 dark:text-gray-500">{{ $tx->created_at->format('H:i') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
            <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/10">
                {{ $transactions->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
