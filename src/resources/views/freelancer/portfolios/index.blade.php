@extends('layouts.freelancer')
@section('title', 'Portfolio - SkillKul')
@section('content')
<div class="p-8 lg:p-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-brand-primary tracking-widest uppercase mb-3">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                AUTO-PORTFOLIO
            </span>
            <h1 class="text-3xl font-extrabold text-brand-dark tracking-tight mb-2">Portfolio Saya</h1>
            <p class="text-gray-500 text-sm max-w-xl">Portfolio PDF otomatis dari pesanan selesai dengan rating ≥ 4 bintang.</p>
        </div>
        <form action="{{ route('freelancer.portfolio.generate') }}" method="POST" class="mt-4 md:mt-0">
            @csrf
            <button type="submit" class="bg-[#0b0c54] text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg hover:bg-brand-dark transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Generate Portfolio PDF
            </button>
        </form>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-5 py-4 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('info') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100 rounded-2xl p-6 mb-8">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-brand-primary rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-brand-dark mb-1">Cara Kerja Auto-Portfolio</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Klik tombol <strong>"Generate Portfolio PDF"</strong> untuk membuat CV otomatis dari semua pesanan yang sudah selesai dengan rating ≥ 4 bintang. File PDF akan berisi daftar proyek, deskripsi, dan rating dari klien.
                </p>
            </div>
        </div>
    </div>

    {{-- Portfolio List --}}
    @if($portfolios->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center shadow-sm">
            <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-2xl flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Portfolio</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto mb-6">
                Selesaikan pesanan dan dapatkan rating ≥ 4 bintang dari klien, lalu klik "Generate Portfolio PDF" untuk membuat CV otomatis.
            </p>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Judul Proyek</th>
                        <th class="text-left px-6 py-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Rating</th>
                        <th class="text-left px-6 py-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Tanggal Selesai</th>
                        <th class="text-right px-6 py-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($portfolios as $portfolio)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $portfolio->project_title }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $portfolio->order?->service?->title ?? '–' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($portfolio->order?->review)
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $portfolio->order->review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endfor
                                        <span class="text-xs font-bold text-gray-700 ml-1">{{ $portfolio->order->review->rating }}/5</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">–</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $portfolio->completed_date?->format('d M Y') ?? '–' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('freelancer.portfolio.download', $portfolio->id) }}"
                                   class="inline-flex items-center gap-1.5 bg-indigo-50 text-brand-primary px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $portfolios->links() }}
        </div>
    @endif
</div>
@endsection
