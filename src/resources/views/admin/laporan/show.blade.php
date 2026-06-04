@extends('layouts.admin')
@section('title', 'Detail Laporan #' . $report->id . ' - SkillKul Admin')
@section('content')
@php
    $statusConfig = [
        'pending'      => ['label' => 'Menunggu', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'ditinjau'     => ['label' => 'Sedang Ditinjau', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'diselesaikan' => ['label' => 'Diselesaikan', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
        'ditolak'      => ['label' => 'Ditolak', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
    ];
    $kategoriConfig = [
        'penipuan'              => ['label' => 'Penipuan', 'icon' => '🚨'],
        'tidak_selesai'         => ['label' => 'Tidak Diselesaikan', 'icon' => '⏰'],
        'kualitas_buruk'        => ['label' => 'Kualitas Buruk', 'icon' => '⚠️'],
        'perilaku_tidak_pantas' => ['label' => 'Perilaku Tidak Pantas', 'icon' => '🚫'],
        'lainnya'               => ['label' => 'Lainnya', 'icon' => '📋'],
    ];
    $st = $statusConfig[$report->status] ?? ['label' => $report->status, 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
    $kt = $kategoriConfig[$report->category] ?? ['label' => $report->category, 'icon' => '📋'];
@endphp

<div class="p-8 lg:p-10 max-w-5xl">
    {{-- Back link --}}
    <a href="{{ route('admin.laporan.index') }}"
       class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-800 mb-8 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Kembali ke Daftar Laporan
    </a>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-3 text-sm font-medium">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-3 text-sm font-medium">
            ✕ {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kiri: Detail laporan --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Header card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-xl font-extrabold text-gray-900">
                        {{ $kt['icon'] }} Laporan #{{ $report->id }}
                    </h1>
                    <span class="{{ $st['bg'] }} {{ $st['text'] }} text-xs font-extrabold px-4 py-1.5 rounded-full uppercase tracking-wider">
                        {{ $st['label'] }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <p class="text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Kategori</p>
                    <p class="font-bold text-gray-900">{{ $kt['label'] }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Deskripsi Lengkap</p>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $report->description }}</p>
                </div>

                @if($report->order)
                <div class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                    <p class="text-xs font-bold text-indigo-600 mb-1 uppercase tracking-wider">Konteks Pesanan</p>
                    <p class="font-bold text-indigo-900 text-sm">{{ $report->order->service->title ?? 'Layanan dihapus' }}</p>
                    <p class="text-xs text-indigo-600 font-mono mt-1">#{{ substr($report->order_id, 0, 8) }}</p>
                </div>
                @endif

                @if($report->admin_notes)
                <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-100">
                    <p class="text-xs font-bold text-amber-600 mb-1 uppercase tracking-wider">Catatan Admin</p>
                    <p class="text-sm text-amber-800">{{ $report->admin_notes }}</p>
                </div>
                @endif

                {{-- File Lampiran --}}
                @if($report->attachment_path)
                <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">📎 Bukti Lampiran</p>
                    @php $ext = pathinfo($report->attachment_path, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                        <img src="{{ Storage::url($report->attachment_path) }}"
                             alt="Bukti laporan"
                             class="w-full max-h-64 object-contain rounded-lg border border-gray-100">
                    @endif
                    <a href="{{ Storage::url($report->attachment_path) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Unduh / Buka Bukti
                    </a>
                </div>
                @endif

                <p class="text-xs text-gray-400 mt-4">Dilaporkan pada: {{ $report->created_at->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}</p>
            </div>

            {{-- Action Form --}}
            @if(in_array($report->status, ['pending', 'ditinjau']))
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ action: '' }">
                <h2 class="text-base font-extrabold text-gray-900 mb-4">Ambil Tindakan</h2>
                <form action="{{ route('admin.laporan.resolve', $report->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Keputusan</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all"
                                       :class="action === 'diselesaikan' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" name="action" value="diselesaikan" x-model="action" class="sr-only">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">✓</div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">Selesaikan</p>
                                        <p class="text-xs text-gray-500">Laporan valid, tindakan diambil</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all"
                                       :class="action === 'ditolak' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" name="action" value="ditolak" x-model="action" class="sr-only">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">✕</div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">Tolak</p>
                                        <p class="text-xs text-gray-500">Laporan tidak valid</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Opsi suspend user jika diselesaikan --}}
                        <div x-show="action === 'diselesaikan'" x-transition>
                            <label class="flex items-center gap-3 p-3 bg-red-50 border border-red-200 rounded-xl cursor-pointer">
                                <input type="checkbox" name="suspend_user" value="1"
                                       class="w-4 h-4 text-red-600 rounded">
                                <div>
                                    <p class="text-sm font-bold text-red-800">Suspend akun yang dilaporkan</p>
                                    <p class="text-xs text-red-600">Akun {{ $report->reported->name ?? 'user' }} akan dinonaktifkan</p>
                                </div>
                            </label>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Catatan Admin <span class="text-red-500">*</span></label>
                            <textarea name="admin_notes" rows="4" required
                                      class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-brand-primary transition-colors resize-none"
                                      placeholder="Jelaskan keputusan Anda dan tindakan yang diambil..."></textarea>
                        </div>

                        <button type="submit"
                                :disabled="action === ''"
                                :class="action === '' ? 'opacity-50 cursor-not-allowed' : 'hover:bg-brand-dark'"
                                class="w-full bg-brand-primary text-white py-3 rounded-xl text-sm font-bold transition-colors">
                            Konfirmasi Tindakan
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>

        {{-- Kanan: Pelapor & Terlapor --}}
        <div class="space-y-6">
            {{-- Pelapor --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-4">Pelapor (Klien)</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($report->reporter->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $report->reporter->name ?? 'User Dihapus' }}</p>
                        <p class="text-xs text-gray-500">{{ $report->reporter->email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Terlapor --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-4">Terlapor (Freelancer)</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($report->reported->name ?? 'F', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $report->reported->name ?? 'User Dihapus' }}</p>
                        <p class="text-xs text-gray-500">{{ $report->reported->email ?? '-' }}</p>
                        @if($report->reported)
                            <span class="mt-1 inline-block text-[10px] font-bold px-2 py-0.5 rounded
                                {{ $report->reported->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $report->reported->is_active ? 'Aktif' : 'Disuspend' }}
                            </span>
                        @endif
                    </div>
                </div>
                @if($report->reported)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500">Total laporan diterima:
                        <strong class="text-gray-900">{{ $report->reported->reportsReceived()->count() }}</strong>
                    </p>
                </div>
                @endif
            </div>

            {{-- Quick Admin Actions --}}
            @if($report->reported && $report->reported->is_active && in_array($report->status, ['pending', 'ditinjau']))
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
                <p class="text-xs font-bold text-red-700 mb-3">⚡ Aksi Cepat</p>
                <form action="{{ route('admin.users.toggle', $report->reported->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 text-white py-2.5 rounded-lg text-xs font-bold hover:bg-red-700 transition-colors">
                        Suspend Akun Terlapor
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
