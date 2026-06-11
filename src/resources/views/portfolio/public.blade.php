<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portofolio {{ $freelancer->name }} — Pekerja Lepas Mahasiswa di SkillKul. {{ $stats['total_completed'] }} proyek selesai, penilaian rata-rata {{ number_format($stats['avg_rating'], 1) }}/5.">
    <title>Portofolio {{ $freelancer->name }} — SkillKul</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        .badge-featured {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

{{-- ══════════════════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════════════════ --}}
<section class="hero-bg relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-6 py-16 lg:py-24 relative z-10">
        
        {{-- Breadcrumb Navigation --}}
        <div class="flex items-center gap-2 mb-8">
            <a href="{{ route('home') }}" class="text-blue-300 text-sm font-medium hover:text-white transition-colors">SkillKul</a>
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-300 text-sm">Portofolio</span>
        </div>

        <div class="flex flex-col md:flex-row items-center md:items-start gap-8 lg:gap-12">
            {{-- Avatar Profile --}}
            <div class="shrink-0">
                @if($freelancer->profile_photo_path)
                <img src="{{ Storage::url($freelancer->profile_photo_path) }}"
                     alt="{{ $freelancer->name }}"
                     class="w-32 h-32 rounded-2xl object-cover ring-4 ring-white/10 shadow-xl">
                @else
                <div class="w-32 h-32 rounded-2xl bg-blue-600 flex items-center justify-center ring-4 ring-white/10 shadow-xl">
                    <span class="text-5xl font-bold text-white">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
                </div>
                @endif
            </div>

            {{-- Freelancer Details --}}
            <div class="flex-1 text-center md:text-left">
                <span class="inline-block px-3 py-1 bg-blue-500/20 text-blue-200 text-xs font-semibold uppercase tracking-wider rounded-full mb-3">
                    Freelancer Mahasiswa
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">{{ $freelancer->name }}</h1>
                
                @if($freelancer->profile_description)
                <p class="text-slate-300 text-base md:text-lg leading-relaxed max-w-2xl mb-6">
                    {{ $freelancer->profile_description }}
                </p>
                @endif

                {{-- Skills/Tags --}}
                @if($skills->isNotEmpty())
                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                    @foreach($skills as $skill)
                    <span class="glass-panel px-4 py-1.5 rounded-full text-xs font-medium text-slate-100">
                        {{ $skill }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- High-Level Stats Panel --}}
            <div class="glass-panel rounded-2xl p-6 text-center min-w-[180px] shrink-0">
                <div class="text-4xl font-extrabold text-white mb-1">{{ number_format($stats['avg_rating'], 1) }}</div>
                <div class="flex justify-center gap-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($stats['avg_rating']) ? 'text-yellow-400' : 'text-slate-500/50' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <div class="text-xs text-blue-200 font-medium uppercase tracking-wide">Rating Klien</div>
                
                <div class="mt-4 pt-4 border-t border-white/10">
                    <div class="text-2xl font-bold text-white">{{ $stats['total_completed'] }}</div>
                    <div class="text-xs text-blue-200 font-medium">Proyek Diselesaikan</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Main Content Container --}}
