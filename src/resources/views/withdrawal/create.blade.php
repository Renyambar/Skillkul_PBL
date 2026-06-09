@extends('layouts.' . (auth()->user()->role === 'freelancer' ? 'freelancer' : 'client'))
@section('title', 'Cairkan Saldo - SkillKul')
@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Cairkan Saldo</h1>
        <p class="text-sm text-gray-500 mt-1">Transfer saldo dompet ke rekening bank Anda.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    {{-- Saldo Saat Ini --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5 mb-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-indigo-400 uppercase tracking-wider mb-1">Saldo Tersedia</p>
            <p class="text-2xl font-extrabold text-indigo-700">Rp{{ number_format($balance, 0, ',', '.') }}</p>
        </div>
        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </div>
    </div>

    {{-- Ada Pending Withdrawal --}}
    @if($pendingWithdrawal)
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="font-bold text-yellow-800 text-sm">Ada Permintaan Aktif</p>
                    <p class="text-yellow-700 text-xs mt-1">
                        Anda memiliki pencairan <strong>Rp{{ number_format($pendingWithdrawal->amount, 0, ',', '.') }}</strong>
                        yang sedang diproses (status: <strong>{{ $pendingWithdrawal->status_label }}</strong>).
                        Harap tunggu hingga selesai sebelum mengajukan yang baru.
                    </p>
                    <a href="{{ route('withdrawal.history') }}"
                       class="inline-block mt-2 text-xs text-yellow-700 font-bold underline">
                        Lihat Riwayat Pencairan Saldo →
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Withdrawal --}}
    @if(!$pendingWithdrawal && $balance >= $minAmount)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-gray-900 text-base mb-5">Detail Rekening Bank Tujuan</h2>

            <form action="{{ route('withdrawal.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="bank_name" class="block text-sm font-semibold text-gray-700 mb-1.5">Bank Tujuan</label>
                    <select id="bank_name" name="bank_name" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('bank_name') border-red-300 @enderror">
                        <option value="">-- Pilih Bank --</option>
                        @foreach(['BCA', 'BNI', 'BRI', 'Mandiri', 'CIMB Niaga', 'BSI', 'Danamon', 'Permata', 'OVO', 'GoPay', 'Dana', 'ShopeePay'] as $bank)
                            <option value="{{ $bank }}" {{ old('bank_name') === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                        @endforeach
                    </select>
                    @error('bank_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="account_number" class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Rekening</label>
                    <input type="text" id="account_number" name="account_number"
                        value="{{ old('account_number') }}"
                        placeholder="Contoh: 1234567890"
                        pattern="\d+" inputmode="numeric"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('account_number') border-red-300 @enderror"
                        required>
                    @error('account_number')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="account_holder" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Pemilik Rekening</label>
                    <input type="text" id="account_holder" name="account_holder"
                        value="{{ old('account_holder') }}"
                        placeholder="Sesuai buku tabungan"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('account_holder') border-red-300 @enderror"
                        required>
                    @error('account_holder')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nominal Pencairan
                        <span class="font-normal text-gray-400">(Min. Rp{{ number_format($minAmount, 0, ',', '.') }})</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                        <input type="number" id="amount" name="amount"
                            value="{{ old('amount') }}"
                            min="{{ $minAmount }}" max="{{ $balance }}" step="1000"
                            placeholder="{{ $minAmount }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('amount') border-red-300 @enderror"
                            required>
                    </div>
                    @error('amount')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <button type="button"
                        onclick="document.getElementById('amount').value = {{ $balance }}"
                        class="mt-1.5 text-xs text-indigo-600 font-semibold hover:underline">
                        Cairkan semua (Rp{{ number_format($balance, 0, ',', '.') }})
                    </button>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 text-xs text-gray-500 space-y-1">
                    <p>• Pencairan saldo diproses manual oleh admin dalam 1-2 hari kerja.</p>
                    <p>• Saldo baru dikurangi setelah transfer selesai dikonfirmasi.</p>
                    <p>• Pastikan data rekening bank sudah benar sebelum submit.</p>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition-colors text-sm">
                    Ajukan Pencairan Saldo
                </button>
            </form>
        </div>
    @elseif(!$pendingWithdrawal && $balance < $minAmount)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h4 class="font-bold text-gray-900 mb-1">Saldo Belum Mencukupi</h4>
            <p class="text-sm text-gray-500">
                Minimal pencairan adalah Rp{{ number_format($minAmount, 0, ',', '.') }}.
                Saldo Anda saat ini: <strong>Rp{{ number_format($balance, 0, ',', '.') }}</strong>.
            </p>
        </div>
    @endif
</div>
@endsection
