@extends('layouts.public')
@section('title', $service->title . ' - SkillKul')
@section('content')

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-10 transition-colors duration-300">
    {{-- Breadcrumb --}}
    <div class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-8 flex items-center gap-2">
        <a href="{{ route('katalog') }}" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Pasar Layanan</a>
        <span class="text-gray-400 dark:text-gray-600">›</span>
        <span class="text-gray-600 dark:text-gray-300">{{ $service->category?->name ?? '–' }}</span>
        <span class="text-gray-400 dark:text-gray-600">›</span>
        <span class="text-brand-primary dark:text-indigo-400 font-semibold truncate max-w-[150px] sm:max-w-xs">{{ Str::limit($service->title, 30) }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Left Content --}}
        <div class="lg:col-span-8 space-y-8">
            {{-- Hero Image --}}
            <div class="relative rounded-3xl overflow-hidden h-72 md:h-[400px] bg-gradient-to-br from-indigo-500 to-purple-600 dark:from-indigo-900 dark:to-purple-900 shadow-xl group">
                @if($service->image)
                    <img src="{{ Storage::url($service->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $service->title }}">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-teal-400 to-cyan-500 dark:from-teal-800 dark:to-cyan-900 flex items-center justify-center">
                        <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                <div class="absolute bottom-8 left-8 right-8">
                    @if($service->type === 'project')
                        <span class="inline-block bg-orange-500/90 text-white text-[10px] font-extrabold px-4 py-1.5 rounded-lg uppercase tracking-widest shadow-lg backdrop-blur-sm border border-orange-400/50 mb-4">Harga Negosiasi (Proyek)</span>
                    @else
                        <span class="inline-block bg-green-500/90 text-white text-[10px] font-extrabold px-4 py-1.5 rounded-lg uppercase tracking-widest shadow-lg backdrop-blur-sm border border-green-400/50 mb-4">Harga Tetap — Langsung Bayar</span>
                    @endif
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white drop-shadow-lg max-w-2xl leading-tight">{{ $service->title }}</h1>
                </div>
            </div>

            {{-- Pekerja Lepas Info --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-white dark:bg-brand-darksurface rounded-3xl p-6 border border-gray-100 dark:border-brand-darkborder shadow-sm gap-4">
                <div class="flex items-center gap-5">
                    @if($service->freelancer?->profile_photo_path)
                        <img src="{{ Storage::url($service->freelancer->profile_photo_path) }}"
                             class="w-14 h-14 rounded-full object-cover ring-4 ring-indigo-50 dark:ring-indigo-900/30">
                    @else
                        <div class="w-14 h-14 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 font-extrabold text-xl flex items-center justify-center ring-4 ring-indigo-50 dark:ring-indigo-900/30">
                            {{ strtoupper(substr($service->freelancer?->name ?? '?', 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white">{{ $service->freelancer?->name ?? 'Pekerja Lepas' }}</h4>
                        <div class="flex items-center gap-3 text-sm mt-1">
                            <span class="flex items-center gap-1 text-yellow-500 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-0.5 rounded-md font-medium">
                                ★ <span class="text-gray-800 dark:text-gray-200 font-bold">4.9</span>
                            </span>
                            <span class="text-gray-400 dark:text-gray-500 text-xs">Anggota SkillKul</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:items-end gap-2">
                    @if($isBusy)
                        <span class="inline-flex items-center bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-xs font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider border border-red-100 dark:border-red-800/50">
                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span> Sedang Sibuk
                        </span>
                    @else
                        <span class="inline-flex items-center bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-xs font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider border border-green-100 dark:border-green-800/50">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Tersedia
                        </span>
                    @endif
                    <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Waktu respons: ±2 jam</span>
                </div>
            </div>

            {{-- Tentang Layanan --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-8 border border-gray-100 dark:border-brand-darkborder shadow-sm">
                <h3 class="text-xl font-extrabold text-brand-dark dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-primary dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tentang Layanan Ini
                </h3>
                <div class="prose prose-sm md:prose-base dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-wrap font-medium">
                    {{ $service->description }}
                </div>
            </div>

            {{-- Ulasan Klien --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-8 border border-gray-100 dark:border-brand-darkborder shadow-sm">
                <h3 class="text-xl font-extrabold text-brand-dark dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    Ulasan Klien
                </h3>
                
                <div class="flex flex-col items-center justify-center py-10 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50 border-dashed">
                    <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm flex items-center justify-center mb-4">
                        <span class="text-2xl">💬</span>
                    </div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400">Belum ada ulasan untuk layanan ini.</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Jadilah yang pertama memesan dan memberikan ulasan!</p>
                </div>
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div class="lg:col-span-4">
            <div class="sticky top-28 space-y-6">

                {{-- ====== HARGA PAS (non_project) ====== --}}
                @if($service->type === 'non_project')
                <div class="bg-brand-primary dark:bg-brand-dark rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 dark:bg-indigo-500/20 rounded-full blur-[40px]"></div>
                    
                    <div class="relative z-10">
                        <span class="inline-block bg-white/20 dark:bg-gray-800/60 text-white text-[10px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full mb-4 border border-white/10 dark:border-gray-700">HARGA TETAP</span>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="text-3xl font-black tracking-tight">Rp{{ number_format($service->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-indigo-100 dark:text-gray-300 text-sm mb-8 font-medium">Harga sudah tetap. Lakukan pembayaran langsung untuk memulai pesanan.</p>

                        {{-- Form input pesanan langsung --}}
                        <div class="space-y-4 mb-8">
                            <div>
                                <label class="block text-[11px] font-extrabold uppercase tracking-widest text-indigo-200 dark:text-indigo-300 mb-2">Catatan Pesanan <span class="text-red-400">*</span></label>
                                <textarea rows="3" placeholder="Jelaskan kebutuhan spesifik Anda..." class="w-full bg-white/10 dark:bg-black/20 border border-white/20 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-indigo-300/70 dark:placeholder-gray-500 outline-none focus:border-white/50 focus:ring-1 focus:ring-white/50 transition-all resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-extrabold uppercase tracking-widest text-indigo-200 dark:text-indigo-300 mb-2">Tautan Materi (Opsional)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-indigo-300/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    </div>
                                    <input type="url" placeholder="https://drive.google.com/..." class="w-full bg-white/10 dark:bg-black/20 border border-white/20 dark:border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-indigo-300/70 dark:placeholder-gray-500 outline-none focus:border-white/50 focus:ring-1 focus:ring-white/50 transition-all">
                                </div>
                            </div>
                        </div>

                        @if($isBusy)
                            <button disabled class="block w-full bg-gray-500/50 text-white font-bold py-4 rounded-xl text-center text-sm cursor-not-allowed border border-white/10 mb-4 backdrop-blur-sm">
                                Pekerja Lepas Sedang Sibuk
                            </button>
                            <p class="text-[11px] text-indigo-200 dark:text-gray-400 text-center leading-relaxed">Pekerja lepas (freelancer) sedang dalam masa ujian atau sedang menyelesaikan pesanan lain. Harap kembali lagi nanti.</p>
                        @else
                            <form action="{{ route('order.create', $service->id) }}" method="POST">
                                @csrf
                                <button type="submit" id="btn-pesan-langsung" class="block w-full bg-white dark:bg-indigo-500 text-brand-primary dark:text-white font-extrabold py-4 rounded-xl text-center text-sm hover:bg-indigo-50 dark:hover:bg-indigo-400 transition-all shadow-xl shadow-black/10 mb-4 hover:translate-y-[-2px]">
                                    Pesan & Bayar Sekarang
                                </button>
                            </form>
                            <p class="text-[11px] text-indigo-200 dark:text-gray-400 text-center font-medium mb-4">Anda akan diarahkan ke halaman pembayaran Midtrans.</p>
                        @endif

                        <div class="mt-6 bg-green-400/20 dark:bg-green-900/30 border border-green-400/30 dark:border-green-800/50 rounded-xl p-4 flex items-start gap-3 backdrop-blur-sm">
                            <span class="text-xl"></span>
                            <p class="text-xs text-green-100 dark:text-green-300 font-medium leading-relaxed">Pembayaran aman melalui sistem rekening bersama (escrow). Dana akan ditahan hingga Anda menyetujui hasil pekerjaan.</p>
                        </div>
                    </div>
                </div>

                {{-- ====== HARGA NEGO (project) ====== --}}
                @else
                <div class="bg-brand-primary dark:bg-brand-dark rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 dark:bg-orange-500/10 rounded-full blur-[40px]"></div>
                    
                    <div class="relative z-10">
                        <span class="inline-block bg-white/20 dark:bg-gray-800/60 text-white text-[10px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full mb-4 border border-white/10 dark:border-gray-700">HARGA NEGOSIASI (PROYEK)</span>

                        {{-- Range Harga --}}
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="text-3xl font-black tracking-tight">Rp{{ number_format($service->price, 0, ',', '.') }}</span>
                            @if($service->price_max)
                                <span class="text-indigo-300 font-bold text-xl">–</span>
                                <span class="text-3xl font-black tracking-tight">Rp{{ number_format($service->price_max, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <p class="text-indigo-200 dark:text-gray-300 text-sm mb-6 font-medium">Estimasi rentang harga • Nilai akhir sesuai kesepakatan</p>

                        {{-- Indikator range visual --}}
                        <div class="relative h-2.5 bg-white/20 dark:bg-gray-800 rounded-full mb-8">
                            <div class="absolute left-0 top-0 h-2.5 w-3/5 bg-gradient-to-r from-green-400 to-yellow-400 dark:from-green-500 dark:to-orange-500 rounded-full"></div>
                            <div class="absolute left-[55%] -top-1.5 w-5 h-5 bg-white rounded-full shadow-md border-[3px] border-yellow-400 dark:border-orange-500">
                            </div>
                        </div>

                        {{-- Info nego --}}
                        <div class="bg-white/10 dark:bg-black/20 border border-white/10 dark:border-white/5 rounded-2xl p-5 mb-8 backdrop-blur-sm">
                            <p class="text-[11px] font-extrabold text-indigo-200 dark:text-indigo-300 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Alur Pemesanan
                            </p>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <span class="bg-brand-secondary dark:bg-indigo-600 rounded-full w-6 h-6 flex items-center justify-center shrink-0 font-bold text-xs shadow-sm">1</span>
                                    <span class="text-sm text-indigo-50 dark:text-gray-300 font-medium leading-tight pt-0.5">Hubungi pekerja lepas (freelancer) melalui WhatsApp untuk mendiskusikan cakupan (scope) dan harga</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="bg-brand-secondary dark:bg-indigo-600 rounded-full w-6 h-6 flex items-center justify-center shrink-0 font-bold text-xs shadow-sm">2</span>
                                    <span class="text-sm text-indigo-50 dark:text-gray-300 font-medium leading-tight pt-0.5">Pekerja lepas (freelancer) akan mengirimkan faktur (invoice) khusus</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="bg-brand-secondary dark:bg-indigo-600 rounded-full w-6 h-6 flex items-center justify-center shrink-0 font-bold text-xs shadow-sm">3</span>
                                    <span class="text-sm text-indigo-50 dark:text-gray-300 font-medium leading-tight pt-0.5">Bayar melalui tautan faktur yang dikirim pekerja lepas (freelancer)</span>
                                </div>
                            </div>
                        </div>

                        @if($isBusy)
                            <button disabled class="block w-full bg-gray-500/50 text-white font-bold py-4 rounded-xl text-center text-sm cursor-not-allowed border border-white/10 mb-4 backdrop-blur-sm">
                                Pekerja Lepas (Freelancer) Sedang Sibuk
                            </button>
                            <p class="text-[11px] text-indigo-200 dark:text-gray-400 text-center leading-relaxed">Pekerja lepas (freelancer) sedang dalam Mode Ujian atau menyelesaikan pesanan lain.</p>
                        @else
                            @php
                                $waName  = $service->freelancer?->name ?? 'Pekerja Lepas';
                                $waPhone = preg_replace('/[^0-9]/', '', $service->freelancer?->phone_number ?? '62');
                                $waText  = 'Halo ' . $waName . ', saya tertarik dengan layanan "' . $service->title . '" di SkillKul. Bisakah kita diskusikan detail proyeknya?';
                            @endphp
                            <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}"
                                target="_blank"
                                id="btn-nego-wa"
                                class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-400 dark:bg-green-600 dark:hover:bg-green-500 text-white font-extrabold py-4 rounded-xl text-center text-sm transition-all shadow-lg shadow-green-500/30 mb-4 hover:translate-y-[-2px]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                Negosiasi melalui WhatsApp
                            </a>
                            <p class="text-[11px] text-indigo-200 dark:text-gray-400 text-center mb-4">Diskusikan cakupan kerja dan harga, lalu minta tautan pembayaran resmi.</p>
                        @endif

                        <div class="mt-2 bg-green-400/20 dark:bg-green-900/30 border border-green-400/30 dark:border-green-800/50 rounded-xl p-4 flex items-start gap-3 backdrop-blur-sm">
                            <span class="text-xl"></span>
                            <p class="text-xs text-green-100 dark:text-green-300 font-medium leading-relaxed">Pembayaran aman melalui sistem rekening bersama (escrow). Dana akan ditahan hingga Anda menyetujui hasil pekerjaan.</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Info Pengiriman --}}
                <div class="flex gap-4">
                    <div class="flex-1 bg-white dark:bg-brand-darksurface rounded-2xl p-5 border border-gray-100 dark:border-brand-darkborder text-center shadow-sm">
                        <p class="text-2xl mb-2"></p>
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1">Waktu Pengerjaan</p>
                        <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $service->estimated_label }}</p>
                    </div>
                    <div class="flex-1 bg-white dark:bg-brand-darksurface rounded-2xl p-5 border border-gray-100 dark:border-brand-darkborder text-center shadow-sm">
                        <p class="text-2xl mb-2"></p>
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1">Batas Revisi</p>
                        <p class="font-bold text-gray-900 dark:text-white text-sm">Kesepakatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
