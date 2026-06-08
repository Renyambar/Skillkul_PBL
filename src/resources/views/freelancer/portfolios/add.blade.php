@extends('layouts.freelancer')
@section('title', 'Tambah ke Portofolio - SkillKul')

@section('content')
<div class="p-6 lg:p-10 max-w-2xl mx-auto transition-colors duration-300">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('freelancer.portfolio.index') }}" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Portofolio</a>
        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-gray-200 font-semibold">Tambah Proyek</span>
    </div>

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Tambahkan ke Portofolio</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review data project dan lengkapi informasi tambahan.</p>
    </div>

    {{-- Preview Order Card --}}
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-2xl p-5 mb-6 transition-colors">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-brand-primary dark:bg-indigo-600 rounded-xl flex items-center justify-center shrink-0 text-2xl shadow-sm">📦</div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-extrabold text-brand-primary dark:text-indigo-400 uppercase tracking-wider">Proyek</span>
                    <span class="text-[10px] text-gray-400 dark:text-gray-500">•</span>
                    <span class="text-[10px] text-gray-500 dark:text-gray-400">{{ $order->service->category?->name ?? '—' }}</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $order->service->title ?? 'Proyek' }}</h3>
                <div class="flex flex-wrap gap-4 mt-2 text-xs text-gray-600 dark:text-gray-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Klien: {{ $order->client->name ?? '—' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Selesai: {{ $order->completed_at?->format('d M Y') ?? '—' }}
                    </span>
                    @php
                        $duration = $order->completed_at && $order->created_at
                            ? max(1, (int) $order->created_at->diffInDays($order->completed_at))
                            : null;
                    @endphp
                    @if($duration)
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Durasi: {{ $duration }} Hari
                    </span>
                    @endif
                </div>
                @if($order->review)
                <div class="flex items-center gap-1 mt-2">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= $order->review->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">{{ $order->review->rating }}/5</span>
                    @if($order->review->comment)
                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 italic">"{{ Str::limit($order->review->comment, 60) }}"</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('freelancer.portfolio.store') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        {{-- Pekerja Lepas Role --}}
        <div>
            <label for="freelancer_role" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                Role Anda di Proyek Ini
                <span class="text-gray-400 dark:text-gray-500 font-normal">(Opsional)</span>
            </label>
            <input type="text"
                   id="freelancer_role"
                   name="freelancer_role"
                   value="{{ old('freelancer_role') }}"
                   placeholder="Contoh: UI/UX Designer, Backend Developer, Data Analyst..."
                   class="w-full bg-white dark:bg-brand-darksurface border border-gray-200 dark:border-brand-darkborder rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-transparent transition-all @error('freelancer_role') border-red-300 dark:border-red-500/50 focus:ring-red-500 @enderror">
            @error('freelancer_role')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Deskripsikan peran spesifik Anda dalam project ini.</p>
        </div>

        {{-- Cloud Link --}}
        <div>
            <label for="cloud_link" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                Link Hasil Kerja
                <span class="text-gray-400 dark:text-gray-500 font-normal">(Opsional)</span>
            </label>
            <input type="url"
                   id="cloud_link"
                   name="cloud_link"
                   value="{{ old('cloud_link', $order->freelancer_result_link) }}"
                   placeholder="https://drive.google.com/... atau https://figma.com/..."
                   class="w-full bg-white dark:bg-brand-darksurface border border-gray-200 dark:border-brand-darkborder rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-transparent transition-all @error('cloud_link') border-red-300 dark:border-red-500/50 focus:ring-red-500 @enderror">
            @error('cloud_link')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            @if($order->freelancer_result_link)
            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Pre-filled dari link hasil kerja yang Anda kirimkan ke client. Bisa diganti.</p>
            @endif
        </div>

        {{-- Info Box --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-xl p-4 flex gap-3 transition-colors">
            <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-xs font-bold text-blue-800 dark:text-blue-300 mb-1">Data yang akan ditampilkan di portfolio:</p>
                <ul class="text-xs text-blue-700 dark:text-blue-400 space-y-0.5 list-disc list-inside">
                    <li>Judul & deskripsi project (dari layanan)</li>
                    <li>Kategori project</li>
                    <li>Durasi pengerjaan (otomatis dari tanggal order)</li>
                    <li>Tanggal selesai</li>
                    <li>Rating & testimoni client</li>
                    <li>Role Anda & link hasil kerja (yang Anda isi di atas)</li>
                </ul>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-brand-primary dark:bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-brand-dark dark:hover:bg-indigo-500 transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Tambahkan ke Portofolio
            </button>
            <a href="{{ route('freelancer.portfolio.index') }}"
               class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
