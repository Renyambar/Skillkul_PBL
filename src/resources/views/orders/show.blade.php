@extends('layouts.client')
@section('title', 'Detail Pesanan - SkillKul')
@section('content')
@php
    // Dummy data untuk demo UI
    $order = (object) [
        'id' => 'ORD-2401',
        'service_title' => 'Pembuatan Landing Page Perusahaan',
        'status' => 'delivered', // pending, paid, in_progress, delivered, completed, canceled
        'type' => 'direct_checkout',
        'total_price' => 1575000,
        'order_notes' => 'Buatkan landing page modern untuk perusahaan rintisan di bidang fintech. Harus responsif, performa tinggi (skor Lighthouse 90+), dan memiliki integrasi form kontak.',
        'client_gdrive_link' => 'https://drive.google.com/drive/folders/xxx',
        'freelancer_result_link' => 'https://drive.google.com/drive/folders/yyy',
        'created_at' => '15 Apr 2024',
    ];
    $statusConfig = [
        'pending'     => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'paid'        => ['label' => 'Dibayar', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'in_progress' => ['label' => 'Dalam Proses', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'delivered'   => ['label' => 'Terkirim', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
        'completed'   => ['label' => 'Selesai', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
        'canceled'    => ['label' => 'Dibatalkan', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
    ];
    $s = $statusConfig[$order->status];
@endphp

<div class="max-w-5xl mx-auto px-6 lg:px-8 py-10">
    <a href="{{ route('pesanan.klien') }}" class="text-sm font-semibold text-brand-primary hover:underline flex items-center gap-1 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Kembali ke Pesanan
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-6">
            {{-- Header Pesanan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">#{{ $order->id }}</span>
                        <h1 class="text-xl font-extrabold text-brand-dark mt-1">{{ $order->service_title }}</h1>
                    </div>
                    <span class="{{ $s['bg'] }} {{ $s['text'] }} text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">{{ $s['label'] }}</span>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <img src="https://i.pravatar.cc/150?img=33" class="w-6 h-6 rounded-full">
                        <span class="font-medium">Alex Chandra</span>
                    </div>
                    <span>•</span>
                    <span>Dipesan: {{ $order->created_at }}</span>
                </div>
            </div>

            {{-- Catatan Pesanan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-3">Catatan Pesanan</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $order->order_notes }}</p>
            </div>

            {{-- Link Bahan Klien --}}
            @if($order->client_gdrive_link)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-3">Bahan dari Klien</h3>
                <a href="{{ $order->client_gdrive_link }}" target="_blank" class="bg-gray-50 rounded-xl p-4 flex items-center gap-4 border border-gray-100 hover:bg-indigo-50 transition-colors">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-gray-900">Google Drive - Bahan Pesanan</p>
                        <p class="text-xs text-gray-400">Klik untuk membuka tautan</p>
                    </div>
                </a>
            </div>
            @endif

            {{-- File Hasil Kerja --}}
            @if($order->freelancer_result_link && in_array($order->status, ['delivered', 'completed']))
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-3">Hasil Kerja Freelancer</h3>
                <a href="{{ $order->freelancer_result_link }}" target="_blank" class="bg-green-50 rounded-xl p-4 flex items-center gap-4 border border-green-100 hover:bg-green-100 transition-colors">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-gray-900">Google Drive - Hasil Pekerjaan</p>
                        <p class="text-xs text-gray-400">Unduh atau tinjau hasil kerja</p>
                    </div>
                </a>
            </div>
            @endif

            {{-- Review Form (jika status = delivered) --}}
            @if($order->status === 'delivered')
            <div class="bg-brand-primary/5 rounded-2xl border-2 border-dashed border-brand-primary/30 p-6" x-data="{ rating: 0, showForm: false }">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-brand-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-brand-dark">Pekerjaan Sudah Dikirim!</h3>
                        <p class="text-xs text-gray-500">Tinjau hasil kerja, lalu konfirmasi jika Anda puas.</p>
                    </div>
                </div>

                <button @click="showForm = !showForm" class="w-full bg-brand-primary text-white font-bold py-3.5 rounded-xl hover:bg-brand-dark transition-all shadow-lg text-sm mb-3">
                    ✓ Pesanan Diterima & Beri Ulasan
                </button>

                {{-- Expand: Rating + Review Form --}}
                <div x-show="showForm" x-transition class="mt-4 bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                    <form action="{{ route('orders.review', 1) }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-3">Beri Rating</label>
                            <div class="flex gap-2">
                                <template x-for="star in 5" :key="star">
                                    <button type="button" @click="rating = star"
                                        :class="star <= rating ? 'text-yellow-400 scale-110' : 'text-gray-300'"
                                        class="text-3xl transition-all hover:scale-125 focus:outline-none">★</button>
                                </template>
                            </div>
                            <input type="hidden" name="rating" :value="rating">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-brand-secondary uppercase tracking-widest mb-2">Komentar Ulasan</label>
                            <textarea name="comment" rows="3" placeholder="Ceritakan pengalaman Anda dengan freelancer ini..."
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-brand-primary focus:border-brand-primary outline-none resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition-all text-sm shadow-sm">
                            Konfirmasi & Kirim Ulasan
                        </button>
                    </form>
                </div>

                <button class="w-full border border-gray-200 text-gray-700 font-bold py-3.5 rounded-xl hover:bg-gray-50 transition-all text-sm">Minta Revisi</button>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan Biaya</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-bold">Rp {{ number_format($order->total_price * 100/105, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Biaya Admin (5%)</span><span class="font-bold">Rp {{ number_format($order->total_price - ($order->total_price * 100/105), 0, ',', '.') }}</span></div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between"><span class="font-bold">Total</span><span class="font-extrabold text-brand-primary text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-100 rounded-2xl p-5">
                <h4 class="text-sm font-bold text-green-800 mb-2">Escrow Aktif</h4>
                <p class="text-[11px] text-green-700 leading-relaxed">Dana Anda aman di escrow SkillKul. Pembayaran baru diteruskan ke freelancer setelah Anda konfirmasi.</p>
            </div>

            {{-- Status Timeline --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Status Pesanan</h3>
                <div class="space-y-4">
                    @php $steps = ['pending' => 'Pesanan Dibuat', 'paid' => 'Pembayaran Diterima', 'in_progress' => 'Sedang Dikerjakan', 'delivered' => 'Hasil Dikirim', 'completed' => 'Selesai']; @endphp
                    @foreach($steps as $key => $label)
                        @php
                            $stepOrder = array_keys($steps);
                            $currentIdx = array_search($order->status, $stepOrder);
                            $thisIdx = array_search($key, $stepOrder);
                            $done = $thisIdx !== false && $currentIdx !== false && $thisIdx <= $currentIdx;
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 {{ $done ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                                @if($done)
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <span class="text-[8px] font-bold">{{ $thisIdx + 1 }}</span>
                                @endif
                            </div>
                            <span class="text-sm {{ $done ? 'font-bold text-gray-900' : 'text-gray-400' }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
