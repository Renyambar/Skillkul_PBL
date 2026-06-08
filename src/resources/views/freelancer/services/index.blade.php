@extends('layouts.freelancer')
@section('title', 'Layanan Saya - SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 transition-colors duration-300">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight mb-2">Manajemen Layanan Saya</h1>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelola semua layanan yang Anda tawarkan di Pasar Layanan SkillKul.</p>
        </div>
        <a href="{{ route('freelancer.jasa.create') }}" class="inline-flex items-center gap-2 bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-500 text-white text-sm font-bold px-6 py-3 rounded-xl transition-all shadow-md dark:shadow-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buka Layanan Jasa Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" id="flash-msg" class="flex items-center gap-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-400 text-sm font-bold px-5 py-3 rounded-xl mb-6 shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button @click="show = false" class="ml-auto text-green-500 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 focus:outline-none transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl p-6 border border-gray-100 dark:border-brand-darkborder shadow-sm flex items-center justify-between transition-colors">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total Jasa</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $stats['total'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center text-brand-primary dark:text-indigo-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl p-6 border border-gray-100 dark:border-brand-darkborder shadow-sm flex items-center justify-between transition-colors">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Jasa Aktif</p>
                <h3 class="text-3xl font-black text-green-600 dark:text-green-400">{{ $stats['aktif'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl p-6 border border-gray-100 dark:border-brand-darkborder shadow-sm flex items-center justify-between transition-colors">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Non-Aktif</p>
                <h3 class="text-3xl font-black text-gray-400 dark:text-gray-500">{{ $stats['nonaktif'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-gray-50 dark:bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 dark:text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl p-6 border border-gray-100 dark:border-brand-darkborder shadow-sm flex items-center justify-between transition-colors">
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total Pesanan</p>
                <h3 class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ $stats['pesanan'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Tabel Jasa --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden transition-colors">
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 dark:text-white mb-2">Belum ada jasa yang Anda buat.</h3>
                <p class="text-[13px] font-medium text-gray-500 dark:text-gray-400 mb-6 max-w-sm">Mulai tawarkan keahlian Anda dengan membuka layanan jasa baru ke platform.</p>
                <a href="{{ route('freelancer.jasa.create') }}" class="inline-flex items-center gap-2 bg-brand-primary dark:bg-indigo-600 hover:bg-brand-dark dark:hover:bg-indigo-500 text-white text-sm font-bold px-6 py-3.5 rounded-xl transition-all shadow-md dark:shadow-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buka Jasa Baru
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                            <th class="px-6 py-5">Judul Jasa</th>
                            <th class="px-6 py-5">Tipe</th>
                            <th class="px-6 py-5">Harga</th>
                            <th class="px-6 py-5 text-center">Pesanan</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-6 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/50">
                        @foreach($services as $service)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors {{ !$service->is_active ? 'bg-gray-50/50 dark:bg-gray-800/30' : '' }}">
                            <td class="px-6 py-5 min-w-[300px] whitespace-normal">
                                <div class="flex items-center gap-4">
                                    @if($service->image)
                                        <img src="{{ Storage::url($service->image) }}" class="w-14 h-14 rounded-xl object-cover shadow-sm border border-gray-100 dark:border-gray-700">
                                    @else
                                        <div class="w-14 h-14 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/30 flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <svg class="w-7 h-7 text-indigo-400 dark:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white {{ !$service->is_active ? 'text-gray-500 dark:text-gray-400' : '' }}">{{ $service->title }}</p>
                                        <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-1">{{ $service->category?->name ?? 'Kategori Umum' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if($service->type === 'project')
                                    <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">Proyek</span>
                                @else
                                    <span class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">Non-Proyek</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-[11px] font-bold px-3 py-1.5 rounded-full">{{ $service->orders_count ?? ($service->orders ? $service->orders->count() : 0) }}</span>
                            </td>
                            <td class="px-6 py-5">
                                {{-- Toggle Aktif / Non-Aktif Form --}}
                                <form action="{{ route('freelancer.jasa.toggle', $service->id) }}" method="POST" class="flex justify-center">
                                    @csrf
                                    <button type="submit" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-brand-primary/50 dark:focus:ring-indigo-500/50 {{ $service->is_active ? 'bg-green-500 dark:bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}" role="switch" aria-checked="{{ $service->is_active ? 'true' : 'false' }}" title="Ubah Status Jasa">
                                        <span class="sr-only">Toggle layanan</span>
                                        <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $service->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2" x-data="{ showModal: false }">
                                    {{-- Edit --}}
                                    <a href="{{ route('freelancer.jasa.edit', $service->id) }}"
                                       class="p-2.5 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors focus:ring-2 focus:ring-indigo-500/50" title="Edit Jasa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    {{-- Hapus (Buka Modal) --}}
                                    <button @click="showModal = true" type="button" class="p-2.5 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 hover:text-red-800 dark:hover:text-red-300 transition-colors focus:ring-2 focus:ring-red-500/50" title="Hapus Jasa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>

                                    {{-- Modal Konfirmasi Hapus --}}
                                    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-900/75 dark:bg-gray-900/90 backdrop-blur-sm transition-opacity" @click="showModal = false" aria-hidden="true"></div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div x-show="showModal" x-transition.scale class="inline-block align-bottom bg-white dark:bg-brand-darksurface rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100 dark:border-brand-darkborder">
                                                <div class="bg-white dark:bg-brand-darksurface px-6 pt-6 pb-6 sm:p-8 sm:pb-6">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-12 sm:w-12">
                                                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                        </div>
                                                        <div class="mt-4 text-center sm:mt-0 sm:ml-5 sm:text-left">
                                                            <h3 class="text-xl font-black text-gray-900 dark:text-white" id="modal-title">Hapus Jasa</h3>
                                                            <div class="mt-3">
                                                                <p class="text-[13px] font-medium text-gray-500 dark:text-gray-400 whitespace-normal leading-relaxed">Apakah Anda yakin ingin menghapus jasa <strong class="text-gray-900 dark:text-white">"{{ $service->title }}"</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-gray-100 dark:border-gray-800">
                                                    <form action="{{ route('freelancer.jasa.destroy', $service->id) }}" method="POST" class="sm:ml-3">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-3 bg-red-600 text-sm font-bold text-white hover:bg-red-700 dark:hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 focus:ring-red-500 sm:w-auto transition-colors shadow-sm">
                                                            Ya, Hapus
                                                        </button>
                                                    </form>
                                                    <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-700 px-6 py-3 bg-white dark:bg-brand-darksurface text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 focus:ring-brand-primary dark:focus:ring-indigo-500 sm:mt-0 sm:w-auto transition-colors">
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
                <div class="p-6 border-t border-gray-100 dark:border-gray-800">
                    {{ $services->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
