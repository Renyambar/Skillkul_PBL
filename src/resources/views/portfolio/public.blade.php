<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portofolio {{ $freelancer->name }} — Pekerja Lepas mahasiswa di SkillKul. {{ $stats['total_completed'] }} project selesai, rating rata-rata {{ number_format($stats['avg_rating'], 1) }}/5.">
    <title>Portofolio {{ $freelancer->name }} — SkillKul</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, #0b0c54 0%, #1e1b6e 40%, #312e81 70%, #4338ca 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .featured-glow {
            box-shadow: 0 0 0 2px #f59e0b, 0 20px 40px rgba(245, 158, 11, 0.15);
        }
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

{{-- ══════════════════════════════════════════════════════════════
     HERO — PROFIL FREELANCER
══════════════════════════════════════════════════════════════ --}}
<section class="hero-gradient relative overflow-hidden">
    {{-- Decorative circles --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-indigo-400/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-6 py-20">
        {{-- Brand --}}
        <div class="flex items-center gap-2 mb-10">
            <a href="{{ route('home') }}" class="text-indigo-300 text-sm font-semibold hover:text-white transition-colors">SkillKul</a>
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/60 text-sm">Portofolio</span>
        </div>

        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            {{-- Avatar --}}
            <div class="shrink-0">
                @if($freelancer->profile_photo_path)
                <img src="{{ Storage::url($freelancer->profile_photo_path) }}"
                     alt="{{ $freelancer->name }}"
                     class="w-28 h-28 rounded-2xl object-cover ring-4 ring-white/20">
                @else
                <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center ring-4 ring-white/20">
                    <span class="text-4xl font-extrabold text-white">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 text-center md:text-left">
                <span class="inline-block text-[10px] font-extrabold text-indigo-300 uppercase tracking-widest mb-2">Pekerja Lepas Mahasiswa</span>
                <h1 class="text-4xl font-extrabold text-white mb-2">{{ $freelancer->name }}</h1>

                @if($freelancer->profile_description)
                <p class="text-indigo-200 text-base leading-relaxed max-w-xl mb-4">{{ $freelancer->profile_description }}</p>
                @endif

                {{-- Skills Tags --}}
                @if($skills->isNotEmpty())
                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                    @foreach($skills as $skill)
                    <span class="glass-card px-3 py-1 rounded-full text-xs font-semibold text-indigo-200">{{ $skill }}</span>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Quick Stats --}}
            <div class="glass-card rounded-2xl p-5 text-center min-w-[160px]">
                <div class="text-3xl font-extrabold text-white">{{ number_format($stats['avg_rating'], 1) }}</div>
                <div class="flex justify-center my-1">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= round($stats['avg_rating']) ? 'text-yellow-400' : 'text-white/20' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <div class="text-xs text-indigo-300">Rating Rata-rata</div>
                <div class="mt-3 pt-3 border-t border-white/10">
                    <div class="text-2xl font-extrabold text-white">{{ $stats['total_completed'] }}</div>
                    <div class="text-xs text-indigo-300">Proyek Selesai</div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-5xl mx-auto px-6 py-10 space-y-14">

    {{-- ══════════════════════════════════════════════════════════════
         STATISTICS
    ══════════════════════════════════════════════════════════════ --}}
    <section>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $pubStats = [
                    ['label' => 'Proyek Selesai',  'value' => $stats['total_completed'],  'color' => 'indigo'],
                    ['label' => 'Portofolio Publik',  'value' => $stats['total_portfolio'],  'color' => 'purple'],
                    ['label' => 'Total Klien',      'value' => $stats['total_clients'],    'color' => 'blue'],
                    ['label' => 'Completion Rate',   'value' => $stats['completion_rate'] . '%', 'color' => 'green'],
                ];
            @endphp
            @foreach($pubStats as $stat)
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm card-hover">
                <div class="text-3xl font-extrabold text-{{ $stat['color'] }}-600 mb-1">{{ $stat['value'] }}</div>
                <div class="text-xs text-gray-500 font-medium">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ACHIEVEMENTS
    ══════════════════════════════════════════════════════════════ --}}
    @if($achievements->isNotEmpty())
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center text-lg">🏅</div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Pencapaian</h2>
                <p class="text-sm text-gray-500">Badge yang telah diraih melalui project-based services</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($achievements as $achievement)
            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-sm card-hover">
                <span class="text-2xl">{{ $achievement->badge_icon }}</span>
                <div>
                    <p class="text-sm font-bold text-gray-900">{{ $achievement->badge_label }}</p>
                    <p class="text-[10px] text-gray-400">{{ $achievement->earned_at->format('d M Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         FEATURED PROJECTS
    ══════════════════════════════════════════════════════════════ --}}
    @if($featuredPortfolios->isNotEmpty())
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Featured Projects</h2>
                <p class="text-sm text-gray-500">Karya terbaik yang dipilih freelancer</p>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($featuredPortfolios as $portfolio)
            <div class="bg-white rounded-2xl overflow-hidden featured-glow card-hover">
                <div class="bg-gradient-to-r from-yellow-400 to-orange-400 px-4 py-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="text-white text-xs font-extrabold uppercase tracking-wider">Featured</span>
                </div>
                <div class="p-5">
                    @if($portfolio->project_category)
                    <span class="inline-block text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full mb-2">{{ $portfolio->project_category }}</span>
                    @endif
                    <h3 class="text-base font-bold text-gray-900 mb-1">{{ $portfolio->project_title }}</h3>
                    @if($portfolio->freelancer_role)
                    <p class="text-xs text-indigo-600 font-semibold mb-2">{{ $portfolio->freelancer_role }}</p>
                    @endif
                    @if($portfolio->project_description)
                    <p class="text-sm text-gray-500 line-clamp-3 mb-4">{{ $portfolio->project_description }}</p>
                    @endif
                    <div class="flex flex-wrap gap-3 text-[10px] text-gray-500 mb-4">
                        <span class="flex items-center gap-1">📅 {{ $portfolio->completed_date?->format('d M Y') }}</span>
                        <span class="flex items-center gap-1">⏱️ {{ $portfolio->duration_label }}</span>
                    </div>
                    @if($portfolio->client_rating)
                    <div class="flex items-center gap-1 mb-3">
                        @foreach($portfolio->rating_stars as $filled)
                        <svg class="w-4 h-4 {{ $filled ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endforeach
                        <span class="text-xs font-bold text-gray-700 ml-1">{{ $portfolio->client_rating }}/5</span>
                    </div>
                    @endif
                    @if($portfolio->cloud_link)
                    <a href="{{ $portfolio->cloud_link }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:underline">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Hasil Kerja
                    </a>
                    @endif
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
            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-lg">📁</div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Proyek Portofolio</h2>
                <p class="text-sm text-gray-500">Semua project yang telah diselesaikan</p>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach($allPortfolios as $portfolio)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden card-hover">
                <div class="p-5">
                    @if($portfolio->project_category)
                    <span class="inline-block text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full mb-2">{{ $portfolio->project_category }}</span>
                    @endif
                    <h3 class="text-sm font-bold text-gray-900 mb-1 line-clamp-2">{{ $portfolio->project_title }}</h3>
                    @if($portfolio->freelancer_role)
                    <p class="text-[11px] text-indigo-600 font-semibold mb-2">{{ $portfolio->freelancer_role }}</p>
                    @endif
                    @if($portfolio->project_description)
                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $portfolio->project_description }}</p>
                    @endif
                    <div class="flex flex-wrap gap-2 text-[10px] text-gray-400 mb-3">
                        <span>📅 {{ $portfolio->completed_date?->format('d M Y') }}</span>
                        <span>⏱️ {{ $portfolio->duration_label }}</span>
                    </div>
                    @if($portfolio->client_rating)
                    <div class="flex items-center gap-0.5 mb-2">
                        @foreach($portfolio->rating_stars as $filled)
                        <svg class="w-3.5 h-3.5 {{ $filled ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endforeach
                        <span class="text-xs text-gray-500 ml-1">{{ $portfolio->client_rating }}/5</span>
                    </div>
                    @endif
                    @if($portfolio->cloud_link)
                    <a href="{{ $portfolio->cloud_link }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 hover:underline">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Hasil Kerja
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @if($allPortfolios->hasPages())
        <div class="mt-8 flex justify-center">{{ $allPortfolios->links() }}</div>
        @endif
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         CLIENT TESTIMONIALS
    ══════════════════════════════════════════════════════════════ --}}
    @if($testimonials->isNotEmpty())
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center text-lg">💬</div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Testimoni Klien</h2>
                <p class="text-sm text-gray-500">Apa kata client tentang pekerjaan freelancer ini</p>
            </div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 card-hover">
                {{-- Quote --}}
                <div class="text-3xl text-indigo-200 font-serif leading-none mb-2">"</div>
                <p class="text-sm text-gray-700 italic leading-relaxed mb-4">{{ $testimonial->client_testimonial }}</p>

                {{-- Rating --}}
                @if($testimonial->client_rating)
                <div class="flex items-center gap-0.5 mb-3">
                    @foreach($testimonial->rating_stars as $filled)
                    <svg class="w-3.5 h-3.5 {{ $filled ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endforeach
                </div>
                @endif

                {{-- Klien info --}}
                <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                    <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-xs font-bold text-indigo-600">
                        {{ strtoupper(substr($testimonial->order?->client?->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-700">{{ $testimonial->order?->client?->name ?? 'Klien' }}</p>
                        <p class="text-[10px] text-gray-400">{{ $testimonial->project_title }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         EMPTY STATE
    ══════════════════════════════════════════════════════════════ --}}
    @if($allPortfolios->isEmpty() && $featuredPortfolios->isEmpty())
    <div class="text-center py-20">
        <div class="text-6xl mb-4">📂</div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">Portofolio Masih Kosong</h3>
        <p class="text-gray-400 text-sm">Pekerja Lepas ini belum menambahkan project ke portfolio publik.</p>
    </div>
    @endif

</div>

{{-- ══════════════════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════════════════ --}}
<footer class="bg-white border-t border-gray-100 py-8 mt-14">
    <div class="max-w-5xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="text-indigo-600 font-extrabold text-lg">SkillKul</span>
            <span class="text-gray-400 text-sm">— Lokapasar Jasa Mahasiswa</span>
        </div>
        <a href="{{ route('katalog') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-colors">
            Pesan Jasa Ini
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</footer>

</body>
</html>
