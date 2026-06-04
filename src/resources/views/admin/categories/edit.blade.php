@extends('layouts.admin')
@section('title', 'Admin - Edit Kategori')

@section('content')
<div class="p-8 lg:p-10 min-h-screen">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-brand-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Edit Kategori</h1>
            <p class="text-sm text-gray-500 mt-0.5">Mengubah data kategori: <strong>{{ $category->name }}</strong></p>
        </div>
    </div>

    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Kategori --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:border-brand-primary transition-colors @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ikon Emoji --}}
                <div>
                    <label for="icon" class="block text-sm font-bold text-gray-700 mb-2">Ikon (Emoji)</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                           maxlength="10"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:border-brand-primary transition-colors">
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:border-brand-primary transition-colors">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info jasa yang menggunakan --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-gray-600 mb-1">📊 Penggunaan Kategori</p>
                    <p class="text-sm text-gray-700">
                        Kategori ini digunakan oleh
                        <strong>{{ $category->services()->count() }}</strong> jasa
                        (<strong>{{ $category->services()->where('is_active', true)->count() }}</strong> aktif).
                    </p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="bg-brand-primary text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition-all shadow">
                        Simpan Perubahan
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
