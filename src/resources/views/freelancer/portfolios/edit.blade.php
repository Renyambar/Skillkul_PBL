@extends('layouts.freelancer')
@section('title', 'Edit Portofolio - SkillKul')

@section('content')
<div class="p-6 lg:p-10 max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('freelancer.portfolio.index') }}" class="hover:text-indigo-600 transition-colors">Portofolio</a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-semibold">Edit Portofolio</span>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Edit Portofolio</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi tambahan untuk project ini.</p>
    </div>

    {{-- Proyek Info (readonly) --}}
    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 mb-6">
        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider mb-2">Proyek</p>
        <h3 class="text-base font-bold text-gray-900">{{ $portfolio->project_title }}</h3>
        <div class="flex flex-wrap gap-4 mt-2 text-xs text-gray-500">
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
            <label for="freelancer_role" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Role Anda di Proyek Ini
                <span class="text-gray-400 font-normal">(Opsional)</span>
            </label>
            <input type="text"
                   id="freelancer_role"
                   name="freelancer_role"
                   value="{{ old('freelancer_role', $portfolio->freelancer_role) }}"
                   placeholder="Contoh: UI/UX Designer, Backend Developer..."
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('freelancer_role') border-red-300 @enderror">
            @error('freelancer_role')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Cloud Link --}}
        <div>
            <label for="cloud_link" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Link Hasil Kerja
                <span class="text-gray-400 font-normal">(Opsional)</span>
            </label>
            <input type="url"
                   id="cloud_link"
                   name="cloud_link"
                   value="{{ old('cloud_link', $portfolio->cloud_link) }}"
                   placeholder="https://drive.google.com/..."
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('cloud_link') border-red-300 @enderror">
            @error('cloud_link')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                Simpan Perubahan
            </button>
            <a href="{{ route('freelancer.portfolio.index') }}"
               class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
