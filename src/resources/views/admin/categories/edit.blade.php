@extends('layouts.admin')
@section('title', 'Admin - Edit Kategori')

@section('content')
<div class="p-8 lg:p-10 min-h-screen transition-colors duration-300">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 bg-white dark:bg-brand-darksurface border border-gray-200 dark:border-brand-darkborder rounded-full flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-brand-primary dark:hover:text-indigo-400 hover:border-brand-primary dark:hover:border-indigo-500 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight">Edit Kategori</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-medium">Mengubah data kategori: <strong class="text-gray-900 dark:text-white">{{ $category->name }}</strong></p>
        </div>
    </div>

    <div class="max-w-xl">
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-8">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Kategori --}}
                <div>
                    <label for="name" class="block text-xs font-extrabold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-widest">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                           class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 transition-colors @error('name') border-red-400 dark:border-red-500 ring-red-400 dark:ring-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ikon Emoji --}}
                <div>
                    <label for="icon" class="block text-xs font-extrabold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-widest">Ikon (Emoji)</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                           maxlength="10"
                           class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 transition-colors">
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-xs font-extrabold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-widest">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 resize-none focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 transition-colors">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info layanan yang menggunakan --}}
                <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 rounded-2xl p-5">
                    <p class="text-xs font-extrabold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Penggunaan Kategori
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                        Kategori ini digunakan oleh
                        <strong class="text-gray-900 dark:text-white">{{ $category->services()->count() }}</strong> layanan
                        (<strong class="text-green-600 dark:text-green-400">{{ $category->services()->where('is_active', true)->count() }}</strong> aktif).
                    </p>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <button type="submit"
                            class="flex-1 bg-brand-primary dark:bg-indigo-600 text-white text-sm font-bold px-6 py-3 rounded-xl hover:bg-brand-dark dark:hover:bg-indigo-500 transition-all shadow-sm shadow-indigo-200 dark:shadow-none text-center">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                       class="flex-1 text-center bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-6 py-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
