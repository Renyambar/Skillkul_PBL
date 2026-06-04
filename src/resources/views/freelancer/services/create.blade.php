@extends('layouts.freelancer')
@section('title', 'Buka Jasa Baru - SkillKul')
@section('content')
    <div class="p-8 lg:p-10">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
                <a href="{{ route('freelancer.jasa.index') }}"
                    class="hover:text-brand-primary transition-colors font-semibold">Layanan Saya</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 font-semibold">Buka Jasa Baru</span>
            </div>
            <span
                class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-brand-primary tracking-widest uppercase mb-3">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                MODUL PUBLISHER
            </span>
            <h1 class="text-3xl font-extrabold text-brand-dark tracking-tight mb-2">Buka Jasa Baru</h1>
            <p class="text-gray-500 text-sm max-w-2xl">Transformasikan keahlian akademikmu menjadi layanan profesional yang
                siap dipesan oleh klien.</p>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-5 py-3 rounded-xl mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-12 gap-8">
            {{-- Form --}}
            <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <form action="{{ route('freelancer.jasa.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-7">
                    @csrf

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Judul Jasa</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            placeholder="Contoh: Pembuatan Dashboard Analitik Data Excel"
                            class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-brand-primary focus:ring-2 focus:ring-indigo-100 rounded-xl px-4 py-3.5 text-sm font-medium text-gray-900 transition-all outline-none">
                        <p class="text-[10px] text-gray-400 mt-2">Gunakan judul yang jelas dan spesifik agar mudah
                            ditemukan.</p>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Kategori</label>
                        <div class="relative">
                            <select name="category_id"
                                class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-brand-primary rounded-xl px-4 py-3.5 text-sm font-medium text-gray-700 outline-none appearance-none cursor-pointer custom-select">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="w-4 h-4 text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- Business Model --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <label class="text-base font-bold text-brand-dark">Model Bisnis & Harga</label>
                        </div>
                        <div class="grid grid-cols-2 gap-4" id="type-selector">
                            <label class="cursor-pointer border-2 rounded-2xl p-5 transition-all" data-type="non_project">
                                <input type="radio" name="type" value="non_project" class="sr-only" {{ old('type', 'non_project') === 'non_project' ? 'checked' : '' }}>
                                <div class="flex justify-between items-start mb-1">
                                    <span class="type-label text-xs font-black tracking-widest uppercase">Non-Project</span>
                                    <div class="radio-dot w-5 h-5 rounded-full border-2 flex items-center justify-center">
                                    </div>
                                </div>
                                <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Layanan dengan harga pasti.
                                    Cocok untuk jasa standar.</p>
                            </label>
                            <label class="cursor-pointer border-2 rounded-2xl p-5 transition-all" data-type="project">
                                <input type="radio" name="type" value="project" class="sr-only" {{ old('type') === 'project' ? 'checked' : '' }}>
                                <div class="flex justify-between items-start mb-1">
                                    <span class="type-label text-xs font-black tracking-widest uppercase">Project
                                        Based</span>
                                    <div class="radio-dot w-5 h-5 rounded-full border-2 flex items-center justify-center">
                                    </div>
                                </div>
                                <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Nego via WhatsApp. Untuk
                                    pekerjaan kompleks.</p>
                            </label>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="bg-green-50 border border-green-100 rounded-2xl p-6">
                        <label class="block text-sm font-bold text-gray-900 mb-3">Harga Jasa (IDR)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-green-700">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" placeholder="150000"
                                class="w-full bg-white border border-transparent rounded-xl pl-12 pr-4 py-3.5 text-base font-bold text-gray-900 shadow-sm focus:border-green-400 focus:ring-2 focus:ring-green-100 outline-none">
                        </div>
                        <div id="price-max-container" class="{{ old('type') === 'project' ? '' : 'hidden' }} mt-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Harga Maksimal (IDR)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-green-700">Rp</span>
                                <input type="number" name="price_max" value="{{ old('price_max') }}" placeholder="500000"
                                    class="w-full bg-white border border-transparent rounded-xl pl-12 pr-4 py-3.5 text-base font-bold text-gray-900 shadow-sm focus:border-green-400 focus:ring-2 focus:ring-green-100 outline-none">
                            </div>
                        </div>
                        <p class="text-[10px] font-bold text-green-700 mt-3 flex items-center gap-1.5 opacity-80">ℹ️ Harga
                            ini bersifat final dan akan langsung dibayarkan oleh klien melalui sistem SkillKul.</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Deskripsi Layanan</label>
                        <textarea name="description" rows="5"
                            placeholder="Jelaskan detail apa yang akan didapatkan klien, workflow kerja, dan tools yang digunakan..."
                            class="w-full bg-gray-100 border border-transparent focus:bg-white focus:border-brand-primary focus:ring-2 focus:ring-indigo-100 rounded-xl px-5 py-4 text-sm font-medium text-gray-700 transition-all outline-none resize-none">{{ old('description') }}</textarea>
                    </div>

                    {{-- Upload Gambar --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Gambar Jasa (Opsional)</label>
                        <input type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/webp"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                        <p class="text-[10px] text-gray-400 mt-2">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</p>
                    </div>

                    {{-- Estimasi Pengerjaan --}}
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <label class="text-sm font-bold text-gray-900">Estimasi Waktu Pengerjaan</label>
                        </div>
                        <div class="relative">
                            <select name="estimated_days"
                                    class="w-full bg-white border border-blue-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none appearance-none cursor-pointer">
                                <option value="">Sesuai Kesepakatan</option>
                                @foreach([1 => '1 Hari', 2 => '2 Hari', 3 => '3 Hari', 5 => '5 Hari', 7 => '7 Hari (1 Minggu)', 14 => '14 Hari (2 Minggu)', 30 => '30 Hari (1 Bulan)'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('estimated_days') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <svg class="w-4 h-4 text-blue-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                        <p class="text-[10px] font-semibold text-blue-600 mt-2 leading-relaxed">
                            ⏱ Deadline order akan otomatis dihitung dari tanggal pembayaran + estimasi ini. Jika kosong, deadline tidak di-set otomatis.
                        </p>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4">
                        <a href="{{ route('freelancer.jasa.index') }}"
                            class="text-sm font-bold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-[#0b0c54] text-white px-8 py-3.5 rounded-xl text-sm font-bold shadow-lg hover:bg-brand-dark transition-all">Terbitkan
                            Jasa</button>
                    </div>
                </form>
            </div>

            {{-- Right Cards --}}
            <div class="lg:col-span-4 space-y-6">
                <div
                    class="bg-gradient-to-br from-[#2a0e88] to-[#160655] rounded-2xl p-7 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    <span
                        class="inline-block bg-white/10 px-3 py-1 rounded-full text-[9px] font-extrabold tracking-widest uppercase mb-4 border border-white/10">Fitur
                        Asisten</span>
                    <h3 class="text-xl font-bold mb-3">Auto-Portfolio Helper</h3>
                    <p class="text-indigo-200 text-[11px] leading-relaxed mb-8">Sistem kami akan membantu memoles deskripsi jasa
                        Anda agar terlihat lebih profesional di mata klien korporat.</p>
                    <button
                        class="w-full bg-white text-[#2a0e88] font-bold py-3 rounded-xl text-xs flex justify-center items-center gap-2 hover:bg-indigo-50 transition-colors shadow-lg">⚡
                        Optimalkan Deskripsi Jasa</button>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-[10px] font-extrabold tracking-widest text-gray-900 uppercase mb-4">TIPS SUKSES</h4>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Unggah Portofolio</p>
                                <p class="text-[10px] text-gray-500 leading-relaxed">Jasa dengan gambar portofolio asli
                                    memiliki konversi 3x lebih tinggi.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Tanggapan Cepat</p>
                                <p class="text-[10px] text-gray-500 leading-relaxed">Pastikan nomor WA aktif untuk tipe
                                    Project Based.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <h4 class="text-[10px] font-extrabold tracking-widest text-gray-400 uppercase mb-3">PRATINJAU KARTU</h4>
                    <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=400&q=80"
                            class="w-full h-28 object-cover">
                        <div class="p-4 space-y-2">
                            <div class="w-3/4 h-3 bg-gray-200 rounded"></div>
                            <div class="w-1/2 h-2.5 bg-gray-200 rounded"></div>
                            <div class="flex justify-between items-center pt-2">
                                <div class="w-16 h-4 bg-green-200 rounded"></div>
                                <div class="w-10 h-3 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('#type-selector input[name="type"]');
            const maxContainer = document.getElementById('price-max-container');

            /**
             * Update tampilan visual radio label (border, bg, indicator dot)
             * dan toggle visibility field harga maksimal.
             */
            function updateTypeUI() {
                radios.forEach(radio => {
                    const label = radio.closest('label');
                    const indicator = label.querySelector('.radio-dot');
                    const typeLabel = label.querySelector('.type-label');

                    if (radio.checked) {
                        // State: Aktif
                        label.classList.remove('border-gray-100', 'bg-gray-50/50');
                        label.classList.add('border-brand-primary', 'bg-indigo-50/50', 'shadow-sm');
                        if (indicator) {
                            indicator.classList.remove('border-gray-300', 'bg-white');
                            indicator.classList.add('border-brand-primary', 'bg-brand-primary');
                            indicator.innerHTML = '<div class="w-2 h-2 rounded-full bg-white"></div>';
                        }
                        if (typeLabel) {
                            typeLabel.classList.remove('text-gray-700');
                            typeLabel.classList.add('text-brand-primary');
                        }
                    } else {
                        // State: Tidak aktif
                        label.classList.remove('border-brand-primary', 'bg-indigo-50/50', 'shadow-sm');
                        label.classList.add('border-gray-100', 'bg-gray-50/50');
                        if (indicator) {
                            indicator.classList.remove('border-brand-primary', 'bg-brand-primary');
                            indicator.classList.add('border-gray-300', 'bg-white');
                            indicator.innerHTML = '';
                        }
                        if (typeLabel) {
                            typeLabel.classList.remove('text-brand-primary');
                            typeLabel.classList.add('text-gray-700');
                        }
                    }
                });

                // Toggle field harga maksimal (hanya tampil untuk Project Based)
                const checkedRadio = document.querySelector('#type-selector input[name="type"]:checked');
                if (checkedRadio && checkedRadio.value === 'project') {
                    maxContainer.classList.remove('hidden');
                } else {
                    maxContainer.classList.add('hidden');
                }
            }

            // Pasang event listener dan jalankan sekali saat halaman dimuat
            radios.forEach(radio => radio.addEventListener('change', updateTypeUI));
            updateTypeUI();
        });
    </script>
@endsection