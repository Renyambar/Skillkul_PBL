@extends('layouts.admin')
@section('title', 'Admin - Tambah Jasa')

@section('content')
<div class="p-8 lg:p-10">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.services.index') }}" class="hover:text-brand-primary transition-colors font-semibold">Katalog Jasa</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-semibold">Tambah Jasa Baru</span>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight mb-1">Tambah Jasa Baru</h1>
        <p class="text-sm text-gray-500 mb-8">Isi data jasa yang akan ditampilkan di katalog platform.</p>

        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            {{-- Freelancer --}}
            <div>
                <label for="freelancer_id" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                    Freelancer <span class="text-red-500">*</span>
                </label>
                <select name="freelancer_id" id="freelancer_id" required
                        class="w-full px-4 py-3 text-sm border @error('freelancer_id') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors bg-white">
                    <option value="">— Pilih Freelancer —</option>
                    {{-- Ambil semua user dengan role freelancer --}}
                    @foreach(\App\Models\User::where('role', 'freelancer')->orderBy('name')->get() as $user)
                        <option value="{{ $user->id }}" {{ old('freelancer_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('freelancer_id')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul --}}
            <div>
                <label for="title" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                    Judul Jasa <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       placeholder="Contoh: Desain Logo Profesional"
                       maxlength="150" required
                       class="w-full px-4 py-3 text-sm border @error('title') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors">
                @error('title')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori & Tipe --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="category_id" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                            class="w-full px-4 py-3 text-sm border @error('category_id') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors bg-white">
                        <option value="">— Pilih —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="type" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                            class="w-full px-4 py-3 text-sm border @error('type') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors bg-white">
                        <option value="non_project" {{ old('type') === 'non_project' ? 'selected' : '' }}>Non-Project</option>
                        <option value="project"     {{ old('type') === 'project'     ? 'selected' : '' }}>Project</option>
                    </select>
                    @error('type')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Harga --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                        Harga Min / Tetap (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-semibold">Rp</span>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                               min="0" step="1000" required
                               class="w-full pl-10 pr-4 py-3 text-sm border @error('price') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors">
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div id="price-max-wrapper">
                    <label for="price_max" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                        Harga Maks (Rp) <span class="text-gray-400 font-normal normal-case">(opsional, project)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-semibold">Rp</span>
                        <input type="number" name="price_max" id="price_max" value="{{ old('price_max') }}"
                               min="0" step="1000"
                               class="w-full pl-10 pr-4 py-3 text-sm border @error('price_max') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors">
                    </div>
                    @error('price_max')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea name="description" id="description" rows="5" required
                          placeholder="Jelaskan detail jasa yang ditawarkan, termasuk apa yang akan diterima klien…"
                          class="w-full px-4 py-3 text-sm border @error('description') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar --}}
            <div>
                <label for="image" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                    Gambar Cover <span class="text-gray-400 font-normal normal-case">(JPG/PNG/WebP, maks. 2MB)</span>
                </label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-brand-primary transition-colors cursor-pointer"
                     onclick="document.getElementById('image').click()">
                    <input type="file" name="image" id="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                    <div id="image-placeholder">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk unggah gambar</p>
                    </div>
                    <img id="image-preview" src="" alt="Preview" class="hidden mx-auto max-h-40 rounded-xl object-cover">
                </div>
                @error('image')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-3">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="sr-only peer"
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                </label>
                <div>
                    <p class="text-sm font-bold text-gray-700">Aktifkan jasa</p>
                    <p class="text-xs text-gray-400">Jasa langsung tampil di katalog publik</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" id="submit-btn"
                        class="bg-brand-primary text-white font-bold text-sm px-8 py-3 rounded-xl hover:bg-brand-dark transition-colors shadow-lg shadow-indigo-200">
                    Simpan Jasa
                </button>
                <a href="{{ route('admin.services.index') }}"
                   class="text-gray-500 font-semibold text-sm px-4 py-3 rounded-xl hover:bg-gray-100 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
