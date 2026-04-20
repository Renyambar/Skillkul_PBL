@extends('layouts.public')
@section('title', 'Detail Jasa - SkillKul')
@section('content')
@php
    // Dummy data untuk demo UI (nanti diganti data dari controller)
    $service = (object) [
        'id' => 1,
        'title' => 'Penyuntingan & Penyelarasan Akademik Profesional',
        'type' => 'project', // 'non_project' atau 'project'
        'price' => 50000,
        'description' => 'Tingkatkan kualitas penulisan akademik Anda dengan jasa penyelarasan (proofreading) profesional yang disesuaikan dengan standar universitas.',
        'category' => 'Penulisan',
        'is_active' => true,
    ];
    $freelancer = (object) [
        'name' => 'Dr. Elena Rodriguez',
        'phone_number' => '6281234567890',
        'is_exam_mode' => false, // Ubah ke true untuk testing Auto-Busy
        'rating' => 4.9,
        'review_count' => 128,
    ];
    $hasActiveOrder = false; // Ubah ke true untuk testing Auto-Busy
    $isBusy = $freelancer->is_exam_mode || $hasActiveOrder;
@endphp

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-10">
    {{-- Breadcrumb --}}
    <div class="text-xs text-gray-400 font-medium mb-6 flex items-center gap-2">
        <a href="{{ route('katalog') }}" class="hover:text-brand-primary">Pasar Layanan</a>
        <span>›</span>
        <span class="text-gray-600">{{ $service->category }}</span>
        <span>›</span>
        <span class="text-brand-primary font-semibold">{{ Str::limit($service->title, 30) }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Left Content --}}
        <div class="lg:col-span-8 space-y-8">
            {{-- Hero Image --}}
            <div class="relative rounded-3xl overflow-hidden h-72 md:h-96 bg-gradient-to-br from-teal-400 to-cyan-500">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=1200&q=80" class="w-full h-full object-cover mix-blend-overlay opacity-60">
                <div class="absolute bottom-6 left-6">
                    @if($service->type === 'project')
                        <span class="bg-orange-500 text-white text-[10px] font-extrabold px-4 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">Bisa Nego (Project)</span>
                    @else
                        <span class="bg-green-500 text-white text-[10px] font-extrabold px-4 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">Harga Pas</span>
                    @endif
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white mt-3 drop-shadow-lg max-w-lg leading-tight">{{ $service->title }}</h1>
                </div>
            </div>

            {{-- Freelancer Info --}}
            <div class="flex items-center justify-between bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <img src="https://i.pravatar.cc/150?img=32" class="w-12 h-12 rounded-full border-2 border-indigo-100">
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $freelancer->name }}</h4>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="flex items-center gap-1 text-yellow-500">★ <span class="text-gray-700 font-semibold">{{ $freelancer->rating }}</span></span>
                            <span>({{ $freelancer->review_count }} Ulasan)</span>
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
                <p class="text-gray-600 leading-relaxed text-sm mb-6">{{ $service->description }}</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-[#f8f9fc] rounded-xl p-4 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-brand-primary"></div>
                        <span class="text-sm font-semibold text-gray-700">Koreksi Tata Bahasa & Sintaksis</span>
                    </div>
                    <div class="bg-[#f8f9fc] rounded-xl p-4 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-brand-primary"></div>
                        <span class="text-sm font-semibold text-gray-700">Penyesuaian Nada Akademik</span>
                    </div>
                    <div class="bg-[#f8f9fc] rounded-xl p-4 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-brand-primary"></div>
                        <span class="text-sm font-semibold text-gray-700">Konsistensi Referensi</span>
                    </div>
                    <div class="bg-[#f8f9fc] rounded-xl p-4 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-brand-primary"></div>
                        <span class="text-sm font-semibold text-gray-700">Pengiriman Cepat 24 Jam</span>
                    </div>
                </div>
            </div>

            {{-- Ulasan Klien --}}
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-extrabold text-brand-primary">Ulasan Klien</h3>
                    <span class="text-sm font-bold text-gray-400">{{ $freelancer->review_count }} ulasan</span>
                </div>
                <div class="space-y-4">
                    <div class="border border-gray-100 rounded-xl p-5">
                        <div class="flex gap-1 text-yellow-400 mb-3">★★★★★</div>
                        <p class="text-sm text-gray-600 leading-relaxed italic mb-4">"Elena melakukan pekerjaan luar biasa pada disertasi saya. Umpan baliknya sangat konstruktif dan benar-benar meningkatkan alur argumen saya."</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-brand-primary rounded-full flex items-center justify-center text-white text-xs font-bold">BK</div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Budi Kusuma</p>
                                <p class="text-[10px] text-gray-400">• 2 hari yang lalu</p>
                            </div>
                        </div>
                    </div>
                    <div class="border border-gray-100 rounded-xl p-5">
                        <div class="flex gap-1 text-yellow-400 mb-3">★★★★<span class="text-gray-300">★</span></div>
                        <p class="text-sm text-gray-600 leading-relaxed italic mb-4">"Proofreading sangat teliti, hanya sedikit catatan minor. Hasil sangat memuaskan dan tepat waktu."</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold">DP</div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Dewi Puspita</p>
                                <p class="text-[10px] text-gray-400">• 1 minggu yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">
                {{-- Price Card --}}
                <div class="bg-brand-primary rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-200 mb-1">DETAIL HARGA</p>
                    <div class="flex items-baseline gap-1 mb-5">
                        @if($service->type === 'project')
                            <span class="text-xl font-extrabold">Mulai dari</span>
                            <span class="text-3xl font-extrabold">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-3xl font-extrabold">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                            <span class="text-indigo-200 text-sm">/ halaman</span>
                        @endif
                    </div>

                    @if($service->type === 'non_project')
                        {{-- Non-Project: Form checkout langsung --}}
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-indigo-200 mb-2">Catatan Pesanan</label>
                                <input type="text" placeholder="Contoh: Fokus pada bagian metodologi..." class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-indigo-300 outline-none focus:border-white/40 transition-colors">
                            </div>
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-indigo-200 mb-2">Tautan Google Drive Bahan</label>
                                <input type="url" placeholder="https://drive.google.com/..." class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-indigo-300 outline-none focus:border-white/40 transition-colors">
                            </div>
                        </div>

                        @if($isBusy)
                            <button disabled class="block w-full bg-gray-400 text-white font-bold py-3.5 rounded-xl text-center text-sm cursor-not-allowed opacity-70 mb-3">
                                🔒 Freelancer Sedang Sibuk
                            </button>
                            <p class="text-[10px] text-indigo-200 text-center">Freelancer sedang dalam Mode Ujian atau mengerjakan pesanan lain.</p>
                        @else
                            <a href="{{ route('checkout', 1) }}" class="block w-full bg-white text-brand-primary font-bold py-3.5 rounded-xl text-center text-sm hover:bg-indigo-50 transition-colors shadow-lg mb-3">
                                🛒 Pesan Langsung
                            </a>
                        @endif
                    @else
                        {{-- Project: Nego via WA --}}
                        @if($isBusy)
                            <button disabled class="block w-full bg-gray-400 text-white font-bold py-3.5 rounded-xl text-center text-sm cursor-not-allowed opacity-70 mb-3">
                                🔒 Freelancer Sedang Sibuk
                            </button>
                        @else
                            <a href="https://wa.me/{{ $freelancer->phone_number }}?text={{ urlencode('Halo ' . $freelancer->name . ', saya tertarik dengan jasa "' . $service->title . '" Anda di SkillKul. Bisakah kita diskusikan detail proyeknya?') }}"
                                target="_blank"
                                class="block w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-xl text-center text-sm transition-colors shadow-lg mb-3">
                                💬 Nego via WhatsApp
                            </a>
                            <p class="text-[10px] text-indigo-200 text-center mb-3">Diskusikan scope & harga via WA, lalu freelancer akan mengirim tagihan.</p>
                        @endif
                    @endif

                    <div class="bg-green-400/20 border border-green-400/30 rounded-xl p-3 text-center">
                        <p class="text-[10px] text-green-200 font-semibold leading-relaxed">💚 Pembayaran aman via Midtrans. Dana akan ditahan sampai pesanan diterima.</p>
                    </div>
                </div>

                {{-- Info Pengiriman --}}
                <div class="flex gap-4">
                    <div class="flex-1 bg-white rounded-xl p-4 border border-gray-100 text-center shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">⏱ Pengiriman</p>
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
