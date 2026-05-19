@extends('layouts.public')
@section('title', $service->title . ' - SkillKul')
@section('content')

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-10">
    {{-- Breadcrumb --}}
    <div class="text-xs text-gray-400 font-medium mb-6 flex items-center gap-2">
        <a href="{{ route('katalog') }}" class="hover:text-brand-primary">Pasar Layanan</a>
        <span>›</span>
        <span class="text-gray-600">{{ $service->category?->name ?? '–' }}</span>
        <span>›</span>
        <span class="text-brand-primary font-semibold">{{ Str::limit($service->title, 30) }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Left Content --}}
        <div class="lg:col-span-8 space-y-8">
            {{-- Hero Image --}}
            <div class="relative rounded-3xl overflow-hidden h-72 md:h-96 bg-gradient-to-br from-indigo-500 to-purple-600">
                @if($service->image)
                    <img src="{{ Storage::url($service->image) }}" class="w-full h-full object-cover" alt="{{ $service->title }}">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6">
                    @if($service->type === 'project')
                        <span class="bg-orange-500 text-white text-[10px] font-extrabold px-4 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">Harga Nego (Project)</span>
                    @else
                        <span class="bg-green-500 text-white text-[10px] font-extrabold px-4 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">Harga Pas — Langsung Bayar</span>
                    @endif
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white mt-3 drop-shadow-lg max-w-lg leading-tight">{{ $service->title }}</h1>
                </div>
            </div>

            {{-- Freelancer Info --}}
            <div class="flex items-center justify-between bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    @if($service->freelancer?->profile_photo_path)
                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                             class="w-12 h-12 rounded-full object-cover border-2 border-indigo-100">
                    @else
                        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 font-extrabold text-lg flex items-center justify-center border-2 border-indigo-100">
                            {{ strtoupper(substr($service->freelancer?->name ?? '?', 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $service->freelancer?->name ?? 'Freelancer' }}</h4>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="flex items-center gap-1 text-yellow-500">★ <span class="text-gray-700 font-semibold">4.9</span></span>
                            <span class="text-gray-400">Anggota SkillKul</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if($isBusy)
                        <span class="bg-red-100 text-red-700 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">🔴 Sedang Sibuk</span>
                    @else
                        <span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">✓ Tersedia</span>
                    @endif
                    <span class="text-xs text-gray-400">Waktu respons: ~2 jam</span>
                </div>
            </div>

            {{-- Tentang Layanan --}}
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-extrabold text-brand-primary mb-4">Tentang Layanan Ini</h3>
                <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-wrap">{{ $service->description }}</p>
            </div>

            {{-- Ulasan Klien --}}
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-extrabold text-brand-primary mb-4">Ulasan Klien</h3>
                <p class="text-sm text-gray-400 italic">Belum ada ulasan untuk jasa ini.</p>
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">

                {{-- ====== HARGA PAS (non_project) ====== --}}
                @if($service->type === 'non_project')
                <div class="bg-brand-primary rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-200 mb-1">HARGA TETAP</p>
                    <div class="flex items-baseline gap-1 mb-2">
                        <span class="text-3xl font-extrabold">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-indigo-200 text-xs mb-6">Harga sudah tetap. Bayar langsung untuk memulai pesanan.</p>

                    {{-- Form input pesanan langsung --}}
                    <div class="space-y-3 mb-5">
                        <div>
                            <label class="block text-[10px] font-extrabold uppercase tracking-widest text-indigo-200 mb-2">Catatan Pesanan</label>
                            <input type="text" placeholder="Contoh: Fokus pada bagian metodologi..." class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-indigo-300 outline-none focus:border-white/40 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] font-extrabold uppercase tracking-widest text-indigo-200 mb-2">Tautan Google Drive Materi</label>
                            <input type="url" placeholder="https://drive.google.com/..." class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-indigo-300 outline-none focus:border-white/40 transition-colors">
                        </div>
                    </div>

                    @if($isBusy)
                        <button disabled class="block w-full bg-gray-400 text-white font-bold py-3.5 rounded-xl text-center text-sm cursor-not-allowed opacity-70 mb-3">
                            🔒 Freelancer Sedang Sibuk
                        </button>
                        <p class="text-[10px] text-indigo-200 text-center">Freelancer sedang dalam Mode Ujian atau menyelesaikan pesanan lain.</p>
                    @else
                        <form action="{{ route('order.create', $service->id) }}" method="POST">
                            @csrf
                            <button type="submit" id="btn-pesan-langsung" class="block w-full bg-white text-brand-primary font-bold py-3.5 rounded-xl text-center text-sm hover:bg-indigo-50 transition-all shadow-lg mb-3 hover:scale-[1.02]">
                                🛒 Pesan & Bayar Sekarang
                            </button>
                        </form>
                        <p class="text-[10px] text-indigo-200 text-center mb-3">Anda akan diarahkan ke halaman pembayaran Midtrans.</p>
                    @endif

                    <div class="bg-green-400/20 border border-green-400/30 rounded-xl p-3 text-center">
                        <p class="text-[10px] text-green-200 font-semibold leading-relaxed">💚 Pembayaran aman via Midtrans. Dana akan ditahan sampai pesanan diterima.</p>
                    </div>
                </div>

                {{-- ====== HARGA NEGO (project) ====== --}}
                @else
                <div class="bg-brand-primary rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-200 mb-1">HARGA NEGO (PROJECT)</p>

                    {{-- Range Harga --}}
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-2xl font-extrabold">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        @if($service->price_max)
                            <span class="text-indigo-300 font-bold text-lg">–</span>
                            <span class="text-2xl font-extrabold">Rp {{ number_format($service->price_max, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <p class="text-indigo-300 text-[11px] mb-1">Estimasi range harga • Final sesuai kesepakatan</p>

                    {{-- Indikator range visual --}}
                    <div class="relative h-2 bg-white/20 rounded-full mb-5 mt-3">
                        <div class="absolute left-0 top-0 h-2 w-3/5 bg-gradient-to-r from-green-400 to-yellow-400 rounded-full"></div>
                        <div class="absolute left-[55%] -top-1 w-4 h-4 bg-white rounded-full shadow-lg border-2 border-yellow-400 flex items-center justify-center">
                        </div>
                    </div>

                    {{-- Info nego --}}
                    <div class="bg-white/10 rounded-xl p-4 mb-5 space-y-2">
                        <p class="text-[11px] font-bold text-indigo-200 uppercase tracking-wider mb-2">Cara Pemesanan Nego:</p>
                        <div class="flex items-start gap-2 text-xs text-white">
                            <span class="bg-white/20 rounded-full w-5 h-5 flex items-center justify-center shrink-0 font-bold text-[10px]">1</span>
                            <span>Hubungi freelancer via WhatsApp untuk diskusi scope & harga</span>
                        </div>
                        <div class="flex items-start gap-2 text-xs text-white">
                            <span class="bg-white/20 rounded-full w-5 h-5 flex items-center justify-center shrink-0 font-bold text-[10px]">2</span>
                            <span>Freelancer akan mengirimkan tagihan (invoice) custom</span>
                        </div>
                        <div class="flex items-start gap-2 text-xs text-white">
                            <span class="bg-white/20 rounded-full w-5 h-5 flex items-center justify-center shrink-0 font-bold text-[10px]">3</span>
                            <span>Bayar via link invoice yang dikirim freelancer</span>
                        </div>
                    </div>

                    @if($isBusy)
                        <button disabled class="block w-full bg-gray-400 text-white font-bold py-3.5 rounded-xl text-center text-sm cursor-not-allowed opacity-70 mb-3">
                            🔒 Freelancer Sedang Sibuk
                        </button>
                        <p class="text-[10px] text-indigo-200 text-center">Freelancer sedang dalam Mode Ujian atau menyelesaikan pesanan lain.</p>
                    @else
                        @php
                            $waName  = $service->freelancer?->name ?? 'Freelancer';
                            $waPhone = preg_replace('/[^0-9]/', '', $service->freelancer?->phone_number ?? '62');
                            $waText  = 'Halo ' . $waName . ', saya tertarik dengan jasa "' . $service->title . '" di SkillKul. Bisakah kita diskusikan detail proyeknya?';
                        @endphp
                        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}"
                            target="_blank"
                            id="btn-nego-wa"
                            class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-xl text-center text-sm transition-all shadow-lg mb-3 hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Nego via WhatsApp
                        </a>
                        <p class="text-[10px] text-indigo-200 text-center mb-3">Diskusikan scope & harga via WA, lalu freelancer kirim invoice.</p>
                    @endif

                    <div class="bg-green-400/20 border border-green-400/30 rounded-xl p-3 text-center">
                        <p class="text-[10px] text-green-200 font-semibold leading-relaxed">💚 Pembayaran aman via Midtrans. Dana ditahan sampai pesanan diterima.</p>
                    </div>
                </div>
                @endif

                {{-- Info Pengiriman --}}
                <div class="flex gap-4">
                    <div class="flex-1 bg-white rounded-xl p-4 border border-gray-100 text-center shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">⏱ Waktu Pengerjaan</p>
                        <p class="font-bold text-brand-dark text-sm">1 Hari</p>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 border border-gray-100 text-center shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">🔄 Revisi</p>
                        <p class="font-bold text-brand-dark text-sm">Tanpa Batas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
