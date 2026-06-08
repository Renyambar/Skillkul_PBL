<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Portofolio — {{ $freelancer->name }}</title>

    {{--
        PENTING: DomPDF tidak mendukung external CSS (Tailwind, Bootstrap, dll).
        Seluruh styling harus menggunakan INLINE CSS di sini.
        Hindari: flexbox, CSS grid, dan properti CSS modern lainnya.
        Gunakan: float, table layout, position absolute/relative.
    --}}

    <style>
        /* ─── Reset & Base ─────────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11px;
            color: #1e1b4b;
            line-height: 1.6;
            background: #ffffff;
        }

        /* ─── Header ────────────────────────────────────────────── */
        .header {
            background: #0b0c54;
            color: #ffffff;
            padding: 28px 36px;
        }
        .header-brand { font-size: 22px; font-weight: bold; letter-spacing: 1px; color: #c7d2fe; }
        .header-brand span { color: #818cf8; }
        .header-title { font-size: 15px; font-weight: bold; margin-top: 10px; color: #ffffff; }
        .header-meta { font-size: 10px; color: #a5b4fc; margin-top: 4px; }
        .accent-bar { height: 4px; background: #818cf8; }

        /* ─── Kontainer ─────────────────────────────────────────── */
        .container { padding: 28px 36px; }

        /* ─── Section Title ─────────────────────────────────────── */
        .section-title {
            font-size: 10px; font-weight: bold; text-transform: uppercase;
            letter-spacing: 2px; color: #6366f1;
            border-bottom: 1.5px solid #e0e7ff;
            padding-bottom: 5px; margin-bottom: 14px; margin-top: 22px;
        }

        /* ─── Info Table (Profil) ───────────────────────────────── */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        .info-table td { padding: 3px 0; font-size: 11px; vertical-align: top; }
        .info-label { color: #6b7280; width: 140px; }
        .info-value { font-weight: bold; color: #1e1b4b; }

        /* ─── Statistik ─────────────────────────────────────────── */
        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .stats-table td {
            width: 20%; text-align: center; padding: 12px 6px;
            border: 1px solid #e0e7ff; background: #f0f4ff;
        }
        .stats-number { font-size: 18px; font-weight: bold; color: #4338ca; display: block; }
        .stats-label { font-size: 9px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ─── Achievement Badges ────────────────────────────────── */
        .badge-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .badge-table td { padding: 6px 8px; border: 1px solid #e0e7ff; background: #f8f9ff; }
        .badge-icon { font-size: 16px; vertical-align: middle; }
        .badge-name { font-size: 10px; font-weight: bold; color: #1e1b4b; vertical-align: middle; margin-left: 4px; }
        .badge-date { font-size: 9px; color: #6b7280; }

        /* ─── Proyek Card ──────────────────────────────────────── */
        .project-card {
            border: 1px solid #e0e7ff;
            border-left: 4px solid #6366f1;
            border-radius: 4px;
            padding: 14px 16px;
            margin-bottom: 14px;
            background: #f8f9ff;
            page-break-inside: avoid;
        }
        .project-featured-bar {
            background: #f59e0b;
            color: #fff;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 2px 8px;
            margin-bottom: 8px;
            display: inline-block;
            border-radius: 2px;
        }
        .project-title { font-size: 13px; font-weight: bold; color: #1e1b4b; margin-bottom: 3px; }
        .project-role { font-size: 10px; color: #6366f1; font-weight: bold; margin-bottom: 5px; }
        .project-meta { font-size: 9px; color: #6b7280; margin-bottom: 8px; }
        .project-description { font-size: 10px; color: #4b5563; margin-bottom: 10px; line-height: 1.5; }

        /* ─── Rating ────────────────────────────────────────────── */
        .star { color: #fbbf24; font-size: 13px; }
        .star-empty { color: #d1d5db; font-size: 13px; }
        .rating-text { font-size: 9px; color: #6b7280; vertical-align: middle; margin-left: 4px; }

        /* ─── Testimonial ───────────────────────────────────────── */
        .comment-box {
            background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 3px;
            padding: 8px 10px; font-size: 10px; color: #1d4ed8; font-style: italic; margin-top: 6px;
        }
        .comment-client { font-size: 9px; color: #6b7280; margin-top: 4px; }

        /* ─── Cloud Link ────────────────────────────────────────── */
        .cloud-link { font-size: 9px; color: #4338ca; margin-top: 6px; }

        /* ─── Footer ────────────────────────────────────────────── */
        .footer {
            margin-top: 30px; padding-top: 12px;
            border-top: 1px solid #e0e7ff; text-align: center;
            font-size: 9px; color: #9ca3af;
        }
        .footer-brand { font-weight: bold; color: #6366f1; }

        /* ─── Nomor Halaman ─────────────────────────────────────── */
        .page-number {
            position: fixed; bottom: 20px; right: 36px;
            font-size: 9px; color: #9ca3af;
        }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-brand">Skill<span>Kul</span></div>
        <div class="header-title">Portofolio Pekerja Lepas Mahasiswa</div>
        <div class="header-meta">Dokumen ini di-generate secara otomatis oleh sistem SkillKul &bull; {{ $generated_at }}</div>
    </div>
    <div class="accent-bar"></div>

    <div class="container">

        {{-- ── Informasi Pekerja Lepas ── --}}
        <div class="section-title">Profil Pekerja Lepas</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Lengkap</td>
                <td class="info-value">{{ $freelancer->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Email</td>
                <td class="info-value">{{ $freelancer->email }}</td>
            </tr>
            @if($freelancer->phone_number)
            <tr>
                <td class="info-label">No. Telepon</td>
                <td class="info-value">{{ $freelancer->phone_number }}</td>
            </tr>
            @endif
            <tr>
                <td class="info-label">Tanggal Generate</td>
                <td class="info-value">{{ $generated_at }}</td>
            </tr>
            @if($freelancer->profile_description)
            <tr>
                <td class="info-label">Deskripsi Profil</td>
                <td class="info-value" style="font-weight: normal; color: #4b5563;">{{ $freelancer->profile_description }}</td>
            </tr>
            @endif
        </table>

        {{-- ── Statistik Ringkasan ── --}}
        <div class="section-title">Ringkasan Pencapaian</div>
        <table class="stats-table">
            <tr>
                <td>
                    <span class="stats-number">{{ $stats['total_completed'] }}</span>
                    <span class="stats-label">Proyek Selesai</span>
                </td>
                <td>
                    <span class="stats-number">{{ $stats['total_portfolio'] }}</span>
                    <span class="stats-label">Di Portofolio</span>
                </td>
                <td>
                    <span class="stats-number">{{ number_format($stats['avg_rating'], 1) }}</span>
                    <span class="stats-label">Avg Rating</span>
                </td>
                <td>
                    <span class="stats-number">{{ $stats['total_clients'] }}</span>
                    <span class="stats-label">Total Klien</span>
                </td>
                <td>
                    <span class="stats-number">{{ $stats['completion_rate'] }}%</span>
                    <span class="stats-label">Completion Rate</span>
                </td>
            </tr>
        </table>

        {{-- ── Achievement Badges ── --}}
        @php $achievements = $freelancer->achievements; @endphp
        @if($achievements->isNotEmpty())
        <div class="section-title">Pencapaian (Badges)</div>
        <table class="badge-table">
            <tr>
            @foreach($achievements as $index => $achievement)
                <td style="width: 20%;">
                    <div class="badge-icon">{{ $achievement->badge_icon }}</div>
                    <div class="badge-name">{{ $achievement->badge_label }}</div>
                    <div class="badge-date">{{ $achievement->earned_at->format('d M Y') }}</div>
                </td>
                @if(($index + 1) % 5 === 0 && !$loop->last)
                </tr><tr>
                @endif
            @endforeach
            </tr>
        </table>
        @endif

        {{-- ── Daftar Proyek ── --}}
        <div class="section-title">Proyek Experience ({{ $portfolios->count() }} Proyek)</div>

        @forelse($portfolios as $index => $portfolio)
        <div class="project-card">
            @if($portfolio->is_featured)
            <div class="project-featured-bar">&#9733; Featured Proyek</div>
            @endif

            {{-- Judul & Role --}}
            <div class="project-title">{{ ($index + 1) }}. {{ $portfolio->project_title }}</div>
            @if($portfolio->freelancer_role)
            <div class="project-role">{{ $portfolio->freelancer_role }}</div>
            @endif

            {{-- Meta --}}
            <div class="project-meta">
                @if($portfolio->project_category){{ $portfolio->project_category }} &bull; @endif
                Selesai: {{ $portfolio->completed_date?->format('d F Y') ?? '—' }}
                &nbsp;&bull;&nbsp;
                Durasi: {{ $portfolio->duration_label }}
                @if($portfolio->order?->client)&nbsp;&bull;&nbsp;Klien: {{ $portfolio->order->client->name }}@endif
            </div>

            {{-- Deskripsi --}}
            @if($portfolio->project_description)
            <div class="project-description">
                {{ \Illuminate\Support\Str::limit($portfolio->project_description, 250) }}
            </div>
            @endif

            {{-- Rating Bintang --}}
            @if($portfolio->client_rating)
            <div style="margin-top: 4px;">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $portfolio->client_rating)
                        <span class="star">&#9733;</span>
                    @else
                        <span class="star-empty">&#9733;</span>
                    @endif
                @endfor
                <span class="rating-text">{{ $portfolio->client_rating }}/5 — Dinilai oleh client</span>
            </div>
            @endif

            {{-- Testimonial --}}
            @if($portfolio->client_testimonial)
            <div class="comment-box">
                &ldquo;{{ $portfolio->client_testimonial }}&rdquo;
            </div>
            <div class="comment-client">
                — {{ $portfolio->order?->client?->name ?? 'Klien' }}
            </div>
            @endif

            {{-- Cloud Link --}}
            @if($portfolio->cloud_link)
            <div class="cloud-link">
                Link Hasil Kerja: {{ $portfolio->cloud_link }}
            </div>
            @endif
        </div>
        @empty
        <p style="color: #6b7280; font-style: italic; font-size: 11px;">Belum ada project yang ditambahkan ke portfolio.</p>
        @endforelse

    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        <p>Dokumen ini diterbitkan oleh <span class="footer-brand">SkillKul — Marketplace Jasa Mahasiswa</span></p>
        <p style="margin-top: 3px;">Generated on {{ $generated_at }} &bull; Verifikasi keaslian di <strong>skillkul.id</strong></p>
    </div>

    {{-- Nomor Halaman DomPDF --}}
    <div class="page-number">Halaman <span class="pagenum"></span></div>

</body>
</html>
