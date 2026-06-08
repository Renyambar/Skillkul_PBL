@extends('layouts.admin')
@section('title', 'Admin - Kategori Jasa')

@section('content')
<div class="p-8 lg:p-10 relative min-h-screen transition-colors duration-300">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight">Manajemen Kategori</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium">Kelola kategori jasa yang tersedia di marketplace SkillKul.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 bg-brand-primary dark:bg-indigo-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-500 transition-all hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-300 text-sm font-semibold rounded-2xl px-5 py-4 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-800 dark:text-red-300 text-sm font-semibold rounded-2xl px-5 py-4 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Kategori --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800">
            <thead class="bg-gray-50/50 dark:bg-gray-800/30">
                <tr>
                    <th class="px-6 py-5 text-left text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest whitespace-nowrap">Kategori</th>
                    <th class="px-6 py-5 text-left text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:table-cell whitespace-nowrap">Deskripsi</th>
                    <th class="px-6 py-5 text-center text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest whitespace-nowrap">Jasa Aktif</th>
                    <th class="px-6 py-5 text-center text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest whitespace-nowrap">Status</th>
                    <th class="px-6 py-5 text-right text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ $category->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-2xl border border-indigo-100 dark:border-indigo-800/50 shadow-sm">
                                {{ $category->icon ?? '📦' }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $category->name }}</p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium mt-0.5">ID: {{ $category->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate font-medium">{{ $category->description ?? '—' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gray-50 dark:bg-gray-800 text-sm font-bold text-gray-900 dark:text-white border border-gray-100 dark:border-gray-700">
                            {{ $category->services_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($category->trashed())
                            <span class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider inline-block">Dihapus</span>
                        @else
                            <span class="bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider inline-block">Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if(!$category->trashed())
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 px-3 py-2 rounded-xl transition-colors border border-indigo-100 dark:border-indigo-800/30">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori \'{{ $category->name }}\'? Jasa yang sudah dibuat akan tetap ada, tetapi tidak bisa memilih kategori ini lagi.')"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs font-bold text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 px-3 py-2 rounded-xl transition-colors border border-red-100 dark:border-red-800/30">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center text-gray-400 dark:text-gray-500">
                        <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-gray-700">
                            <span class="text-3xl opacity-50">🏷️</span>
                        </div>
                        <p class="font-bold text-gray-600 dark:text-gray-400">Belum ada kategori</p>
                        <p class="text-xs mt-1 font-medium">Tambahkan kategori pertama untuk marketplace!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($categories->hasPages())
        <div class="mt-8">{{ $categories->links() }}</div>
    @endif

</div>
@endsection
