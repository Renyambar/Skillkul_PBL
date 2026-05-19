@extends('layouts.freelancer')
@section('title', 'Layanan Saya - SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-1">Manajemen Layanan Saya</h1>
            <p class="text-sm text-gray-500">Kelola semua layanan yang Anda tawarkan di Pasar Layanan SkillKul.</p>
        </div>
        <a href="{{ route('freelancer.jasa.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-6 py-3 rounded-xl transition-all shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buka Layanan Jasa Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" id="flash-msg" class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm font-semibold px-5 py-3 rounded-xl mb-6 shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700 focus:outline-none">✕</button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Jasa</p>
                <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['total'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Jasa Aktif</p>
                <h3 class="text-3xl font-extrabold text-green-600">{{ $stats['aktif'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Non-Aktif</p>
                <h3 class="text-3xl font-extrabold text-gray-400">{{ $stats['nonaktif'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Pesanan</p>
                <h3 class="text-3xl font-extrabold text-indigo-600">{{ $stats['pesanan'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Tabel Jasa --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada jasa yang Anda buat.</h3>
                <p class="text-sm text-gray-500 mb-6">Mulai tawarkan keahlian Anda dengan membuka layanan jasa baru.</p>
                <a href="{{ route('freelancer.jasa.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-6 py-3 rounded-xl transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buka Jasa Baru
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-4">Judul Jasa</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4 text-center">Pesanan</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($services as $service)
                        <tr class="hover:bg-gray-50/50 transition-colors {{ !$service->is_active ? 'bg-gray-50/50' : '' }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    @if($service->image)
                                        <img src="{{ Storage::url($service->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm border border-gray-100">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-gray-900 {{ !$service->is_active ? 'text-gray-500' : '' }}">{{ $service->title }}</p>
                                        <p class="text-[11px] font-medium text-gray-500 mt-0.5">{{ $service->category?->name ?? 'Kategori Umum' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if($service->type === 'project')
                                    <span class="bg-orange-100 text-orange-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Project</span>
                                @else
                                    <span class="bg-indigo-100 text-indigo-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Non-Project</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 font-bold text-gray-900">
                                Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="bg-gray-100 text-gray-700 text-xs font-bold px-3 py-1 rounded-full">{{ $service->orders_count ?? ($service->orders ? $service->orders->count() : 0) }}</span>
                            </td>
                            <td class="px-6 py-5">
                                {{-- Toggle Aktif / Non-Aktif Form --}}
                                <form action="{{ route('freelancer.jasa.toggle', $service->id) }}" method="POST" class="flex justify-center">
                                    @csrf
                                    <button type="submit" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 {{ $service->is_active ? 'bg-green-500' : 'bg-gray-300' }}" role="switch" aria-checked="{{ $service->is_active ? 'true' : 'false' }}" title="Ubah Status Jasa">
                                        <span class="sr-only">Toggle layanan</span>
                                        <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $service->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2" x-data="{ showModal: false }">
                                    {{-- Edit --}}
                                    <a href="{{ route('freelancer.jasa.edit', $service->id) }}"
                                       class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-800 transition-colors focus:ring-2 focus:ring-indigo-500" title="Edit Jasa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    {{-- Hapus (Buka Modal) --}}
                                    <button @click="showModal = true" type="button" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 transition-colors focus:ring-2 focus:ring-red-500" title="Hapus Jasa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>

                                    {{-- Modal Konfirmasi Hapus --}}
                                    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false" aria-hidden="true"></div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div x-show="showModal" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Hapus Jasa</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500 whitespace-normal">Apakah Anda yakin ingin menghapus jasa <strong>"{{ $service->title }}"</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                                                    <form action="{{ route('freelancer.jasa.destroy', $service->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                            Ya, Hapus
                                                        </button>
                                                    </form>
                                                    <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                        Batal
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Component (jika tersedia) --}}
            @if(method_exists($services, 'links') && $services->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $services->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
