@extends('layouts.admin')
@section('title', 'Ledger Transaksi - Admin SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Ledger Transaksi Wallet</h1>
        <p class="text-sm text-gray-500 mt-1">Catatan immutable semua perubahan saldo wallet di seluruh platform.</p>
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Kredit (Masuk)</p>
            <p class="text-2xl font-extrabold text-green-600">+ Rp {{ number_format($totalCredits, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Escrow release + Refund</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Debit (Keluar)</p>
            <p class="text-2xl font-extrabold text-red-500">- Rp {{ number_format($totalDebits, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Withdrawal completed</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Net Saldo Platform</p>
            <p class="text-2xl font-extrabold text-indigo-600">
                Rp {{ number_format($totalCredits - $totalDebits, 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-400 mt-1">Kredit - Debit</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.transactions.index') }}"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-5 flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Tipe</label>
            <select name="type" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua</option>
                <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Credit (Masuk)</option>
                <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>Debit (Keluar)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Kategori</label>
            <select name="category" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua</option>
                <option value="escrow_release" {{ request('category') === 'escrow_release' ? 'selected' : '' }}>Escrow Release</option>
                <option value="refund" {{ request('category') === 'refund' ? 'selected' : '' }}>Refund</option>
                <option value="withdrawal" {{ request('category') === 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                <option value="withdrawal_reversal" {{ request('category') === 'withdrawal_reversal' ? 'selected' : '' }}>Withdrawal Reversal</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">User ID</label>
            <input type="number" name="user_id" value="{{ request('user_id') }}"
                placeholder="ID user..."
                class="w-32 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-colors">
            Filter
        </button>
        @if(request()->hasAny(['type', 'category', 'user_id']))
            <a href="{{ route('admin.transactions.index') }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">
                Reset
            </a>
        @endif
    </form>

    {{-- Ledger Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">
                {{ $transactions->total() }} entri
                @if(request()->hasAny(['type', 'category', 'user_id']))
                    <span class="text-sm text-indigo-500 font-normal">(difilter)</span>
                @endif
            </h3>
            <span class="text-xs text-gray-400">Ledger bersifat immutable — tidak dapat diubah</span>
        </div>

        @if($transactions->isEmpty())
            <div class="p-16 text-center text-gray-400">
                <p class="font-medium">Tidak ada transaksi sesuai filter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-5 py-4">#</th>
                            <th class="px-5 py-4">User</th>
                            <th class="px-5 py-4">Keterangan</th>
                            <th class="px-5 py-4 text-center">Tipe</th>
                            <th class="px-5 py-4 text-center">Kategori</th>
                            <th class="px-5 py-4 text-right">Jumlah</th>
                            <th class="px-5 py-4 text-right">Saldo Sebelum</th>
                            <th class="px-5 py-4 text-right">Saldo Sesudah</th>
                            <th class="px-5 py-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($transactions as $tx)
                        @php
                            $categoryColors = [
                                'escrow_release'      => 'bg-green-50 text-green-700',
                                'refund'              => 'bg-teal-50 text-teal-700',
                                'withdrawal'          => 'bg-orange-50 text-orange-700',
                                'withdrawal_reversal' => 'bg-purple-50 text-purple-700',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3 text-gray-400 text-xs font-mono">
                                {{ $tx->id }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-semibold text-gray-900 text-xs">{{ $tx->user?->name ?? '—' }}</div>
                                <div class="text-gray-400 text-[10px] capitalize">{{ $tx->user?->role }}</div>
                            </td>
                            <td class="px-5 py-3 max-w-xs">
                                <div class="text-xs text-gray-700 truncate">{{ $tx->description }}</div>
                                @if($tx->order_id)
                                    <div class="text-[10px] text-gray-400 font-mono mt-0.5">
                                        Order #{{ substr($tx->order_id, 0, 8) }}
                                    </div>
                                @endif
                                @if($tx->withdrawal_id)
                                    <div class="text-[10px] text-orange-400 mt-0.5">
                                        Withdrawal #{{ $tx->withdrawal_id }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold
                                    {{ $tx->type === 'credit' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600' }}">
                                    {{ strtoupper($tx->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $categoryColors[$tx->category] ?? 'bg-gray-50 text-gray-600' }}">
                                    {{ $tx->category_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right font-extrabold whitespace-nowrap
                                {{ $tx->type === 'credit' ? 'text-green-600' : 'text-red-500' }}">
                                {{ $tx->type === 'credit' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-right text-xs text-gray-500 whitespace-nowrap">
                                Rp {{ number_format($tx->balance_before, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-right text-xs font-semibold text-gray-700 whitespace-nowrap">
                                Rp {{ number_format($tx->balance_after, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-400 whitespace-nowrap">
                                {{ $tx->created_at->format('d M Y H:i') }}
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
