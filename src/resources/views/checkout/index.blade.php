@extends('layouts.client')
@section('title', 'Checkout & Pembayaran - SkillKul')

@section('content')
<div class="max-w-6xl mx-auto px-6 lg:px-12 py-10 transition-colors duration-300">
    <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-brand-primary dark:text-indigo-400 tracking-widest uppercase mb-4">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        PEMBAYARAN AMAN
    </span>
    <h1 class="text-2xl md:text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight mb-8">
        {{ $order->service->title ?? 'Detail Pesanan' }}
    </h1>

    {{-- ── Pesan Status Pembayaran (ditampilkan via JS) ── --}}
    <div id="payment-status-banner" class="hidden mb-6 rounded-xl px-5 py-4 items-start gap-3 text-sm font-semibold border transition-colors"></div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- ──────────────────────────────────────────────────────────────
             LEFT: Detail Pesanan
        ────────────────────────────────────────────────────────────── --}}
        <div class="lg:col-span-7 space-y-6">

            {{-- Deliverables Card --}}
            <div class="bg-brand-dark rounded-2xl p-8 text-white shadow-lg border border-brand-darkborder transition-colors">
                <div class="space-y-4 mb-6">
                    <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10 backdrop-blur-sm">
                        <div class="w-5 h-5 rounded bg-brand-primary flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Layanan Dipesan</p>
                            <p class="text-[10px] text-indigo-300">{{ $order->service->title ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10 backdrop-blur-sm">
                        <div class="w-5 h-5 rounded bg-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Pekerja Lepas (Freelancer)</p>
                            <p class="text-[10px] text-indigo-300">{{ $order->freelancer->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10 backdrop-blur-sm">
                        <div class="w-5 h-5 rounded bg-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold">ID Pesanan</p>
                            <p class="text-[10px] text-indigo-300 font-mono">{{ $order->id }}</p>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-brand-primary/50 rounded-full w-3/4 mb-2 overflow-hidden">
                    <div class="h-full bg-brand-primary w-1/2"></div>
                </div>
            </div>

            {{-- Proyek Info --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-2xl p-6 border border-gray-100 dark:border-brand-darkborder shadow-sm transition-colors">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-8 h-8 bg-brand-primary dark:bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $order->service->title ?? 'Detail Jasa' }}</h4>
                        <span class="text-[10px] font-extrabold text-brand-primary dark:text-indigo-400 tracking-wider uppercase">
                            {{ $order->type === 'direct_checkout' ? 'HARGA TETAP' : 'BERBASIS PROYEK' }}
                        </span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                    {{ $order->service->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>


        </div>

        {{-- ──────────────────────────────────────────────────────────────
             RIGHT: Ringkasan & Tombol Bayar
        ────────────────────────────────────────────────────────────── --}}
        <div class="lg:col-span-5">
            <div class="sticky top-24 bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder p-8 shadow-xl transition-colors">
                <h3 class="font-extrabold text-lg text-brand-dark dark:text-white mb-6">Ringkasan Pesanan</h3>

                <div class="space-y-3 mb-6 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Subtotal Layanan</span>
                        <span class="font-bold text-gray-900 dark:text-white">
                            IDR {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                    {{-- Catatan: jika ada biaya admin, tambahkan perhitungannya di controller --}}
                    <div class="border-t border-gray-100 dark:border-brand-darkborder pt-3 flex justify-between">
                        <span class="font-extrabold text-brand-dark dark:text-white">Total</span>
                        <span class="font-extrabold text-xl text-brand-primary dark:text-indigo-400">
                            IDR {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Jaminan Escrow --}}
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/50 rounded-xl p-4 mb-6 flex items-start gap-3 transition-colors">
                    <div class="w-5 h-5 bg-green-100 dark:bg-green-800/50 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-green-800 dark:text-green-400">Jaminan Rekening Bersama (Escrow)</h4>
                        <p class="text-[10px] text-green-700 dark:text-green-300/80 leading-relaxed">
                            Seluruh dana Anda ditahan oleh sistem rekening bersama (escrow) SkillKul. Pekerja lepas baru akan menerima pembayaran setelah Anda menyetujui hasil pekerjaan.
                        </p>
                    </div>
                </div>

                {{-- ── Tombol Bayar ── --}}
                {{-- Tombol ini men-trigger getSnapToken via AJAX, lalu membuka popup Midtrans Snap --}}
                <button
                    id="btn-pay"
                    data-order-id="{{ $order->id }}"
                    data-snap-url="{{ route('midtrans.snapToken', $order->id) }}"
                    data-redirect-url="{{ route('pesanan.detail', ['id' => $order->id]) }}"
                    onclick="initiateMidtransPayment(this)"
                    class="w-full bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-500 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    @if($order->status !== 'pending' && $order->status !== 'waiting_payment') disabled @endif
                >
                    {{-- State: Default --}}
                    <span id="btn-pay-text" class="flex items-center gap-2">
                        Bayar Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                    {{-- State: Loading spinner (tersembunyi secara default) --}}
                    <span id="btn-pay-loading" class="hidden items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        Memuat...
                    </span>
                </button>

                @if($order->status === 'paid')
                    <p class="text-center text-xs text-green-600 dark:text-green-400 font-bold mt-3">✓ Pesanan ini sudah dibayar.</p>
                @elseif($order->status === 'cancelled')
                    <p class="text-center text-xs text-red-500 dark:text-red-400 font-bold mt-3">✗ Pesanan ini telah dibatalkan.</p>
                @endif

                <p class="text-center text-[10px] text-gray-400 dark:text-gray-500 mt-4 uppercase tracking-wider font-semibold">
                    Pembayaran aman melalui Midtrans &bull; Pesanan #{{ substr($order->id, 0, 8) }}
                </p>

                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-brand-darkborder flex items-center gap-2 text-gray-400 dark:text-gray-500 text-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Pekerja Lepas (Freelancer) Akademik Terverifikasi</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ============================================================
     SCRIPT MIDTRANS SNAP
     Dimuat di akhir <body> via @stack('scripts') di layout client.
     data-client-key wajib diisi agar popup Snap bisa terbuka.
============================================================ --}}
@push('scripts')

{{-- Debug info: pastikan client key sudah terisi --}}
{{-- Hapus baris ini di production --}}
<meta name="midtrans-client-key" content="{{ config('midtrans.client_key') }}">

<script>
    /**
     * Muat Snap.js secara dinamis, lalu aktifkan tombol Bayar.
     * Ini lebih reliable daripada <script src="..."> biasa karena kita
     * bisa tahu persis kapan library sudah siap digunakan.
     */
    (function loadSnapJs() {
        const clientKey = '{{ config('midtrans.client_key') }}';
        const snapUrl   = '{{ config('midtrans.snap_url') }}';

        // Debug info di console
        console.log('[SkillKul] Midtrans config:', {
            clientKey: clientKey,
            snapUrl: snapUrl,
            isProduction: false,
        });

        if (!clientKey) {
            console.error('[SkillKul] MIDTRANS_CLIENT_KEY tidak ditemukan di .env!');
            showBanner('error', '⚠️ Konfigurasi pembayaran tidak lengkap. Hubungi admin.');
            return;
        }

        const script = document.createElement('script');
        script.src = snapUrl;
        script.setAttribute('data-client-key', clientKey);

        script.onload = function () {
            console.log('[SkillKul] Snap.js berhasil dimuat. window.snap:', typeof window.snap);
            // Aktifkan tombol bayar setelah Snap.js siap
            const btn = document.getElementById('btn-pay');
            if (btn) {
                btn.removeAttribute('disabled');
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        };

        script.onerror = function () {
            console.error('[SkillKul] Gagal memuat Snap.js dari:', snapUrl);
            showBanner('error', '⚠️ Gagal memuat sistem pembayaran. Periksa koneksi internet Anda.');
        };

        document.head.appendChild(script);
    })();

    /**
     * initiateMidtransPayment
     *
     * Fungsi utama yang dipanggil saat tombol "Bayar Sekarang" diklik.
     * Alur:
     *  1. Pastikan window.snap tersedia (Snap.js sudah dimuat)
     *  2. Set tombol ke state loading
     *  3. Fetch Snap Token dari backend via POST AJAX
     *  4. Buka popup Midtrans Snap dengan token yang didapat
     *  5. Handle callback: onSuccess, onPending, onError, onClose
     *
     * @param {HTMLButtonElement} btn - Elemen tombol yang diklik
     */
    async function initiateMidtransPayment(btn) {
        // Pastikan Snap.js sudah dimuat
        if (typeof window.snap === 'undefined') {
            console.error('[SkillKul] window.snap tidak tersedia!');
            showBanner('error', 'Sistem pembayaran belum siap. Tunggu beberapa detik lalu coba lagi.');
            return;
        }

        const snapUrl     = btn.dataset.snapUrl;
        const redirectUrl = btn.dataset.redirectUrl;

        console.log('[SkillKul] Memulai pembayaran:', { snapUrl, redirectUrl });

        // Ubah tampilan tombol ke state loading
        setButtonLoading(true);
        hideBanner();

        try {
            // ── Langkah 1: Request Snap Token dari backend ──────────────
            const response = await fetch(snapUrl, {
                method: 'POST',
                headers: {
                    // CSRF token diambil dari meta tag di layout
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                },
            });

            console.log('[SkillKul] Response status:', response.status);
            const data = await response.json();
            console.log('[SkillKul] Response data:', data);

            // Jika backend mengembalikan error
            if (! data.success) {
                showBanner('error', '⚠️ ' + (data.message ?? 'Gagal mendapatkan token pembayaran.'));
                setButtonLoading(false);
                return;
            }

            const snapToken = data.snap_token;
            console.log('[SkillKul] Snap Token diterima. Membuka popup...');

            // ── Langkah 2: Buka popup Midtrans Snap ─────────────────────
            window.snap.pay(snapToken, {

                /**
                 * onSuccess — Pembayaran berhasil & sudah dikonfirmasi Midtrans.
                 */
                onSuccess: function (result) {
                    console.log('[SkillKul] Pembayaran sukses:', result);
                    showBanner('success', '✓ Pembayaran berhasil! Mengalihkan ke halaman pesanan...');
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 1500);
                },

                /**
                 * onPending — Pembayaran sedang menunggu konfirmasi.
                 */
                onPending: function (result) {
                    console.log('[SkillKul] Pembayaran pending:', result);
                    showBanner(
                        'pending',
                        'Menunggu pembayaran. Selesaikan pembayaran sesuai instruksi yang dikirimkan.'
                    );
                    setButtonLoading(false);
                },

                /**
                 * onError — Terjadi error saat proses pembayaran.
                 */
                onError: function (result) {
                    console.error('[SkillKul] Midtrans payment error:', result);
                    showBanner(
                        'error',
                        '✗ Pembayaran gagal: ' + (result.status_message ?? 'Terjadi kesalahan. Silakan coba lagi.')
                    );
                    setButtonLoading(false);
                },

                /**
                 * onClose — User menutup popup Snap tanpa menyelesaikan pembayaran.
                 */
                onClose: function () {
                    console.log('[SkillKul] Popup Snap ditutup.');
                    setButtonLoading(false);
                },
            });

        } catch (error) {
            // Error jaringan atau server tidak merespons
            console.error('[SkillKul] Fetch error:', error);
            showBanner('error', '✗ Koneksi gagal. Periksa jaringan Anda dan coba lagi.');
            setButtonLoading(false);
        }
    }

    /**
     * setButtonLoading
     *
     * Toggle tampilan tombol antara state normal dan state loading.
     *
     * @param {boolean} isLoading
     */
    function setButtonLoading(isLoading) {
        const btn        = document.getElementById('btn-pay');
        const txtNormal  = document.getElementById('btn-pay-text');
        const txtLoading = document.getElementById('btn-pay-loading');

        btn.disabled = isLoading;

        if (isLoading) {
            txtNormal.classList.add('hidden');
            txtLoading.classList.remove('hidden');
            txtLoading.classList.add('flex');
        } else {
            txtLoading.classList.add('hidden');
            txtLoading.classList.remove('flex');
            txtNormal.classList.remove('hidden');
        }
    }

    /**
     * showBanner
     *
     * Tampilkan banner notifikasi status pembayaran di atas konten.
     *
     * @param {'success'|'pending'|'error'} type
     * @param {string} message
     */
    function showBanner(type, message) {
        const banner = document.getElementById('payment-status-banner');

        // Reset class sebelumnya
        banner.className = 'mb-6 rounded-xl px-5 py-4 flex items-start gap-3 text-sm font-semibold border';

        const styles = {
            success: 'bg-green-50 border-green-200 text-green-800',
            pending: 'bg-yellow-50 border-yellow-200 text-yellow-800',
            error:   'bg-red-50   border-red-200   text-red-800',
        };

        banner.classList.add(...(styles[type] ?? styles.error).split(' '));
        banner.textContent = message;
        banner.classList.remove('hidden');

        // Scroll ke banner agar terlihat
        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    /**
     * hideBanner
     *
     * Sembunyikan banner notifikasi.
     */
    function hideBanner() {
        const banner = document.getElementById('payment-status-banner');
        banner.classList.add('hidden');
    }
</script>
@endpush


