@extends('layouts.freelancer')
@section('title', 'Portofolio Saya - SkillKul')

@section('content')
<div class="p-6 lg:p-10 space-y-8 transition-colors duration-300">

    {{-- ══════════════════════════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Sistem Portofolio Proyek
            </span>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Portofolio Saya</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola dan tampilkan karya terbaik Anda kepada dunia.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Link ke halaman publik --}}
            <a href="{{ route('portfolio.public', str_replace(' ', '-', strtolower(auth()->user()->name))) }}"
               target="_blank"
               class="inline-flex items-center gap-2 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Publik
            </a>
            {{-- Generate PDF --}}
            <form action="{{ route('freelancer.portfolio.generatePdf') }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 dark:bg-indigo-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Generate PDF
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         FLASH MESSAGES
    ══════════════════════════════════════════════════════════════ --}}
    @foreach(['success' => 'green', 'error' => 'red', 'info' => 'blue', 'warning' => 'yellow'] as $type => $color)
        @if(session($type))
        <div class="flex items-start gap-3 bg-{{ $color }}-50 dark:bg-{{ $color }}-900/20 border border-{{ $color }}-200 dark:border-{{ $color }}-800/50 text-{{ $color }}-800 dark:text-{{ $color }}-400 px-5 py-4 rounded-xl text-sm transition-colors">
            <svg class="w-5 h-5 shrink-0 mt-0.5 text-{{ $color }}-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            <span>{{ session($type) }}</span>
        </div>
        @if(session('pdf_path'))
        <div class="mt-2">
            <a href="{{ route('freelancer.portfolio.downloadLatest') }}"
               class="inline-flex items-center gap-2 bg-green-600 dark:bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700 dark:hover:bg-green-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh PDF Portofolio
            </a>
        </div>
        @endif
        @endif
    @endforeach

    {{-- ══════════════════════════════════════════════════════════════
         STATISTICS BAR
    ══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @php
            $statItems = [
                ['label' => 'Proyek Selesai',    'value' => $stats['total_completed'],  'icon' => '✅', 'color' => 'green'],
                ['label' => 'Di Portofolio',        'value' => $stats['total_portfolio'],  'icon' => '📁', 'color' => 'indigo'],
                ['label' => 'Rata-rata Rating',    'value' => number_format($stats['avg_rating'], 1) . '★', 'icon' => '⭐', 'color' => 'yellow'],
                ['label' => 'Total Klien',        'value' => $stats['total_clients'],    'icon' => '👤', 'color' => 'blue'],
                ['label' => 'Completion Rate',     'value' => $stats['completion_rate'] . '%', 'icon' => '📈', 'color' => 'purple'],
            ];
        @endphp
        @foreach($statItems as $stat)
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder p-4 text-center shadow-sm hover:shadow-md transition-all">
            <div class="text-2xl mb-1">{{ $stat['icon'] }}</div>
            <div class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $stat['value'] }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ACHIEVEMENT BADGES
    ══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-2xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 transition-colors">
        <h3 class="text-sm font-extrabold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <span>🏅</span> Pencapaian
            <span class="text-xs font-normal text-gray-400 dark:text-gray-500">(Hanya dari project-based services)</span>
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @foreach($allBadges as $key => $badge)
            @php $unlocked = in_array($key, $unlockedBadgeKeys); @endphp
            <div class="relative rounded-xl border-2 p-3 text-center transition-all {{ $unlocked ? 'border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/30' : 'border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50 opacity-60' }}">
                @if($unlocked)
                <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                @endif
                <div class="text-3xl mb-1">{{ $badge['icon'] }}</div>
                <div class="text-xs font-bold {{ $unlocked ? 'text-gray-800 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }} leading-tight">{{ $badge['label'] }}</div>
                <div class="text-[10px] {{ $unlocked ? 'text-gray-500 dark:text-gray-400' : 'text-gray-400 dark:text-gray-500' }} mt-1 leading-tight">{{ $badge['description'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ELIGIBLE ORDERS (Bisa ditambahkan ke portfolio)
    ══════════════════════════════════════════════════════════════ --}}
    @if($eligibleOrders->isNotEmpty())
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-2xl p-6 transition-colors">
        <h3 class="text-sm font-extrabold text-indigo-900 dark:text-indigo-300 mb-1 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $eligibleOrders->count() }} Proyek Siap Ditambahkan ke Portofolio
        </h3>
        <p class="text-xs text-indigo-700 dark:text-indigo-400 mb-4">Order dari layanan bertipe <strong>Proyek</strong> yang sudah selesai dan belum ada di portfolio Anda.</p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($eligibleOrders as $order)
            <div class="bg-white dark:bg-brand-darksurface rounded-xl border border-indigo-100 dark:border-indigo-800/50 p-4 flex items-start gap-3 transition-colors">
                <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center shrink-0 text-lg">📦</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $order->service->title ?? 'Proyek' }}</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400">{{ $order->service->category?->name ?? '—' }}</p>
                    @if($order->review)
                    <div class="flex items-center gap-1 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3 h-3 {{ $i <= $order->review->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                        <span class="text-[10px] text-gray-500 dark:text-gray-400">{{ $order->review->rating }}/5</span>
                    </div>
                    @endif
                    <p class="text-[10px] text-gray-400 mt-1">Selesai: {{ $order->completed_at?->format('d M Y') ?? '—' }}</p>
                </div>
                <a href="{{ route('freelancer.portfolio.create', $order->id) }}"
                   class="shrink-0 inline-flex items-center gap-1 bg-indigo-600 dark:bg-indigo-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors">
                    + Tambah
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         PORTFOLIO GRID
    ══════════════════════════════════════════════════════════════ --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Proyek Portofolio
            </h3>
            <span class="text-xs text-gray-400 dark:text-gray-500">Total: {{ $portfolios->total() }} proyek</span>
        </div>

        @if($portfolios->isEmpty())
        <div class="bg-white dark:bg-brand-darksurface rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 p-16 text-center transition-colors">
            <div class="text-5xl mb-4">📂</div>
            <h3 class="text-base font-bold text-gray-700 dark:text-gray-300 mb-1">Belum Ada Portofolio</h3>
            <p class="text-sm text-gray-400 dark:text-gray-500 max-w-sm mx-auto">Selesaikan pesanan proyek dan tambahkan ke portofolio dari daftar di atas.</p>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($portfolios as $portfolio)
            <div class="bg-white dark:bg-brand-darksurface rounded-2xl border {{ $portfolio->is_featured ? 'border-yellow-300 dark:border-yellow-600 shadow-yellow-50 dark:shadow-yellow-900/20' : ($portfolio->is_portfolio ? 'border-gray-100 dark:border-brand-darkborder' : 'border-dashed border-gray-200 dark:border-gray-700 opacity-70') }} shadow-sm hover:shadow-md transition-all overflow-hidden group">
                {{-- Featured Badge --}}
                @if($portfolio->is_featured)
                <div class="bg-gradient-to-r from-yellow-400 to-orange-400 dark:from-yellow-600 dark:to-orange-600 px-3 py-1.5 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="text-white text-[10px] font-extrabold uppercase tracking-wider">Featured</span>
                </div>
                @endif

                <div class="p-5">
                    {{-- Status indicator --}}
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full {{ $portfolio->is_portfolio ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $portfolio->is_portfolio ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ $portfolio->is_portfolio ? 'Publik' : 'Tersembunyi' }}
                        </span>
                        @if($portfolio->project_category)
                        <span class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">{{ $portfolio->project_category }}</span>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1 line-clamp-2">{{ $portfolio->project_title }}</h4>

                    @if($portfolio->freelancer_role)
                    <p class="text-[11px] text-indigo-600 dark:text-indigo-400 font-semibold mb-2">{{ $portfolio->freelancer_role }}</p>
                    @endif

                    @if($portfolio->project_description)
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-3">{{ $portfolio->project_description }}</p>
                    @endif

                    {{-- Meta info --}}
                    <div class="flex flex-wrap gap-3 text-[10px] text-gray-500 dark:text-gray-400 mb-3">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $portfolio->completed_date?->format('d M Y') ?? '—' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $portfolio->duration_label }}
                        </span>
                    </div>

                    {{-- Rating --}}
                    @if($portfolio->client_rating)
                    <div class="flex items-center gap-1 mb-3">
                        @foreach($portfolio->rating_stars as $filled)
                        <svg class="w-3.5 h-3.5 {{ $filled ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endforeach
                        <span class="text-[10px] text-gray-500 dark:text-gray-400 ml-1">{{ $portfolio->client_rating }}/5</span>
                    </div>
                    @endif

                    @if($portfolio->client_testimonial)
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 italic line-clamp-2 mb-3 border-l-2 border-indigo-200 dark:border-indigo-800/50 pl-2">"{{ $portfolio->client_testimonial }}"</p>
                    @endif

                    {{-- Cloud link --}}
                    @if($portfolio->cloud_link)
                    <a href="{{ $portfolio->cloud_link }}" target="_blank"
                       class="inline-flex items-center gap-1 text-[10px] text-indigo-600 dark:text-indigo-400 font-semibold hover:underline mb-3">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Hasil Pekerjaan
                    </a>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="pt-3 border-t border-gray-50 dark:border-gray-800/50 flex items-center gap-2 flex-wrap">
                        {{-- Toggle Visibility --}}
                        <form action="{{ route('freelancer.portfolio.toggleVisibility', $portfolio->id) }}" method="POST">
                            @csrf
                            <button type="submit" title="{{ $portfolio->is_portfolio ? 'Sembunyikan' : 'Tampilkan' }}"
                                    class="inline-flex items-center gap-1 text-xs px-2.5 py-1.5 rounded-lg font-semibold transition-colors {{ $portfolio->is_portfolio ? 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                                @if($portfolio->is_portfolio)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Publik
                                @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                Tersembunyi
                                @endif
                            </button>
                        </form>

                        {{-- Toggle Featured --}}
                        @if($portfolio->is_portfolio)
                        <form action="{{ route('freelancer.portfolio.toggleFeatured', $portfolio->id) }}" method="POST">
                            @csrf
                            <button type="submit" title="{{ $portfolio->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}"
                                    class="inline-flex items-center gap-1 text-xs px-2.5 py-1.5 rounded-lg font-semibold transition-colors {{ $portfolio->is_featured ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-500 hover:bg-yellow-100 dark:hover:bg-yellow-900/40' : 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-700 dark:hover:text-yellow-500' }}">
                                <svg class="w-3.5 h-3.5" fill="{{ $portfolio->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                Unggulan
                            </button>
                        </form>
                        @endif

                        {{-- Edit --}}
                        <a href="{{ route('freelancer.portfolio.edit', $portfolio->id) }}"
                           class="inline-flex items-center gap-1 text-xs px-2.5 py-1.5 rounded-lg font-semibold bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>

                        {{-- Hapus --}}
                        <form action="{{ route('freelancer.portfolio.destroy', $portfolio->id) }}" method="POST"
                               onsubmit="return confirm('Hapus proyek ini dari portofolio?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 text-xs px-2.5 py-1.5 rounded-lg font-semibold bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($portfolios->hasPages())
        <div class="mt-6 dark:text-gray-300">{{ $portfolios->links() }}</div>
        @endif
        @endif
    </div>

</div>
@endsection