<div class="max-w-5xl mx-auto px-6 py-12 space-y-16">

    {{-- ══════════════════════════════════════════════════════════════
         PERFORMANCE STATISTICS
    ══════════════════════════════════════════════════════════════ --}}
    <section>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @php
                $pubStats = [
                    ['label' => 'Total Proyek', 'value' => $stats['total_completed'], 'color' => 'text-blue-600'],
                    ['label' => 'Portofolio', 'value' => $stats['total_portfolio'], 'color' => 'text-indigo-600'],
                    ['label' => 'Klien Unik', 'value' => $stats['total_clients'], 'color' => 'text-emerald-600'],
                    ['label' => 'Sukses Rate', 'value' => $stats['completion_rate'] . '%', 'color' => 'text-slate-800'],
                ];
            @endphp
            @foreach($pubStats as $stat)
            <div class="bg-white rounded-xl border border-slate-200 p-6 text-center card-hover">
                <div class="text-3xl font-extrabold {{ $stat['color'] }} mb-2">{{ $stat['value'] }}</div>
                <div class="text-sm text-slate-500 font-medium">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ACHIEVEMENTS BADGES
    ══════════════════════════════════════════════════════════════ --}}
    @if($achievements->isNotEmpty())
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Pencapaian</h2>
                <p class="text-sm text-slate-500">Lencana yang diraih dari performa luar biasa</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-4">
            @foreach($achievements as $achievement)
            <div class="bg-white border border-slate-200 rounded-xl px-5 py-3 flex items-center gap-4 card-hover">
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ $achievement->badge_label }}</p>
                    <p class="text-[11px] text-slate-400 font-medium">{{ $achievement->earned_at->format('M Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         FEATURED PORTFOLIO
    ══════════════════════════════════════════════════════════════ --}}
    @if($featuredPortfolios->isNotEmpty())
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Karya Unggulan</h2>
                <p class="text-sm text-slate-500">Proyek terbaik pilihan freelancer</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredPortfolios as $portfolio)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 card-hover flex flex-col h-full">
                <div class="badge-featured px-5 py-2.5 flex items-center gap-2">
                    <span class="text-white text-[11px] font-bold uppercase tracking-wider">Unggulan</span>
                </div>
                
                <div class="p-6 flex flex-col flex-1">
                    @if($portfolio->project_category)
                    <span class="inline-block text-[11px] font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-md mb-3 self-start">
                        {{ $portfolio->project_category }}
                    </span>
                    @endif
                    
                    <h3 class="text-lg font-bold text-slate-900 mb-1 leading-tight">{{ $portfolio->project_title }}</h3>
                    
                    @if($portfolio->freelancer_role)
                    <p class="text-sm text-slate-500 font-medium mb-3">{{ $portfolio->freelancer_role }}</p>
                    @endif
                    
                    @if($portfolio->project_description)
                    <p class="text-sm text-slate-600 line-clamp-3 mb-5 flex-1">{{ $portfolio->project_description }}</p>
                    @endif
                    
                    <div class="mt-auto">
                        <div class="flex items-center justify-between border-t border-slate-100 pt-4 mt-4">
                            <div class="flex items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $portfolio->completed_date?->format('M Y') }}
                                </span>
                            </div>
                            
                            @if($portfolio->cloud_link)
                            <a href="{{ $portfolio->cloud_link }}" target="_blank" rel="noopener" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                Lihat Detail &rarr;
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         ALL PORTFOLIO PROJECTS
    ══════════════════════════════════════════════════════════════ --}}
    @if($allPortfolios->isNotEmpty())
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Riwayat Proyek</h2>
                <p class="text-sm text-slate-500">Semua pekerjaan yang telah dipublikasikan</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($allPortfolios as $portfolio)
            <div class="bg-white rounded-xl border border-slate-200 p-5 card-hover flex flex-col">
                <div class="flex justify-between items-start mb-3">
                    @if($portfolio->project_category)
                    <span class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded">
                        {{ $portfolio->project_category }}
                    </span>
                    @endif
                    <span class="text-[11px] text-slate-400 font-medium">
                        {{ $portfolio->completed_date?->format('M Y') }}
                    </span>
                </div>
                
                <h3 class="text-base font-bold text-slate-800 mb-1 line-clamp-2">{{ $portfolio->project_title }}</h3>
                <p class="text-xs text-blue-600 font-medium mb-3">{{ $portfolio->freelancer_role ?? 'Freelancer' }}</p>
                
                @if($portfolio->project_description)
                <p class="text-sm text-slate-600 line-clamp-2 mb-4 flex-1">{{ $portfolio->project_description }}</p>
                @endif
                
                <div class="mt-auto border-t border-slate-100 pt-3">
                    @if($portfolio->cloud_link)
                    <a href="{{ $portfolio->cloud_link }}" target="_blank" rel="noopener" class="text-xs font-semibold text-blue-600 hover:underline">
                        Tautan Proyek
                    </a>
                    @else
                    <span class="text-xs text-slate-400">Tautan tidak tersedia</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($allPortfolios->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $allPortfolios->links() }}
        </div>
        @endif
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         EMPTY STATE
    ══════════════════════════════════════════════════════════════ --}}
    @if($allPortfolios->isEmpty() && $featuredPortfolios->isEmpty())
    <div class="text-center py-24 bg-white rounded-2xl border border-slate-200">
        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Portofolio</h3>
        <p class="text-slate-500 text-sm">Freelancer ini belum menambahkan riwayat proyek ke publik.</p>
    </div>
    @endif

</div>

{{-- ══════════════════════════════════════════════════════════════
     FOOTER CTA
══════════════════════════════════════════════════════════════ --}}
<footer class="bg-white border-t border-slate-200 py-8 mt-12">
    <div class="max-w-5xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="text-center sm:text-left">
            <span class="text-blue-700 font-bold text-xl block sm:inline">SkillKul</span>
            <span class="text-slate-500 text-sm hidden sm:inline ml-2 border-l border-slate-300 pl-2">Marketplace Jasa Mahasiswa</span>
        </div>
        <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm">
            Mulai Pesan Jasa
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</footer>

</body>
</html>