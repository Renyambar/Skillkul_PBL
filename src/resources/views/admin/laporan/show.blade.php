@extends('layouts.admin')
@section('title', 'Detail Laporan #' . $report->id . ' - SkillKul Admin')
@section('content')
@php
    $statusConfig = [
        'pending'      => ['label' => 'Menunggu', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 border-yellow-100 dark:border-yellow-800/50', 'text' => ''],
        'ditinjau'     => ['label' => 'Sedang Ditinjau', 'bg' => 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border-blue-100 dark:border-blue-800/50', 'text' => ''],
        'diselesaikan' => ['label' => 'Diselesaikan', 'bg' => 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-100 dark:border-green-800/50', 'text' => ''],
        'ditolak'      => ['label' => 'Ditolak', 'bg' => 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-100 dark:border-red-800/50', 'text' => ''],
    ];
    $kategoriConfig = [
        'penipuan'              => ['label' => 'Penipuan', 'icon' => '🚨'],
        'tidak_selesai'         => ['label' => 'Tidak Diselesaikan', 'icon' => '⏰'],
        'kualitas_buruk'        => ['label' => 'Kualitas Buruk', 'icon' => '⚠️'],
        'perilaku_tidak_pantas' => ['label' => 'Perilaku Tidak Pantas', 'icon' => '🚫'],
        'lainnya'               => ['label' => 'Lainnya', 'icon' => '📋'],
    ];
    $st = $statusConfig[$report->status] ?? ['label' => $report->status, 'bg' => 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-700', 'text' => ''];
    $kt = $kategoriConfig[$report->category] ?? ['label' => $report->category, 'icon' => '📋'];
@endphp

<div class="p-8 lg:p-10 max-w-6xl mx-auto transition-colors duration-300">
    {{-- Back link --}}
    <a href="{{ route('admin.laporan.index') }}"
       class="inline-flex items-center gap-2 text-[11px] font-extrabold text-gray-500 dark:text-gray-400 hover:text-brand-primary dark:hover:text-indigo-400 mb-8 transition-colors uppercase tracking-widest bg-white dark:bg-brand-darksurface border border-gray-200 dark:border-brand-darkborder px-4 py-2 rounded-xl shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Laporan
    </a>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-300 rounded-2xl px-5 py-4 text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-800 dark:text-red-300 rounded-2xl px-5 py-4 text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kiri: Detail laporan --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Header card --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gray-50 dark:bg-gray-800/20 rounded-bl-full -z-10"></div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                    <h1 class="text-2xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                        <span class="text-3xl bg-gray-50 dark:bg-gray-800 p-2.5 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">{{ $kt['icon'] }}</span>
                        Laporan #{{ $report->id }}
                    </h1>
                    <span class="inline-flex items-center gap-2 border {{ $st['bg'] }} text-[10px] font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-wider">
                        @if($report->status === 'pending') <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> @endif
                        @if($report->status === 'ditinjau') <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> @endif
                        @if($report->status === 'diselesaikan') <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> @endif
                        @if($report->status === 'ditolak') <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> @endif
                        {{ $st['label'] }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/50">
                        <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 mb-1.5 uppercase tracking-widest flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Kategori Laporan
                        </p>
                        <p class="font-black text-gray-900 dark:text-white text-sm">{{ $kt['label'] }}</p>
                    </div>

                    @if($report->order)
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl p-5 border border-indigo-100 dark:border-indigo-800/50">
                        <p class="text-[10px] font-extrabold text-indigo-500 dark:text-indigo-400 mb-1.5 uppercase tracking-widest flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Konteks Pesanan
                        </p>
                        <p class="font-bold text-indigo-900 dark:text-indigo-300 text-[13px] truncate" title="{{ $report->order->service->title ?? 'Layanan dihapus' }}">{{ $report->order->service->title ?? 'Layanan dihapus' }}</p>
                        <p class="text-[10px] text-indigo-600 dark:text-indigo-400 font-mono mt-1 font-bold">ORD-{{ substr($report->order_id, 0, 8) }}</p>
                    </div>
                    @endif
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700/50 mb-6 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gray-200 dark:bg-gray-700 rounded-l-2xl"></div>
                    <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 mb-3 uppercase tracking-widest flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Deskripsi Lengkap
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap font-medium">{{ $report->description }}</p>
                </div>

                @if($report->admin_notes)
                <div class="mb-6 p-6 bg-amber-50 dark:bg-amber-900/20 rounded-2xl border border-amber-100 dark:border-amber-800/50 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-300 dark:bg-amber-600 rounded-l-2xl"></div>
                    <p class="text-[10px] font-extrabold text-amber-600 dark:text-amber-500 mb-2 uppercase tracking-widest flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Catatan Admin
                    </p>
                    <p class="text-sm text-amber-800 dark:text-amber-300 font-medium">{{ $report->admin_notes }}</p>
                </div>
                @endif

                {{-- File Lampiran --}}
                @if($report->attachment_path)
                <div class="mb-6 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-200 dark:border-gray-700 border-dashed">
                    <p class="text-[10px] font-extrabold text-gray-500 dark:text-gray-400 mb-4 uppercase tracking-widest flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Bukti Lampiran
                    </p>
                    @php $ext = pathinfo($report->attachment_path, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                        <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 mb-4">
                            <img src="{{ Storage::url($report->attachment_path) }}"
                                 alt="Bukti laporan"
                                 class="w-full max-h-80 object-contain">
                        </div>
                    @endif
                    <a href="{{ Storage::url($report->attachment_path) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-brand-primary dark:hover:text-indigo-400 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Unduh / Buka File Bukti
                    </a>
                </div>
                @endif

                <div class="pt-6 border-t border-gray-100 dark:border-gray-800/50 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-[11px] font-bold text-gray-500 dark:text-gray-400">Dilaporkan pada: {{ $report->created_at->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}</p>
                </div>
            </div>

            {{-- Action Form --}}
            @if(in_array($report->status, ['pending', 'ditinjau']))
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-8 relative overflow-hidden" x-data="{ action: '' }">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-50 dark:bg-indigo-900/10 rounded-full blur-3xl -z-10"></div>
                <h2 class="text-lg font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-primary dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    Ambil Tindakan
                </h2>
                <form action="{{ route('admin.laporan.resolve', $report->id) }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] font-extrabold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-widest">Keputusan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="flex items-center gap-4 p-4 border-2 rounded-2xl cursor-pointer transition-all bg-white dark:bg-gray-800/50"
                                       :class="action === 'diselesaikan' ? 'border-green-500 dark:border-green-400 bg-green-50/50 dark:bg-green-900/10 shadow-sm shadow-green-100 dark:shadow-none' : 'border-gray-200 dark:border-gray-700 hover:border-green-300 dark:hover:border-green-700'">
                                    <input type="radio" name="action" value="diselesaikan" x-model="action" class="sr-only">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors" :class="action === 'diselesaikan' ? 'bg-green-500 text-white' : 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-900 dark:text-white" :class="action === 'diselesaikan' ? 'text-green-700 dark:text-green-400' : ''">Selesaikan</p>
                                        <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-0.5">Laporan valid, tindak lanjuti</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-4 p-4 border-2 rounded-2xl cursor-pointer transition-all bg-white dark:bg-gray-800/50"
                                       :class="action === 'ditolak' ? 'border-red-500 dark:border-red-400 bg-red-50/50 dark:bg-red-900/10 shadow-sm shadow-red-100 dark:shadow-none' : 'border-gray-200 dark:border-gray-700 hover:border-red-300 dark:hover:border-red-700'">
                                    <input type="radio" name="action" value="ditolak" x-model="action" class="sr-only">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors" :class="action === 'ditolak' ? 'bg-red-500 text-white' : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-900 dark:text-white" :class="action === 'ditolak' ? 'text-red-700 dark:text-red-400' : ''">Tolak</p>
                                        <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-0.5">Laporan tidak valid</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Opsi tangguhkan pengguna jika diselesaikan --}}
                        <div x-show="action === 'diselesaikan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <label class="flex items-center gap-4 p-4 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/50 rounded-2xl cursor-pointer hover:bg-red-100 dark:hover:bg-red-900/20 transition-colors relative overflow-hidden group">
                                <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-red-500/5 rounded-full blur-xl group-hover:scale-110 transition-transform"></div>
                                <div class="relative flex items-center justify-center w-6 h-6">
                                    <input type="checkbox" name="suspend_user" value="1"
                                           class="w-5 h-5 text-red-600 bg-white dark:bg-gray-800 border-red-300 dark:border-red-700 rounded focus:ring-red-500 dark:focus:ring-red-500/50 focus:ring-2 cursor-pointer transition-colors">
                                </div>
                                <div class="relative z-10">
                                    <p class="text-sm font-black text-red-800 dark:text-red-400 flex items-center gap-2">
                                        Tangguhkan akun terlapor
                                        <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 text-[9px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider">Aksi Berat</span>
                                    </p>
                                    <p class="text-[11px] font-medium text-red-600 dark:text-red-500 mt-0.5">Akun <strong class="font-extrabold">{{ $report->reported->name ?? 'pengguna' }}</strong> akan dinonaktifkan dari platform</p>
                                </div>
                            </label>
                        </div>

                        <div>
                            <label class="block text-[11px] font-extrabold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-widest">Catatan Admin <span class="text-red-500">*</span></label>
                            <textarea name="admin_notes" rows="4" required
                                      class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-2xl px-5 py-4 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 transition-colors resize-none"
                                      placeholder="Jelaskan keputusan Anda dan tindakan yang diambil..."></textarea>
                        </div>

                        <button type="submit"
                                :disabled="action === ''"
                                :class="action === '' ? 'bg-gray-200 dark:bg-gray-800 text-gray-400 dark:text-gray-600 cursor-not-allowed' : 'bg-brand-primary dark:bg-indigo-600 text-white hover:bg-brand-dark dark:hover:bg-indigo-500 shadow-sm shadow-indigo-200 dark:shadow-none'"
                                class="w-full py-4 rounded-2xl text-sm font-black transition-all flex items-center justify-center gap-2">
                            <span x-text="action === '' ? 'Pilih keputusan dahulu' : 'Konfirmasi Tindakan'"></span>
                            <svg x-show="action !== ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>

        {{-- Kanan: Pelapor & Terlapor --}}
        <div class="space-y-6">
            {{-- Pelapor --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 dark:bg-indigo-900/10 rounded-bl-full -z-10"></div>
                <p class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Pelapor (Klien)
                </p>
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 flex items-center justify-center font-black text-xl flex-shrink-0 shadow-inner">
                        {{ strtoupper(substr($report->reporter->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white truncate">{{ $report->reporter->name ?? 'Pengguna Dihapus' }}</p>
                        <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 truncate mt-0.5">{{ $report->reporter->email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Terlapor --}}
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-orange-50 dark:bg-orange-900/10 rounded-bl-full -z-10"></div>
                <p class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Terlapor (Pekerja Lepas)
                </p>
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 flex items-center justify-center font-black text-xl flex-shrink-0 shadow-inner border border-orange-200 dark:border-orange-800/30">
                        {{ strtoupper(substr($report->reported->name ?? 'F', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white truncate flex items-center gap-2">
                            {{ $report->reported->name ?? 'Pengguna Dihapus' }}
                            @if($report->reported)
                                <span class="inline-block text-[9px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider
                                    {{ $report->reported->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }}">
                                    {{ $report->reported->is_active ? 'Aktif' : 'Ditangguhkan' }}
                                </span>
                            @endif
                        </p>
                        <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 truncate mt-1">{{ $report->reported->email ?? '-' }}</p>
                    </div>
                </div>
                @if($report->reported)
                <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800/50 flex justify-between items-center">
                    <p class="text-[11px] font-bold text-gray-500 dark:text-gray-400">Total laporan ke pengguna ini:</p>
                    <span class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-xs font-black px-3 py-1 rounded-lg border border-gray-200 dark:border-gray-700">
                        {{ $report->reported->reportsReceived()->count() }}
                    </span>
                </div>
                @endif
            </div>

            {{-- Quick Admin Actions --}}
            @if($report->reported && $report->reported->is_active && in_array($report->status, ['pending', 'ditinjau']))
            <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/50 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-500/5 rounded-full blur-xl group-hover:scale-110 transition-transform"></div>
                <p class="text-[11px] font-black text-red-700 dark:text-red-400 mb-4 uppercase tracking-widest flex items-center gap-2 relative z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Aksi Cepat
                </p>
                <form action="{{ route('admin.users.toggle', $report->reported->id) }}" method="POST" class="relative z-10">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 dark:bg-red-500/20 text-white dark:text-red-400 border border-transparent dark:border-red-500/30 py-3.5 rounded-xl text-[11px] uppercase tracking-wider font-black hover:bg-red-700 dark:hover:bg-red-500/30 transition-colors shadow-sm dark:shadow-none flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Tangguhkan Akun Terlapor
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
