<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Portfolio - {{ $freelancer->name }}</title>

    {{--
        PENTING: DomPDF tidak mendukung external CSS (Tailwind, Bootstrap, dll).
        Seluruh styling harus menggunakan INLINE CSS di sini.
        Hindari: flexbox, CSS grid, dan properti CSS modern lainnya yang belum didukung DomPDF.
        Gunakan: float, table layout, position absolute/relative.
    --}}

    <style>
        /* ─── Reset & Base ─────────────────────────────────────── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11px;
            color: #1e1b4b;
            line-height: 1.6;
            background: #ffffff;
        }

        /* ─── Header ────────────────────────────────────────────── */
        .header {
            background: #140c61;
            color: #ffffff;
            padding: 28px 36px;
            margin-bottom: 0;
        }

        .header-brand {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #c7d2fe;
        }

        .header-brand span {
            color: #818cf8;
        }

        .header-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 10px;
            color: #ffffff;
        }

        .header-meta {
            font-size: 10px;
            color: #a5b4fc;
            margin-top: 4px;
        }

        /* ─── Divider Aksen ─────────────────────────────────────── */
        .accent-bar {
            height: 4px;
            background: #818cf8;
        }

        /* ─── Kontainer Utama ───────────────────────────────────── */
        .container {
            padding: 28px 36px;
        }

        /* ─── Section Title ─────────────────────────────────────── */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #6366f1;
            border-bottom: 1.5px solid #e0e7ff;
            padding-bottom: 5px;
            margin-bottom: 14px;
            margin-top: 22px;
        }

        /* ─── Info Freelancer ───────────────────────────────────── */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .info-table td {
            padding: 3px 0;
            font-size: 11px;
            vertical-align: top;
        }

        .info-label {
            color: #6b7280;
            width: 130px;
        }

        .info-value {
            font-weight: bold;
            color: #1e1b4b;
        }

        /* ─── Project Card ──────────────────────────────────────── */
        .project-card {
            border: 1px solid #e0e7ff;
            border-left: 4px solid #6366f1;
            border-radius: 4px;
            padding: 14px 16px;
            margin-bottom: 14px;
            background: #f8f9ff;
            page-break-inside: avoid; /* Jangan potong card saat ganti halaman */
        }

        .project-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e1b4b;
            margin-bottom: 5px;
        }

        .project-meta {
            font-size: 9px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .project-description {
            font-size: 10px;
            color: #4b5563;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        /* ─── Rating Bintang ────────────────────────────────────── */
        .rating-row {
            margin-top: 4px;
        }

        .star {
            color: #fbbf24; /* Kuning bintang */
            font-size: 14px;
        }

        .star-empty {
            color: #d1d5db;
            font-size: 14px;
        }

        .rating-text {
            font-size: 9px;
            color: #6b7280;
            vertical-align: middle;
            margin-left: 4px;
        }

        /* ─── Review Comment ────────────────────────────────────── */
        .comment-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 3px;
            padding: 8px 10px;
            font-size: 10px;
            color: #1d4ed8;
            font-style: italic;
            margin-top: 8px;
        }

        /* ─── Statistik Ringkasan ───────────────────────────────── */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .stats-table td {
            width: 25%;
            text-align: center;
            padding: 12px 6px;
            border: 1px solid #e0e7ff;
            background: #f0f4ff;
        }

        .stats-number {
            font-size: 20px;
            font-weight: bold;
            color: #4338ca;
            display: block;
        }

        .stats-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ─── Footer ────────────────────────────────────────────── */
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #e0e7ff;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }

        .footer-brand {
            font-weight: bold;
            color: #6366f1;
        }

        /* ─── Nomor Halaman (DomPDF) ────────────────────────────── */
        .page-number {
            position: fixed;
            bottom: 20px;
            right: 36px;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-brand">Skill<span>Kul</span></div>
        <div class="header-title">Portofolio Freelancer Mahasiswa</div>
        <div class="header-meta">Dokumen ini di-generate secara otomatis oleh sistem SkillKul &bull; {{ $generated_at }}</div>
    </div>
    <div class="accent-bar"></div>

    <div class="container">

        {{-- ── Informasi Freelancer ── --}}
        <div class="section-title">Informasi Freelancer</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Lengkap</td>
                <td class="info-value">{{ $freelancer->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Email</td>
                <td class="info-value">{{ $freelancer->email }}</td>
            </tr>
            <tr>
                <td class="info-label">No. Telepon</td>
                <td class="info-value">{{ $freelancer->phone_number ?? '—' }}</td>
            </tr>
            <tr>
                <td class="info-label">Tanggal Generate</td>
                <td class="info-value">{{ $generated_at }}</td>
            </tr>
            @if($freelancer->profile_description)
            <tr>
                <td class="info-label">Deskripsi Profil</td>
                <td class="info-value" style="font-weight: normal; color: #4b5563;">
                    {{ $freelancer->profile_description }}
                </td>
            </tr>
            @endif
        </table>

        {{-- ── Statistik Ringkasan ── --}}
        @php
            $avgRating = $projects->avg('rating');
            $totalProjects = $projects->count();
        @endphp

        <div class="section-title">Ringkasan Pencapaian</div>
        <table class="stats-table">
            <tr>
                <td>
                    <span class="stats-number">{{ $totalProjects }}</span>
                    <span class="stats-label">Total Proyek</span>
                </td>
                <td>
                    <span class="stats-number">{{ number_format($avgRating, 1) }}</span>
                    <span class="stats-label">Rating Rata-rata</span>
                </td>
                <td>
                    <span class="stats-number">{{ $projects->where('rating', 5)->count() }}</span>
                    <span class="stats-label">Rating Sempurna</span>
                </td>
                <td>
                    <span class="stats-number">{{ $projects->where('rating', '>=', 4)->count() }}</span>
                    <span class="stats-label">Rating ≥ 4 Bintang</span>
                </td>
            </tr>
        </table>

        {{-- ── Daftar Proyek ── --}}
        <div class="section-title">Daftar Proyek Selesai</div>

        @forelse($projects as $index => $project)
        <div class="project-card">

            {{-- Judul & Meta --}}
            <div class="project-title">{{ ($index + 1) }}. {{ $project['title'] }}</div>
            <div class="project-meta">
                Selesai: {{ $project['completed_date'] }}
                &nbsp;&bull;&nbsp;
                Client: {{ $project['client_name'] }}
            </div>

            {{-- Deskripsi Singkat --}}
            @if($project['description'] && $project['description'] !== '-')
            <div class="project-description">
                {{ \Illuminate\Support\Str::limit($project['description'], 200) }}
            </div>
            @endif

            {{-- Rating Bintang ── render manual karena DomPDF tidak support Unicode penuh --}}
            <div class="rating-row">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $project['rating'])
                        <span class="star">&#9733;</span>
                    @else
                        <span class="star-empty">&#9733;</span>
                    @endif
                @endfor
                <span class="rating-text">{{ $project['rating'] }}/5 — Dinilai oleh client</span>
            </div>

            {{-- Komentar Review --}}
            @if(!empty($project['comment']))
            <div class="comment-box">
                &ldquo;{{ $project['comment'] }}&rdquo;
            </div>
            @endif
        </div>
        @empty
        <p style="color: #6b7280; font-style: italic; font-size: 11px;">Belum ada proyek yang memenuhi syarat.</p>
        @endforelse

    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        <p>
            Dokumen ini diterbitkan oleh
            <span class="footer-brand">SkillKul — Marketplace Jasa Mahasiswa</span>
        </p>
        <p style="margin-top: 3px;">
            Generated on {{ $generated_at }} &bull; Verifikasi keaslian dokumen di <strong>skillkul.id</strong>
        </p>
    </div>

    {{-- Nomor Halaman DomPDF --}}
    <div class="page-number">
        Halaman <span class="pagenum"></span>
    </div>

</body>
</html>
