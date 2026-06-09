@extends('layouts.admin')
@section('title', 'Admin - Edit Layanan')

@section('content')
<div class="p-8 lg:p-10 transition-colors duration-300">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-8">
        <a href="{{ route('admin.services.index') }}" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Katalog Layanan</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-800 dark:text-gray-200 truncate max-w-[200px]">{{ $service->title }}</span>
    </div>

    <div class="max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight mb-2">Edit Layanan</h1>
            <p class="text-[13px] font-medium text-gray-500 dark:text-gray-400">Perbarui informasi layanan yang terdaftar di katalog.</p>
        </div>

        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data"
              class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-8 space-y-8 relative overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-50 dark:bg-indigo-900/10 rounded-bl-full -z-10"></div>

            {{-- Judul --}}
            <div>
                <label for="title" class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-700 dark:text-gray-300 mb-2.5">
                    Judul Layanan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}"
                           maxlength="150" required
                           class="w-full pl-11 pr-4 py-3.5 text-[13px] font-medium border @error('title') border-red-400 dark:border-red-500/50 @else border-gray-200 dark:border-gray-700 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-brand-primary/20 dark:focus:ring-indigo-500/20 focus:border-brand-primary dark:focus:border-indigo-500 transition-all bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                @error('title')
                    <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori & Tipe --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-700 dark:text-gray-300 mb-2.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="category_id" id="category_id" required
                                class="w-full pl-11 pr-4 py-3.5 text-[13px] font-medium border @error('category_id') border-red-400 dark:border-red-500/50 @else border-gray-200 dark:border-gray-700 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-brand-primary/20 dark:focus:ring-indigo-500/20 focus:border-brand-primary dark:focus:border-indigo-500 transition-all bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-white appearance-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    @error('category_id')
                        <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="type" class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-700 dark:text-gray-300 mb-2.5">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="type" id="type" required
                                class="w-full pl-11 pr-4 py-3.5 text-[13px] font-medium border @error('type') border-red-400 dark:border-red-500/50 @else border-gray-200 dark:border-gray-700 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-brand-primary/20 dark:focus:ring-indigo-500/20 focus:border-brand-primary dark:focus:border-indigo-500 transition-all bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-white appearance-none">
                            <option value="non_project" {{ old('type', $service->type) === 'non_project' ? 'selected' : '' }}>Non-Proyek</option>
                            <option value="project"     {{ old('type', $service->type) === 'project'     ? 'selected' : '' }}>Proyek</option>
                        </select>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    @error('type')
                        <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Harga --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-700 dark:text-gray-300 mb-2.5">
                        Harga Min / Tetap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[13px] font-black text-gray-400 dark:text-gray-500">Rp</span>
                        <input type="number" name="price" id="price" value="{{ old('price', $service->price) }}"
                               min="0" step="1000" required
                               class="w-full pl-12 pr-4 py-3.5 text-[13px] font-medium border @error('price') border-red-400 dark:border-red-500/50 @else border-gray-200 dark:border-gray-700 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-brand-primary/20 dark:focus:ring-indigo-500/20 focus:border-brand-primary dark:focus:border-indigo-500 transition-all bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    @error('price')
                        <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price_max" class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-700 dark:text-gray-300 mb-2.5">
                        Harga Maks <span class="text-gray-400 dark:text-gray-500 font-medium normal-case ml-1">(Opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[13px] font-black text-gray-400 dark:text-gray-500">Rp</span>
                        <input type="number" name="price_max" id="price_max" value="{{ old('price_max', $service->price_max) }}"
                               min="0" step="1000"
                               class="w-full pl-12 pr-4 py-3.5 text-[13px] font-medium border @error('price_max') border-red-400 dark:border-red-500/50 @else border-gray-200 dark:border-gray-700 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-brand-primary/20 dark:focus:ring-indigo-500/20 focus:border-brand-primary dark:focus:border-indigo-500 transition-all bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    @error('price_max')
                        <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-700 dark:text-gray-300 mb-2.5">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea name="description" id="description" rows="5" required
                          class="w-full px-5 py-4 text-[13px] font-medium border @error('description') border-red-400 dark:border-red-500/50 @else border-gray-200 dark:border-gray-700 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-brand-primary/20 dark:focus:ring-indigo-500/20 focus:border-brand-primary dark:focus:border-indigo-500 transition-all bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 resize-none">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-700 dark:text-gray-300 mb-2.5">
                    Gambar Cover <span class="text-gray-400 dark:text-gray-500 font-medium normal-case ml-1">(Kosongkan jika tidak diubah)</span>
                </label>
                {{-- Gambar saat ini --}}
                @if($service->image)
                    <div class="mb-4 flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                        <img src="{{ Storage::url($service->image) }}" class="w-16 h-16 rounded-xl object-cover shadow-sm border border-gray-200 dark:border-gray-700">
                        <div>
                            <p class="text-[13px] font-black text-gray-700 dark:text-gray-300">Gambar Saat Ini</p>
                            <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-0.5">Unggah gambar baru untuk mengganti</p>
                        </div>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl p-8 text-center hover:border-brand-primary dark:hover:border-indigo-500 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 transition-all cursor-pointer group bg-gray-50 dark:bg-gray-800/50"
                     onclick="document.getElementById('image').click()">
                    <input type="file" name="image" id="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                    <div id="image-placeholder">
                        <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-indigo-400 dark:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-[13px] font-black text-gray-700 dark:text-gray-300">Klik untuk unggah gambar baru</p>
                    </div>
                    <img id="image-preview" src="" alt="Preview" class="hidden mx-auto max-h-56 rounded-2xl object-cover shadow-sm border border-gray-200 dark:border-gray-700">
                </div>
                @error('image')
                    <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-4 p-5 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="sr-only peer"
                           {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    <div class="w-12 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                </label>
                <div>
                    <p class="text-[13px] font-black text-gray-900 dark:text-white">Aktifkan Layanan</p>
                    <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-0.5">Layanan tampil di katalog publik jika diaktifkan</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t border-gray-100 dark:border-gray-800/50">
                <button type="submit"
                        class="w-full sm:w-auto bg-brand-primary dark:bg-indigo-600 text-white font-black text-[13px] px-8 py-3.5 rounded-xl hover:bg-brand-dark dark:hover:bg-indigo-500 transition-colors shadow-sm dark:shadow-none flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.services.index') }}"
                   class="w-full sm:w-auto text-center text-gray-600 dark:text-gray-300 font-bold text-[13px] px-6 py-3.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors border border-transparent hover:border-gray-200 dark:hover:border-gray-700">
                    Batal
                </a>
                
                {{-- Hapus --}}
                <div class="w-full sm:w-auto sm:ml-auto">
                    <button type="button" onclick="document.getElementById('delete-form').submit()"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-black text-[13px] px-6 py-3.5 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors border border-transparent hover:border-red-100 dark:hover:border-red-800/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Layanan
                    </button>
                </div>
            </div>
        </form>
        
        <form id="delete-form" method="POST" action="{{ route('admin.services.destroy', $service) }}" class="hidden"
              onsubmit="return confirm('Yakin ingin menghapus layanan ini? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
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
