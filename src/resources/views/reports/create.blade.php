@extends('layouts.client')
@section('title', 'Laporkan Freelancer - SkillKul')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ $order ? route('pesanan.detail', $order->id) : route('pesanan.klien') }}"
           class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-800 mb-4 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900">Laporkan Freelancer</h1>
        <p class="text-gray-500 text-sm mt-1">Laporan Anda akan ditinjau oleh admin SkillKul dalam 1x24 jam.</p>
    </div>

    {{-- Flash Error --}}
    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 text-sm font-semibold rounded-xl px-5 py-4">
        ⚠ {{ session('error') }}
    </div>
    @endif

    {{-- Context Order (jika dari halaman pesanan) --}}
    @if($order)
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5 mb-6">
        <p class="text-xs font-extrabold text-indigo-500 uppercase tracking-wider mb-2">Konteks Pesanan</p>
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-extrabold text-base flex items-center justify-center shrink-0">
                {{ strtoupper(substr($order->freelancer?->name ?? '?', 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-gray-900">{{ $order->freelancer?->name }}</p>
                <p class="text-sm text-gray-500">{{ $order->service?->title }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Order #{{ substr($order->id, 0, 8) }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Hidden: reported_id & order_id --}}
            @if($order)
                <input type="hidden" name="reported_id" value="{{ $order->freelancer_id }}">
                <input type="hidden" name="order_id" value="{{ $order->id }}">
            @else
                <div>
                    <label for="reported_id" class="block text-sm font-bold text-gray-700 mb-2">
                        ID Freelancer yang Dilaporkan <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="reported_id" name="reported_id" value="{{ old('reported_id') }}"
                           placeholder="Masukkan ID user freelancer"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 @error('reported_id') border-red-400 @enderror">
                    @error('reported_id')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Kategori Laporan <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @php
                        $categories = [
                            'penipuan'              => ['label' => '🚨 Penipuan', 'desc' => 'Tidak mengerjakan meski sudah dibayar'],
                            'tidak_selesai'         => ['label' => '⏰ Tidak Selesai', 'desc' => 'Pekerjaan tidak diselesaikan sesuai perjanjian'],
                            'kualitas_buruk'        => ['label' => '😞 Kualitas Buruk', 'desc' => 'Hasil tidak sesuai deskripsi jasa'],
                            'perilaku_tidak_pantas' => ['label' => '⚠️ Perilaku Tidak Pantas', 'desc' => 'Komunikasi kasar atau tidak profesional'],
                            'lainnya'               => ['label' => '📋 Lainnya', 'desc' => 'Alasan lain yang tidak tercantum'],
                        ];
                    @endphp
                    @foreach($categories as $val => $cat)
                    <label class="flex items-start gap-3 cursor-pointer border border-gray-200 hover:border-red-300 rounded-xl p-3.5 transition-colors has-[:checked]:border-red-400 has-[:checked]:bg-red-50">
                        <input type="radio" name="category" value="{{ $val }}"
                               class="mt-0.5 accent-red-500" {{ old('category') === $val ? 'checked' : '' }}>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $cat['label'] }}</p>
                            <p class="text-xs text-gray-500">{{ $cat['desc'] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('category')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                    Deskripsi Kejadian <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="5" required
                          placeholder="Ceritakan secara detail apa yang terjadi, termasuk tanggal, kronologi, dan kerugian yang Anda alami..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                <p class="text-xs text-gray-400 mt-1.5">Minimal 30 karakter. Semakin detail, semakin cepat admin bisa menindaklanjuti.</p>
                @error('description')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- File Bukti --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Bukti Pendukung (Opsional)</label>
                <div class="border-2 border-dashed border-gray-200 hover:border-red-300 rounded-xl p-6 text-center transition-colors">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf" id="attachment-input"
                           class="hidden" onchange="document.getElementById('file-name').textContent = this.files[0]?.name ?? 'Belum ada file'">
                    <label for="attachment-input" class="cursor-pointer text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                        Klik untuk unggah file
                    </label>
                    <p id="file-name" class="text-xs text-gray-400 mt-1">Belum ada file dipilih</p>
                    <p class="text-xs text-gray-400 mt-0.5">Format: JPG, PNG, PDF. Maksimal 5MB.</p>
                </div>
                @error('attachment')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info --}}
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                <p class="text-xs font-bold text-amber-800 mb-1">⚖️ Kebijakan Laporan</p>
                <p class="text-xs text-amber-700 leading-relaxed">
                    Laporan palsu atau tidak berdasar dapat mengakibatkan penonaktifan akun Anda.
                    Pastikan laporan yang Anda buat akurat dan dapat dibuktikan.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-6 py-3 rounded-xl transition-all shadow">
                    Kirim Laporan
                </button>
                <a href="{{ $order ? route('pesanan.detail', $order->id) : route('pesanan.klien') }}"
                   class="text-sm font-semibold text-gray-500 hover:text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-100 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
