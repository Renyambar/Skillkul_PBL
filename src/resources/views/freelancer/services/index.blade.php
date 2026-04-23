@extends('layouts.freelancer')
@section('title', 'Layanan Saya - SkillKul')
@section('content')
<div class="p-8 lg:p-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight mb-1">Manajemen Layanan Saya</h1>
            <p class="text-sm text-gray-500">Kelola semua jasa yang Anda tawarkan di marketplace SkillKul.</p>
        </div>
        <a href="{{ route('freelancer.jasa.create') }}" class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold px-6 py-3 rounded-xl transition-all shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buka Jasa Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div id="flash-msg" class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm font-semibold px-5 py-3 rounded-xl mb-6">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-green-400 hover:text-green-600">✕</button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Jasa</p>
            <h3 class="text-2xl font-extrabold text-brand-dark">{{ $stats['total'] }}</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Jasa Aktif</p>
            <h3 class="text-2xl font-extrabold text-green-600">{{ $stats['aktif'] }}</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Non-Aktif</p>
            <h3 class="text-2xl font-extrabold text-gray-400">{{ $stats['nonaktif'] }}</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Pesanan</p>
            <h3 class="text-2xl font-extrabold text-brand-primary">{{ $stats['pesanan'] }}</h3>
        </div>
    </div>

    {{-- Tabel Jasa --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold">Belum ada jasa yang Anda buat.</p>
                <p class="text-gray-400 text-sm mt-1">Mulai tawarkan keahlian Anda dengan membuka jasa baru.</p>
                <a href="{{ route('freelancer.jasa.create') }}" class="mt-4 inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buka Jasa Baru
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-4">Judul Jasa</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Pesanan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($services as $service)
                        <tr class="hover:bg-gray-50/50 transition-colors {{ !$service->is_active ? 'opacity-60' : '' }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    @if($service->image)
                                        <img src="{{ Storage::url($service->image) }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $service->title }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $service->category?->name ?? '–' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if($service->type === 'project')
                                    <span class="bg-purple-100 text-purple-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Project</span>
                                @else
                                    <span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Non-Project</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 font-bold text-brand-primary">{{ $service->price_range }}</td>
                            <td class="px-6 py-5 text-gray-600">{{ $service->orders->count() }} pesanan</td>
                            <td class="px-6 py-5">
                                @if($service->is_active)
                                    <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-600 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('freelancer.jasa.edit', $service) }}"
                                       title="Edit"
                                       class="p-2 rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-100 hover:text-indigo-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    {{-- Hapus --}}
                                    <form method="POST" action="{{ route('freelancer.jasa.destroy', $service) }}" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus jasa \'{{ addslashes($service->title) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Hapus"
                                                class="p-2 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
