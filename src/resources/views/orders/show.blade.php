@extends('layouts.client')
@section('title', 'Detail Pesanan #' . substr($order->id, 0, 8) . ' - SkillKul')
@section('content')
@php
    $isClient     = auth()->check() && auth()->id() === $order->client_id;
    $isFreelancer = auth()->check() && auth()->id() === $order->freelancer_id;

    $statusConfig = [
        'pending'         => ['label' => 'Belum Dibayar',       'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'ring' => 'ring-yellow-200'],
        'waiting_payment' => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'ring' => 'ring-yellow-200'],
        'paid'            => ['label' => 'Dibayar',             'bg' => 'bg-sky-100',    'text' => 'text-sky-700',    'ring' => 'ring-sky-200'],
        'in_progress'     => ['label' => 'Dikerjakan',          'bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'ring' => 'ring-blue-200'],
        'revision'        => ['label' => 'Revisi',              'bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'ring' => 'ring-orange-200'],
        'delivered'       => ['label' => 'Terkirim',            'bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'ring' => 'ring-purple-200'],
        'completed'       => ['label' => 'Selesai',             'bg' => 'bg-green-100',  'text' => 'text-green-700',  'ring' => 'ring-green-200'],
        'canceled'        => ['label' => 'Dibatalkan',          'bg' => 'bg-red-100',    'text' => 'text-red-700',    'ring' => 'ring-red-200'],
    ];
    $s = $statusConfig[$order->status] ?? ['label' => ucfirst($order->status), 'bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'ring' => 'ring-gray-200'];

    // Timeline (hanya untuk pesanan non-canceled)
    $steps    = ['pending' => 'Dipesan', 'paid' => 'Dibayar', 'in_progress' => 'Dikerjakan', 'delivered' => 'Terkirim', 'completed' => 'Selesai'];
    $stepKeys = array_keys($steps);
    $currIdx  = array_search(in_array($order->status, $stepKeys) ? $order->status : 'pending', $stepKeys);

    // Fee platform (dari .env, default 8%)
    $feePercent = (float) config('skillkul.platform_fee_percent', 8);
    $total      = (float) $order->total_price;
    $platformFee = round($total * $feePercent / 100, 2);
    $serviceFee  = round($total - $platformFee, 2);
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Back link --}}
    <a href="{{ $isFreelancer ? route('freelancer.pesanan') : route('pesanan.klien') }}"
       class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-800 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Daftar Pesanan
    </a>

    {{-- Flash Messages --}}
    @foreach(['success' => 'green', 'error' => 'red'] as $type => $color)
        @if(session($type))
        <div class="mb-6 bg-{{ $color }}-50 border border-{{ $color }}-200 text-{{ $color }}-800 text-sm font-semibold rounded-xl px-5 py-4 flex items-center gap-3">
            @if($type === 'success')
                <svg class="w-5 h-5 shrink-0 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            @else
                <svg class="w-5 h-5 shrink-0 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
            @endif
            {{ session($type) }}
        </div>
        @endif
    @endforeach

    {{-- ── 1. Header ────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-mono text-gray-400 uppercase tracking-widest">Pesanan #{{ substr($order->id, 0, 8) }}</p>
            <h1 class="text-2xl font-extrabold text-gray-900 mt-1 leading-tight">
                {{ $order->service->title ?? 'Layanan tidak ditemukan' }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $order->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
            </p>
        </div>
        <span class="self-start shrink-0 {{ $s['bg'] }} {{ $s['text'] }} text-sm font-extrabold px-5 py-2.5 rounded-xl uppercase tracking-wider ring-1 {{ $s['ring'] }}">
            {{ $s['label'] }}
        </span>
    </div>

    {{-- ── 2. Timeline Stepper ──────────────────────────────── --}}
    @if(! in_array($order->status, ['canceled', 'pending', 'waiting_payment']))
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5 mb-8 overflow-x-auto">
        <div class="flex items-center min-w-max">
            @foreach($steps as $key => $label)
                @php
                    $idx      = array_search($key, $stepKeys);
                    $isPast   = $idx < $currIdx;
                    $isCurrent= $idx === $currIdx;
                @endphp
                <div class="flex flex-col items-center relative z-10 w-24">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 mb-2
                        {{ $isPast ? 'bg-green-500 text-white' : ($isCurrent ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-gray-100 text-gray-400') }}
                        {{ $isCurrent ? 'animate-pulse' : '' }}">
                        @if($isPast)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <span class="text-xs font-bold">{{ $idx + 1 }}</span>
                        @endif
                    </div>
                    <span class="text-xs font-semibold {{ $isPast || $isCurrent ? 'text-gray-800' : 'text-gray-400' }} text-center leading-tight">{{ $label }}</span>
                </div>
                @if(! $loop->last)
                    <div class="flex-1 h-1 mx-1 rounded-full {{ $isPast ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── 3. Two-Column Layout ─────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Detail Info --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Informasi Pesanan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Informasi Pesanan</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Klien</p>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                {{ strtoupper(substr($order->client->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-900">{{ $order->client->name ?? '—' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Freelancer</p>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700">
                                {{ strtoupper(substr($order->freelancer->name ?? 'F', 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-900">{{ $order->freelancer->name ?? '—' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Tipe Pesanan</p>
                        @if($order->type === 'custom_invoice')
                            <span class="text-orange-600 bg-orange-50 px-2 py-0.5 rounded text-xs font-bold uppercase">Tagihan Khusus</span>
                        @else
                            <span class="text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded text-xs font-bold uppercase">Direct Checkout</span>
                        @endif
                    </div>
                    @if($order->deadline)
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Deadline</p>
                        <p class="font-semibold {{ now()->greaterThan($order->deadline) && ! in_array($order->status, ['completed', 'canceled']) ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $order->deadline->locale('id')->isoFormat('D MMM YYYY') }}
                            @if(now()->greaterThan($order->deadline) && ! in_array($order->status, ['completed', 'canceled']))
                                <span class="text-red-500 text-xs">(Terlewat)</span>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($order->revision_limit)
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Revisi</p>
                        <p class="font-semibold text-gray-900">{{ $order->revision_count }}/{{ $order->revision_limit }}x digunakan</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Catatan & Link --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Catatan Pesanan</h3>
                    <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">
                        {{ $order->order_notes ?: 'Tidak ada catatan khusus.' }}
                    </div>
                </div>

                @if($order->client_gdrive_link)
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Bahan dari Klien</h3>
                    <a href="{{ $order->client_gdrive_link }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold text-sm bg-indigo-50 hover:bg-indigo-100 px-4 py-2.5 rounded-xl border border-indigo-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.1-1.1m-.758-4.9a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Buka Tautan Google Drive
                    </a>
                </div>
                @endif

                @if($order->freelancer_result_link)
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Hasil Pekerjaan Freelancer</h3>
                    <a href="{{ $order->freelancer_result_link }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 text-green-700 hover:text-green-900 font-semibold text-sm bg-green-50 hover:bg-green-100 px-4 py-2.5 rounded-xl border border-green-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Buka Hasil Kerja
                    </a>
                </div>
                @endif
            </div>

            {{-- Ulasan (jika sudah completed) --}}
            @if($order->status === 'completed' && $order->review)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-3">Ulasan Anda</h3>
                <div class="flex items-center gap-1 mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $order->review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    <span class="text-sm font-semibold text-gray-700 ml-1">{{ $order->review->rating }}/5</span>
                </div>
                @if($order->review->comment)
                <p class="text-sm text-gray-600 italic border-l-4 border-indigo-100 pl-4 leading-relaxed">
                    "{{ $order->review->comment }}"
                </p>
                @endif
            </div>
            @endif

            {{-- Info Dibatalkan --}}
            @if($order->status === 'canceled')
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <h3 class="font-bold text-red-800 mb-1">Pesanan Dibatalkan</h3>
                        <p class="text-sm text-red-700">
                            Pesanan ini telah dibatalkan
                            @if($order->cancelled_at) pada {{ $order->cancelled_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}@endif.
                        </p>
                        @if($order->escrow && $order->escrow->status === 'refunded')
                        <p class="text-sm text-red-700 mt-1">
                            ✓ Dana <strong>Rp {{ number_format($order->escrow->amount, 0, ',', '.') }}</strong> telah dikembalikan ke Wallet SkillKul Anda.
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT: Ringkasan & Aksi --}}
        <div class="lg:col-span-1 space-y-5">

            {{-- Ringkasan Tagihan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Harga Layanan</span>
                        <span class="font-medium">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Platform ({{ $feePercent }}%)</span>
                        <span class="font-medium">Rp {{ number_format($platformFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2.5 flex justify-between">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-extrabold text-indigo-600 text-base">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Escrow badge --}}
                @if(! in_array($order->status, ['canceled', 'pending', 'waiting_payment']))
                <div class="mt-4 bg-green-50 border border-green-100 rounded-xl p-3.5 flex items-start gap-2">
                    <svg class="w-4 h-4 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <div>
                        <p class="text-xs font-bold text-green-800">Dilindungi Escrow SkillKul</p>
                        <p class="text-[10px] text-green-700 mt-0.5 leading-relaxed">Dana Anda ditahan aman & diteruskan ke freelancer hanya setelah Anda menerima hasil kerja.</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- ── Tombol Aksi (Client Only) ─────────────────── --}}
            @if($isClient)

                {{-- Status: Belum Bayar → Lanjutkan Pembayaran --}}
                @if(in_array($order->status, ['pending', 'waiting_payment']))
                <a href="{{ route('checkout', $order->id) }}"
                   class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-md flex items-center justify-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Lanjutkan Pembayaran
                </a>
                @endif

                {{-- Status: Delivered → Terima / Revisi --}}
                @if($order->status === 'delivered')
                <div x-data="{ showModal: false }" class="space-y-3">
                    {{-- Tombol Terima --}}
                    <button @click="showModal = true"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-md flex items-center justify-center gap-2 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Terima Pesanan
                    </button>

                    {{-- Tombol Revisi --}}
                    @if($order->revision_count < $order->revision_limit)
                    <form action="{{ route('orders.requestRevision', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Kirim permintaan revisi ke freelancer?')"
                                class="w-full bg-orange-50 border border-orange-200 text-orange-700 hover:bg-orange-100 font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Minta Revisi ({{ $order->revision_limit - $order->revision_count }} sisa)
                        </button>
                    </form>
                    @else
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-500">Batas revisi ({{ $order->revision_limit }}x) sudah habis.</p>
                    </div>
                    @endif

                    {{-- Auto-complete info --}}
                    @if($order->submitted_at)
                    @php $autoAt = $order->submitted_at->addHours(48); $hoursLeft = max(0, now()->diffInHours($autoAt, false)); @endphp
                    @if(now()->lessThan($autoAt))
                    <div class="bg-amber-50 border border-amber-100 rounded-xl p-3">
                        <p class="text-xs text-amber-700 text-center">⏰ Auto-selesai dalam <strong>{{ $hoursLeft }} jam</strong></p>
                    </div>
                    @endif
                    @endif

                    {{-- Modal Review --}}
                    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
                        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showModal = false"></div>
                        <div x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Terima & Beri Ulasan</h3>
                            <p class="text-sm text-gray-500 mb-5">Dana escrow akan diteruskan ke freelancer setelah konfirmasi ini.</p>
                            <form action="{{ route('orders.accept', $order->id) }}" method="POST">
                                @csrf
                                <div x-data="{ rating: 5 }" class="mb-5">
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Rating</label>
                                    <div class="flex gap-2">
                                        <template x-for="star in 5" :key="star">
                                            <button type="button" @click="rating = star" class="focus:outline-none">
                                                <svg class="w-9 h-9 transition-colors" :class="star <= rating ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="rating" x-bind:value="rating">
                                </div>
                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Komentar (Opsional)</label>
                                    <textarea name="comment" rows="3" placeholder="Tulis pengalaman Anda..."
                                              class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 resize-none"></textarea>
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl transition-all">
                                        Konfirmasi & Terima
                                    </button>
                                    <button type="button" @click="showModal = false" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl transition-all">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Status: paid/in_progress → Tombol Batalkan (dalam 12 jam) --}}
                @if($canCancel)
                @php $minutesLeft = $cancelHoursLeft; $h = intdiv($minutesLeft, 60); $m = $minutesLeft % 60; @endphp
                <div x-data="{ showCancel: false }" class="border-t border-gray-100 pt-4 mt-2">
                    <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 mb-3">
                        <p class="text-xs text-amber-700 text-center">
                            ⏱ Batas batalkan: <strong>{{ $h }} jam {{ $m }} menit</strong> lagi
                        </p>
                    </div>
                    <button @click="showCancel = true"
                            class="w-full bg-white border border-red-200 text-red-600 hover:bg-red-50 font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batalkan Pesanan
                    </button>

                    {{-- Modal Konfirmasi Cancel --}}
                    <div x-show="showCancel" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
                        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showCancel = false"></div>
                        <div x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Batalkan Pesanan?</h3>
                                    <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                            </div>
                            <div class="bg-green-50 border border-green-100 rounded-xl p-3.5 mb-5">
                                <p class="text-sm text-green-800 font-semibold">
                                    ✓ Dana <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> akan dikembalikan ke Wallet SkillKul Anda.
                                </p>
                            </div>
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                @csrf
                                <div class="flex gap-3">
                                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition-all">
                                        Ya, Batalkan
                                    </button>
                                    <button type="button" @click="showCancel = false" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl transition-all">
                                        Tidak
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

            @endif {{-- end isClient --}}

            {{-- ── Tombol Aksi (Freelancer Only) ────────────── --}}
            @if($isFreelancer)
                @if(in_array($order->status, ['paid', 'in_progress', 'revision']))
                <div x-data="{ open: false }" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-bold text-gray-900 mb-3">Kirim Hasil Pekerjaan</h3>
                    <form action="{{ route('freelancer.pesanan.submitResult', $order->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Link Google Drive (Hasil Kerja)</label>
                            <input type="url" name="freelancer_result_link" required
                                   value="{{ $order->freelancer_result_link }}"
                                   placeholder="https://drive.google.com/..."
                                   class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400">
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all">
                            {{ $order->freelancer_result_link ? 'Update & Kirim Ulang' : 'Kirim Hasil' }}
                        </button>
                    </form>
                </div>
                @elseif($order->status === 'delivered')
                <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5 text-center">
                    <svg class="w-8 h-8 text-purple-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-bold text-purple-800 text-sm">Menunggu Konfirmasi Klien</p>
                    <p class="text-xs text-purple-600 mt-1">Hasil sudah dikirim. Auto-selesai dalam 48 jam jika klien tidak merespons.</p>
                </div>
                @elseif($order->status === 'completed')
                <div class="bg-green-50 border border-green-100 rounded-2xl p-5 text-center">
                    <svg class="w-8 h-8 text-green-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-bold text-green-800 text-sm">Pesanan Selesai!</p>
                    <p class="text-xs text-green-600 mt-1">Dana sudah diteruskan ke wallet Anda.</p>
                </div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection
