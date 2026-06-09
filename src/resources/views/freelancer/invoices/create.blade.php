@extends('layouts.freelancer')
@section('title', 'Buat Tagihan - SkillKul')
@section('content')
<div class="p-8 lg:p-10 transition-colors duration-300">
    {{-- Header --}}
    <div class="mb-8">
        <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-brand-primary dark:text-indigo-400 tracking-widest uppercase mb-3">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            TAGIHAN KHUSUS
        </span>
        <h1 class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight mb-2">Buat Tagihan Khusus</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm max-w-2xl">Setelah mencapai kesepakatan melalui WhatsApp, buat tagihan untuk klien agar mereka dapat membayar melalui sistem pembayaran aman SkillKul.</p>
    </div>

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-400 px-5 py-4 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-12 gap-8">
        {{-- Form --}}
        <div class="lg:col-span-7 bg-white dark:bg-brand-darksurface rounded-2xl shadow-sm p-8 border border-gray-100 dark:border-brand-darkborder transition-colors">
            <form action="{{ route('freelancer.invoice.store') }}" method="POST" class="space-y-6" id="invoiceForm">
                @csrf

                {{-- Email Klien --}}
                <div>
                    <label for="client_email" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Pos-el Klien</label>
                    <input type="email" id="client_email" name="client_email" value="{{ old('client_email') }}"
                        placeholder="contoh@email.com"
                        class="w-full bg-gray-50 dark:bg-gray-800/50 border border-transparent dark:border-gray-700 focus:bg-white dark:focus:bg-brand-darksurface focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-900/50 rounded-xl px-4 py-3.5 text-sm font-medium text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all outline-none @error('client_email') border-red-400 bg-red-50 dark:bg-red-900/10 dark:border-red-800/50 @enderror">
                    @error('client_email')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-2">Pos-el harus terdaftar sebagai pengguna di SkillKul.</p>
                </div>

                {{-- Pilih Jasa --}}
                <div>
                    <label for="service_id" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Pilih Layanan</label>
                    <select id="service_id" name="service_id"
                        class="w-full bg-gray-50 dark:bg-gray-800/50 border border-transparent dark:border-gray-700 focus:bg-white dark:focus:bg-brand-darksurface focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-900/50 rounded-xl px-4 py-3.5 text-sm font-medium text-gray-900 dark:text-gray-300 transition-all outline-none appearance-none custom-select @error('service_id') border-red-400 bg-red-50 dark:bg-red-900/10 dark:border-red-800/50 @enderror">
                        <option value="" class="dark:bg-gray-800">— Pilih layanan yang ingin ditagih —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" data-title="{{ $service->title }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }} class="dark:bg-gray-800">
                                {{ $service->title }}
                                ({{ $service->type === 'project' ? 'Proyek' : 'Non-Proyek' }})
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                    @if($services->isEmpty())
                        <p class="text-xs text-amber-600 dark:text-amber-500 mt-2 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Anda belum memiliki layanan yang aktif. <a href="{{ route('freelancer.jasa.create') }}" class="underline font-bold hover:text-amber-700 dark:hover:text-amber-400">Buat layanan baru</a>
                        </p>
                    @endif
                </div>

                {{-- Harga Kesepakatan --}}
                <div class="bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-800/30 rounded-2xl p-6 transition-colors">
                    <label for="total_price" class="block text-sm font-bold text-gray-900 dark:text-white mb-3">Harga Kesepakatan (IDR)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-green-700 dark:text-green-500">Rp</span>
                        <input type="number" id="total_price" name="total_price" value="{{ old('total_price') }}"
                            placeholder="1000000" min="10000" step="1000"
                            class="w-full bg-white dark:bg-gray-800/50 border border-transparent dark:border-gray-700 rounded-xl pl-12 pr-4 py-3.5 text-base font-bold text-gray-900 dark:text-white shadow-sm focus:border-green-400 dark:focus:border-green-500 focus:ring-2 focus:ring-green-100 dark:focus:ring-green-900/50 outline-none transition-all @error('total_price') border-red-400 dark:border-red-500 @enderror">
                    </div>
                    @error('total_price')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] font-bold text-green-700 dark:text-green-400 mt-3 flex items-center gap-1.5 opacity-80">ℹ️ Harga final yang telah disepakati via WhatsApp. Minimum Rp10.000.</p>
                </div>

                {{-- Catatan --}}
                <div>
                    <label for="order_notes" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Catatan / Deskripsi Pekerjaan</label>
                    <textarea id="order_notes" name="order_notes" rows="4"
                        placeholder="Jelaskan ruang lingkup pekerjaan yang telah disepakati..."
                        class="w-full bg-gray-50 dark:bg-gray-800/50 border border-transparent dark:border-gray-700 focus:bg-white dark:focus:bg-brand-darksurface focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-900/50 rounded-xl px-5 py-4 text-sm font-medium text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition-all outline-none resize-none @error('order_notes') border-red-400 bg-red-50 dark:bg-red-900/10 dark:border-red-800/50 @enderror">{{ old('order_notes') }}</textarea>
                    @error('order_notes')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full bg-brand-primary dark:bg-indigo-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-brand-dark dark:hover:bg-indigo-500 transition-all flex justify-center items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ $services->isEmpty() ? 'disabled' : '' }}>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Buat Tagihan &amp; Kirim ke Klien
                </button>
            </form>
        </div>

        {{-- Right: Preview --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white dark:bg-brand-darksurface rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-brand-darkborder transition-colors">
                <h3 class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-6">Pratinjau Tagihan</h3>
                <div class="border border-gray-100 dark:border-gray-800 rounded-xl p-6 transition-colors">
                    <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-extrabold text-brand-dark dark:text-white">SkillKul Tagihan</h4>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">DRAF—belum dikirim</p>
                            </div>
                            <span class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Draf</span>
                        </div>
                    </div>
                    <div class="space-y-3 text-sm mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Kepada</span>
                            <span id="previewEmail" class="font-medium text-gray-400 dark:text-gray-500">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Layanan</span>
                            <span id="previewService" class="font-medium text-gray-400 dark:text-gray-500 text-right max-w-[180px] truncate">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Tipe</span>
                            <span class="font-medium dark:text-gray-300">Tagihan Khusus</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-[#2a0e88] to-[#160655] dark:from-indigo-900 dark:to-brand-darksurface text-white p-4 rounded-xl border border-transparent dark:border-brand-darkborder transition-colors">
                        <p class="text-[10px] text-indigo-300 dark:text-indigo-400 font-bold uppercase">Total Tagihan Rekening Bersama (Escrow)</p>
                        <h3 id="previewPrice" class="text-2xl font-black mt-1">Rp–</h3>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-800/30 rounded-2xl p-5 transition-colors">
                <h4 class="text-sm font-bold text-brand-dark dark:text-white mb-2">Bagaimana Cara Kerjanya?</h4>
                <ol class="text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed space-y-2 list-decimal list-inside">
                    <li>Anda membuat tagihan setelah menyepakati harga melalui WhatsApp.</li>
                    <li>Klien melihat tagihan di halaman pesanan mereka.</li>
                    <li>Klien membayar melalui Midtrans, lalu dana akan masuk ke rekening bersama (escrow).</li>
                    <li>Anda mengerjakan pesanan, kirim hasil, dan klien melakukan konfirmasi.</li>
                    <li>Dana cair ke dompet digital Anda (dikenakan potongan biaya platform sebesar 5%).</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Script: Live Preview saat mengisi form --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput    = document.getElementById('client_email');
        const serviceSelect = document.getElementById('service_id');
        const priceInput    = document.getElementById('total_price');

        const previewEmail   = document.getElementById('previewEmail');
        const previewService = document.getElementById('previewService');
        const previewPrice   = document.getElementById('previewPrice');

        // Format angka ke Rupiah
        function formatRupiah(angka) {
            if (!angka || isNaN(angka)) return 'Rp–';
            return 'Rp' + Number(angka).toLocaleString('id-ID');
        }

        emailInput.addEventListener('input', function () {
            previewEmail.textContent = this.value || '–';
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            if (this.value) {
                previewEmail.className = 'font-medium text-gray-900 dark:text-gray-100';
            } else {
                previewEmail.className = 'font-medium text-gray-400 dark:text-gray-500';
            }
        });

        serviceSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const title = selected.dataset.title || '–';
            previewService.textContent = title;
            
            if (this.value) {
                previewService.className = 'font-medium text-gray-900 dark:text-gray-100 text-right max-w-[180px] truncate';
            } else {
                previewService.className = 'font-medium text-gray-400 dark:text-gray-500 text-right max-w-[180px] truncate';
            }
        });

        priceInput.addEventListener('input', function () {
            previewPrice.textContent = formatRupiah(this.value);
        });
    });
</script>
@endsection
