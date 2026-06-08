@extends('layouts.admin')
@section('title', 'Admin - Edit Jasa')

@section('content')
<div class="p-8 lg:p-10">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.services.index') }}" class="hover:text-brand-primary transition-colors font-semibold">Katalog Jasa</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-semibold truncate max-w-[200px]">{{ $service->title }}</span>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight mb-1">Edit Jasa</h1>
        <p class="text-sm text-gray-500 mb-8">Perbarui informasi jasa yang terdaftar di katalog.</p>

        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div>
                <label for="title" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                    Judul Jasa <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}"
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
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>
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
                        <option value="non_project" {{ old('type', $service->type) === 'non_project' ? 'selected' : '' }}>Non-Proyek</option>
                        <option value="project"     {{ old('type', $service->type) === 'project'     ? 'selected' : '' }}>Proyek</option>
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
                        <input type="number" name="price" id="price" value="{{ old('price', $service->price) }}"
                               min="0" step="1000" required
                               class="w-full pl-10 pr-4 py-3 text-sm border @error('price') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors">
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price_max" class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                        Harga Maks (Rp) <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-semibold">Rp</span>
                        <input type="number" name="price_max" id="price_max" value="{{ old('price_max', $service->price_max) }}"
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
                          class="w-full px-4 py-3 text-sm border @error('description') border-red-400 @else border-gray-200 @enderror rounded-xl outline-none focus:border-brand-primary transition-colors resize-none">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">
                    Gambar Cover <span class="text-gray-400 font-normal normal-case">(kosongkan jika tidak diubah)</span>
                </label>
                {{-- Gambar saat ini --}}
                @if($service->image)
                    <div class="mb-3 flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <img src="{{ Storage::url($service->image) }}" class="w-14 h-14 rounded-lg object-cover">
                        <div>
                            <p class="text-xs font-semibold text-gray-600">Gambar saat ini</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Unggah gambar baru untuk mengganti</p>
                        </div>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-brand-primary transition-colors cursor-pointer"
                     onclick="document.getElementById('image').click()">
                    <input type="file" name="image" id="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                    <div id="image-placeholder">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk unggah gambar baru</p>
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
                           {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                </label>
                <div>
                    <p class="text-sm font-bold text-gray-700">Aktifkan jasa</p>
                    <p class="text-xs text-gray-400">Jasa tampil di katalog publik jika diaktifkan</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="bg-brand-primary text-white font-bold text-sm px-8 py-3 rounded-xl hover:bg-brand-dark transition-colors shadow-lg shadow-indigo-200">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.services.index') }}"
                   class="text-gray-500 font-semibold text-sm px-4 py-3 rounded-xl hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                {{-- Hapus --}}
                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="ml-auto"
                      onsubmit="return confirm('Yakin ingin menghapus jasa ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-2 text-red-500 hover:text-red-700 text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Jasa
                    </button>
                </form>
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
