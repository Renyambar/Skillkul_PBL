@extends('layouts.admin')
@section('title', 'Admin - Tambah Kategori')

@section('content')
<div class="p-8 lg:p-10 min-h-screen">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-brand-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Tambah Kategori Baru</h1>
            <p class="text-sm text-gray-500 mt-0.5">Buat kategori jasa baru untuk marketplace.</p>
        </div>
    </div>

    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nama Kategori --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           placeholder="Contoh: Pemrograman & Teknologi"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:border-brand-primary transition-colors @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ikon Emoji --}}
                <div>
                    <label for="icon" class="block text-sm font-bold text-gray-700 mb-2">
                        Ikon (Emoji)
                    </label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon') }}"
                           placeholder="Contoh: 💻 atau 🎨"
                           maxlength="10"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:border-brand-primary transition-colors">
                    <p class="text-xs text-gray-400 mt-1.5">Satu emoji untuk mewakili kategori ini di UI.</p>
                    @error('icon')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="Jelaskan jenis jasa apa yang termasuk dalam kategori ini..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:border-brand-primary transition-colors @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contoh Kategori Populer --}}
                <div class="bg-indigo-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-indigo-700 mb-2">💡 Contoh Kategori Populer:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['💻 Pemrograman','🎨 Desain Grafis','📐 UI/UX','✍️ Penulisan','📊 Analisis Data','🎬 Multimedia','📋 Administrasi','🎓 Akademik'] as $contoh)
                            <span class="text-xs bg-white text-indigo-600 border border-indigo-200 px-2 py-1 rounded-lg cursor-pointer hover:bg-indigo-100 transition-colors"
                                  onclick="document.getElementById('name').value='{{ str_replace(['💻 ','🎨 ','📐 ','✍️ ','📊 ','🎬 ','📋 ','🎓 '], '', $contoh) }}'">
                                {{ $contoh }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="bg-brand-primary text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition-all shadow">
                        Simpan Kategori
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                       class="text-sm font-semibold text-gray-500 hover:text-gray-700 px-4 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
