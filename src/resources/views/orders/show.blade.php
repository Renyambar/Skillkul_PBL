@extends('layouts.client')
@section('title', 'Detail Pesanan - SkillKul')
@section('content')
@php
    $statusConfig = [
        'pending'     => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
        'paid'        => ['label' => 'Dibayar', 'bg' => 'bg-sky-100', 'text' => 'text-sky-800'],
        'in_progress' => ['label' => 'Dalam Proses', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
        'delivered'   => ['label' => 'Terkirim', 'bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
        'completed'   => ['label' => 'Selesai', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
        'canceled'    => ['label' => 'Dibatalkan', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
    ];
    $s = $statusConfig[$order->status] ?? ['label' => 'Unknown', 'bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
    
    // Check if user is the client
    $isClient = auth()->check() && auth()->id() === $order->client_id;
    
    // Timeline steps
    $steps = [
        'pending' => 'Pending',
        'paid' => 'Dibayar',
        'in_progress' => 'Dikerjakan',
        'delivered' => 'Dikirim',
        'completed' => 'Selesai'
    ];
    $stepOrder = array_keys($steps);
    $currentIdx = array_search($order->status, $stepOrder);
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('pesanan.klien') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 hover:underline flex items-center gap-1 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Kembali ke Daftar Pesanan
    </a>

    {{-- 1. Header --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-mono text-gray-500 uppercase tracking-widest">ORDER #{{ substr($order->id, 0, 8) }}</span>
                <h1 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $order->service->title ?? 'Layanan tidak ditemukan' }}</h1>
            </div>
            <span class="{{ $s['bg'] }} {{ $s['text'] }} text-sm font-extrabold px-5 py-2.5 rounded-xl uppercase tracking-wider shadow-sm border border-white/50 text-center">{{ $s['label'] }}</span>
        </div>
    </div>

    {{-- 2. Timeline Stepper Horizontal --}}
    @if($order->status !== 'canceled')
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8 overflow-x-auto">
        <div class="flex items-center min-w-max">
            @foreach($steps as $key => $label)
                @php
                    $thisIdx = array_search($key, $stepOrder);
                    $isPast = $thisIdx !== false && $currentIdx !== false && $thisIdx < $currentIdx;
                    $isCurrent = $thisIdx !== false && $currentIdx !== false && $thisIdx === $currentIdx;
                    $isFuture = $thisIdx !== false && $currentIdx !== false && $thisIdx > $currentIdx;
                @endphp
                
                {{-- Step Indicator --}}
                <div class="flex flex-col items-center relative z-10 w-24">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mb-2 transition-colors {{ $isPast ? 'bg-green-500 text-white' : ($isCurrent ? 'bg-indigo-600 text-white animate-pulse shadow-lg shadow-indigo-200' : 'bg-gray-200 text-gray-400') }}">
                        @if($isPast || ($key === 'completed' && $isCurrent))
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <span class="text-xs font-bold">{{ $thisIdx + 1 }}</span>
                        @endif
                    </div>
                    <span class="text-xs font-bold {{ $isPast || $isCurrent ? 'text-gray-900' : 'text-gray-400' }} text-center">{{ $label }}</span>
                </div>

                {{-- Connector Line --}}
                @if(!$loop->last)
                    <div class="flex-1 h-1 mx-2 rounded-full {{ $isPast ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- 3. Grid 2 Kolom --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- Kiri: Info Pesanan, Klien, Freelancer --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Tanggal Pesanan</p>
                    <p class="font-bold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Tipe Pesanan</p>
                    <p class="font-bold text-gray-900">
                        @if($order->type === 'custom_invoice')
                            <span class="text-orange-600 bg-orange-50 px-2 py-0.5 rounded text-xs uppercase tracking-wider">Custom Invoice</span>
                        @else
                            <span class="text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded text-xs uppercase tracking-wider">Direct Checkout</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Klien</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-xs">{{ substr($order->client->name ?? 'U', 0, 1) }}</div>
                        <span class="font-bold text-gray-900">{{ $order->client->name ?? 'User tidak ditemukan' }}</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Freelancer</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-xs">{{ substr($order->freelancer->name ?? 'F', 0, 1) }}</div>
                        <span class="font-bold text-gray-900">{{ $order->freelancer->name ?? 'User tidak ditemukan' }}</span>
                    </div>
                </div>
            </div>

            {{-- 4. Section Link & Catatan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6">
                {{-- Catatan Pesanan --}}
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Catatan Pesanan</h3>
                    <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-wrap">{{ $order->order_notes ?: 'Tidak ada catatan khusus yang diberikan.' }}</div>
                </div>

                {{-- Link Bahan Klien --}}
                @if($order->client_gdrive_link)
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Bahan dari Klien</h3>
                    <a href="{{ $order->client_gdrive_link }}" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 hover:underline font-medium text-sm transition-colors bg-indigo-50 px-4 py-2.5 rounded-lg border border-indigo-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        Buka Tautan Bahan Google Drive
                    </a>
                </div>
                @endif

                {{-- Link Hasil Pekerjaan --}}
                @if($order->freelancer_result_link)
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Hasil Pekerjaan Freelancer</h3>
                    <a href="{{ $order->freelancer_result_link }}" target="_blank" class="inline-flex items-center gap-2 text-green-700 hover:text-green-900 hover:underline font-medium text-sm transition-colors bg-green-50 px-4 py-2.5 rounded-lg border border-green-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Buka Tautan Hasil Google Drive
                    </a>
                </div>
                @endif
            </div>
            
            {{-- Review Section --}}
            @if($order->status === 'completed' && $order->review)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Ulasan Anda</h3>
                <div class="flex items-center gap-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $order->review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor
                </div>
                <p class="text-sm text-gray-700 italic border-l-4 border-gray-200 pl-3">"{{ $order->review->comment ?? 'Tidak ada komentar.' }}"</p>
            </div>
            @endif
        </div>

        {{-- Kanan: Ringkasan Tagihan --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan Tagihan</h3>
                @php
                    $total = $order->total_price;
                    $subtotal = $total / 1.05; // Total includes 5% admin fee
                    $adminFee = $total - $subtotal;
                @endphp
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Harga Layanan</span>
                        <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Biaya Admin (5%)</span>
                        <span class="font-medium">Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 mt-3 flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total Pembayaran</span>
                        <span class="font-extrabold text-indigo-600 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                @if($order->status !== 'canceled')
                <div class="mt-6 bg-green-50 border border-green-100 rounded-xl p-4">
                    <h4 class="text-xs font-bold text-green-800 mb-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Perlindungan Escrow
                    </h4>
                    <p class="text-[10px] text-green-700 leading-relaxed">Dana Anda ditahan dengan aman oleh SkillKul dan baru diteruskan ke freelancer jika pesanan telah Anda terima.</p>
                </div>
                @endif
            </div>

            {{-- 5. Tombol Aksi di Bawah --}}
            @if($isClient)
                @if($order->status === 'pending')
                    <button id="btn-bayar" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Bayar Sekarang
                    </button>
                @elseif($order->status === 'delivered')
                    <div x-data="{ showReviewModal: false }">
                        <button @click="showReviewModal = true" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pesanan Diterima
                        </button>

                        {{-- Modal Review --}}
                        <div x-show="showReviewModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div x-show="showReviewModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showReviewModal = false" aria-hidden="true"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                <div x-show="showReviewModal" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                    <form action="{{ route('orders.accept', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Terima Pesanan & Beri Ulasan</h3>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-500 mb-4">Dengan menerima pesanan, dana escrow akan diteruskan ke freelancer. Berikan ulasan untuk membantu freelancer ini.</p>
                                                        
                                                        <div x-data="{ rating: 5 }" class="mb-4">
                                                            <label class="block text-xs font-bold text-gray-700 mb-2">Rating</label>
                                                            <div class="flex gap-1">
                                                                <template x-for="star in 5" :key="star">
                                                                    <button type="button" @click="rating = star" class="focus:outline-none transition-transform hover:scale-110">
                                                                        <svg class="w-8 h-8 transition-colors" :class="star <= rating ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                                    </button>
                                                                </template>
                                                            </div>
                                                            <input type="hidden" name="rating" x-bind:value="rating">
                                                        </div>

                                                        <div>
                                                            <label class="block text-xs font-bold text-gray-700 mb-2">Komentar (Opsional)</label>
                                                            <textarea name="comment" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-xl px-3 py-2 outline-none resize-none" placeholder="Tulis pengalaman Anda bekerja dengan freelancer ini..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                Terima & Kirim Ulasan
                                            </button>
                                            <button type="button" @click="showReviewModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
