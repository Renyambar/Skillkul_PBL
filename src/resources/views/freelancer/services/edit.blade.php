@extends('layouts.freelancer')
@section('title', 'Edit Jasa - SkillKul')
@section('content')
<div class="p-8 lg:p-10">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
            <a href="{{ route('freelancer.jasa.index') }}" class="hover:text-brand-primary transition-colors font-semibold">Layanan Saya</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 font-semibold">Edit Jasa</span>
        </div>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-brand-primary tracking-widest uppercase mb-3">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            EDIT LAYANAN
        </span>
        <h1 class="text-3xl font-extrabold text-brand-dark tracking-tight mb-2">Edit Jasa</h1>
        <p class="text-gray-500 text-sm max-w-2xl">Perbarui detail layanan Anda agar tetap relevan dan menarik bagi calon klien.</p>
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
            <form action="{{ route('freelancer.jasa.update', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-7">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Judul Jasa</label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}"
                           placeholder="Contoh: Pembuatan Dashboard Analitik Data Excel"
                           class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-brand-primary focus:ring-2 focus:ring-indigo-100 rounded-xl px-4 py-3.5 text-sm font-medium text-gray-900 transition-all outline-none">
                    <p class="text-[10px] text-gray-400 mt-2">Gunakan judul yang jelas dan spesifik agar mudah ditemukan.</p>
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Kategori</label>
                    <div class="relative">
                        <select name="category_id" class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-brand-primary rounded-xl px-4 py-3.5 text-sm font-medium text-gray-700 outline-none appearance-none cursor-pointer">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                {{-- Business Model --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <label class="text-base font-bold text-brand-dark">Model Bisnis & Harga</label>
                    </div>
                    <div class="grid grid-cols-2 gap-4" id="type-selector">
                        <label class="cursor-pointer border-2 rounded-2xl p-5 transition-all {{ old('type', $service->type) === 'non_project' ? 'border-brand-primary bg-indigo-50/50' : 'border-gray-100 bg-gray-50/50 hover:border-gray-300' }}" data-type="non_project">
                            <input type="radio" name="type" value="non_project" class="sr-only" {{ old('type', $service->type) === 'non_project' ? 'checked' : '' }}>
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-xs font-black tracking-widest uppercase {{ old('type', $service->type) === 'non_project' ? 'text-brand-primary' : 'text-gray-700' }}">Non-Project</span>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center {{ old('type', $service->type) === 'non_project' ? 'border-brand-primary bg-brand-primary' : 'border-gray-300 bg-white' }}">
                                    @if(old('type', $service->type) === 'non_project')
                                        <div class="w-2 h-2 rounded-full bg-white"></div>
                                    @endif
                                </div>
                            </div>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Layanan dengan harga pasti. Cocok untuk jasa standar.</p>
                        </label>
                        <label class="cursor-pointer border-2 rounded-2xl p-5 transition-all {{ old('type', $service->type) === 'project' ? 'border-brand-primary bg-indigo-50/50' : 'border-gray-100 bg-gray-50/50 hover:border-gray-300' }}" data-type="project">
                            <input type="radio" name="type" value="project" class="sr-only" {{ old('type', $service->type) === 'project' ? 'checked' : '' }}>
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-xs font-black tracking-widest uppercase {{ old('type', $service->type) === 'project' ? 'text-brand-primary' : 'text-gray-700' }}">Project Based</span>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center {{ old('type', $service->type) === 'project' ? 'border-brand-primary bg-brand-primary' : 'border-gray-300 bg-white' }}">
                                    @if(old('type', $service->type) === 'project')
                                        <div class="w-2 h-2 rounded-full bg-white"></div>
                                    @endif
                                </div>
                            </div>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Nego via WhatsApp. Untuk pekerjaan kompleks.</p>
                        </label>
                    </div>
                </div>

                {{-- Price --}}
                <div class="bg-green-50 border border-green-100 rounded-2xl p-6">
                    <label class="block text-sm font-bold text-gray-900 mb-3">Harga Jasa (IDR)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-green-700">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $service->price) }}"
                               class="w-full bg-white border border-transparent rounded-xl pl-12 pr-4 py-3.5 text-base font-bold text-gray-900 shadow-sm focus:border-green-400 focus:ring-2 focus:ring-green-100 outline-none">
                    </div>
                    <div id="price-max-container" class="{{ old('type', $service->type) === 'project' ? '' : 'hidden' }} mt-4">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Harga Maksimal (IDR)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-green-700">Rp</span>
                            <input type="number" name="price_max" value="{{ old('price_max', $service->price_max) }}"
                                   class="w-full bg-white border border-transparent rounded-xl pl-12 pr-4 py-3.5 text-base font-bold text-gray-900 shadow-sm focus:border-green-400 focus:ring-2 focus:ring-green-100 outline-none">
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-green-700 mt-3 flex items-center gap-1.5 opacity-80">ℹ️ Harga ini bersifat final dan akan langsung dibayarkan oleh klien melalui sistem SkillKul.</p>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Deskripsi Layanan</label>
                    <textarea name="description" rows="5"
                              placeholder="Jelaskan detail apa yang akan didapatkan klien, workflow kerja, dan tools yang digunakan..."
                              class="w-full bg-gray-100 border border-transparent focus:bg-white focus:border-brand-primary focus:ring-2 focus:ring-indigo-100 rounded-xl px-5 py-4 text-sm font-medium text-gray-700 transition-all outline-none resize-none">{{ old('description', $service->description) }}</textarea>
                </div>

                {{-- Upload Gambar --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Gambar Jasa</label>
                    @if($service->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($service->image) }}" class="w-32 h-24 object-cover rounded-xl border border-gray-200">
                            <p class="text-[10px] text-gray-400 mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/webp"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                    <p class="text-[10px] text-gray-400 mt-2">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</p>
                </div>

                {{-- Action --}}
                <div class="flex justify-end items-center gap-4 pt-4">
                    <a href="{{ route('freelancer.jasa.index') }}" class="text-sm font-bold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors">Batal</a>
                    <button type="submit" class="bg-[#0b0c54] text-white px-8 py-3.5 rounded-xl text-sm font-bold shadow-lg hover:bg-brand-dark transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        {{-- Right Cards --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Info Jasa --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h4 class="text-[10px] font-extrabold tracking-widest text-gray-400 uppercase mb-4">INFO JASA</h4>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Status</p>
                        @if($service->is_active)
                            <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider mt-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-600 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider mt-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>Nonaktif
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Dibuat</p>
                        <p class="text-sm text-gray-700 font-semibold mt-0.5">{{ $service->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Diperbarui</p>
                        <p class="text-sm text-gray-700 font-semibold mt-0.5">{{ $service->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h4 class="text-[10px] font-extrabold tracking-widest text-gray-900 uppercase mb-4">TIPS SUKSES</h4>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="text-green-500 mt-0.5">✓</span>
                        <div>
                            <p class="text-xs font-bold text-gray-900">Upload Portofolio</p>
                            <p class="text-[10px] text-gray-500 leading-relaxed">Jasa dengan gambar portofolio asli memiliki konversi 3x lebih tinggi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-green-500 mt-0.5">✓</span>
                        <div>
                            <p class="text-xs font-bold text-gray-900">Deskripsi Detail</p>
                            <p class="text-[10px] text-gray-500 leading-relaxed">Jelaskan proses kerja, tools, dan output yang klien dapatkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle price_max visibility based on type selection
    document.querySelectorAll('#type-selector input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const maxContainer = document.getElementById('price-max-container');
            if (this.value === 'project') {
                maxContainer.classList.remove('hidden');
            } else {
                maxContainer.classList.add('hidden');
            }
        });
    });
</script>
@endsection
