@extends('layouts.admin')
@section('title', 'Admin - Kategori Jasa')

@section('content')
<div class="p-8 lg:p-10 relative min-h-screen">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Manajemen Kategori</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola kategori jasa yang tersedia di marketplace SkillKul.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 bg-brand-primary text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow hover:bg-indigo-700 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 text-sm font-semibold rounded-xl px-5 py-4">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 text-sm font-semibold rounded-xl px-5 py-4">
            ⚠ {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Kategori --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider hidden md:table-cell">Deskripsi</th>
                    <th class="px-6 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">Jasa Aktif</th>
                    <th class="px-6 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-extrabold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50/60 transition-colors {{ $category->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ $category->icon ?? '📦' }}</span>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $category->name }}</p>
                                <p class="text-xs text-gray-400">ID: {{ $category->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <p class="text-sm text-gray-500 max-w-xs truncate">{{ $category->description ?? '—' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-bold text-gray-900">{{ $category->services_count }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($category->trashed())
                            <span class="bg-red-100 text-red-700 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase">Dihapus</span>
                        @else
                            <span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase">Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if(!$category->trashed())
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori \'{{ $category->name }}\'? Jasa yang sudah dibuat akan tetap ada, tetapi tidak bisa memilih kategori ini lagi.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <p class="text-4xl mb-3">🏷️</p>
                        <p class="text-gray-500 font-medium">Belum ada kategori. Tambahkan kategori pertama!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($categories->hasPages())
        <div class="mt-6">{{ $categories->links() }}</div>
    @endif

</div>
@endsection
