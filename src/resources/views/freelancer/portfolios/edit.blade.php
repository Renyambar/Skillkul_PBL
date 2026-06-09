@extends('layouts.freelancer')
@section('title', 'Edit Portofolio - SkillKul')

@section('content')
<div class="p-6 lg:p-10 max-w-2xl mx-auto transition-colors duration-300">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('freelancer.portfolio.index') }}" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Portofolio</a>
        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-gray-200 font-semibold">Edit Portofolio</span>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Edit Portofolio</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui informasi tambahan untuk proyek ini.</p>
    </div>

    {{-- Proyek Info (readonly) --}}
    <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 rounded-2xl p-5 mb-6 transition-colors">
        <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Proyek</p>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $portfolio->project_title }}</h3>
        <div class="flex flex-wrap gap-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
            @if($portfolio->project_category)
            <span>📁 {{ $portfolio->project_category }}</span>
            @endif
            <span>📅 Selesai: {{ $portfolio->completed_date?->format('d M Y') ?? '—' }}</span>
            <span>⏱️ {{ $portfolio->duration_label }}</span>
            @if($portfolio->client_rating)
            <span>⭐ Rating: {{ $portfolio->client_rating }}/5</span>
            @endif
        </div>
    </div>

    <form action="{{ route('freelancer.portfolio.update', $portfolio->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Pekerja Lepas Role --}}
        <div>
            <label for="freelancer_role" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                Peran Anda di Proyek Ini
                <span class="text-gray-400 dark:text-gray-500 font-normal">(Opsional)</span>
            </label>
            <input type="text"
                   id="freelancer_role"
                   name="freelancer_role"
                   value="{{ old('freelancer_role', $portfolio->freelancer_role) }}"
                   placeholder="Contoh: UI/UX Designer, Backend Developer..."
                   class="w-full bg-white dark:bg-brand-darksurface border border-gray-200 dark:border-brand-darkborder rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-transparent transition-all @error('freelancer_role') border-red-300 dark:border-red-500/50 focus:ring-red-500 @enderror">
            @error('freelancer_role')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Cloud Link --}}
        <div>
            <label for="cloud_link" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                Tautan Hasil Pekerjaan
                <span class="text-gray-400 dark:text-gray-500 font-normal">(Opsional)</span>
            </label>
            <input type="url"
                   id="cloud_link"
                   name="cloud_link"
                   value="{{ old('cloud_link', $portfolio->cloud_link) }}"
                   placeholder="https://drive.google.com/..."
                   class="w-full bg-white dark:bg-brand-darksurface border border-gray-200 dark:border-brand-darkborder rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 focus:border-transparent transition-all @error('cloud_link') border-red-300 dark:border-red-500/50 focus:ring-red-500 @enderror">
            @error('cloud_link')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-brand-primary dark:bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-brand-dark dark:hover:bg-indigo-500 transition-all">
                Simpan Perubahan
            </button>
            <a href="{{ route('freelancer.portfolio.index') }}"
               class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
