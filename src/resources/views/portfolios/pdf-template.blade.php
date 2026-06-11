<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Portofolio &mdash; {{ $freelancer->name }}</title>

    <style>
        /* Reset & Base */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333333;
            line-height: 1.5;
            background: #ffffff;
        }

        /* Container */
        .container {
            width: 100%;
            padding: 40px;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-table td {
            vertical-align: bottom;
        }
        .name-title {
            font-size: 28pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .job-title {
            font-size: 14pt;
            color: #2563eb;
            font-weight: normal;
        }
        .contact-info {
            text-align: right;
            font-size: 9pt;
            color: #4b5563;
            line-height: 1.6;
        }

        /* Sections */
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Profile & Stats Table */
        .summary-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-table td {
            vertical-align: top;
        }
        .profile-desc {
            width: 60%;
            padding-right: 30px;
            text-align: justify;
        }
        .stats-box {
            width: 40%;
            background-color: #f8fafc;
            border-left: 3px solid #2563eb;
            padding: 15px;
        }
        .stat-item {
            margin-bottom: 8px;
            font-size: 9.5pt;
        }
        .stat-label {
            color: #64748b;
            display: inline-block;
            width: 120px;
        }
        .stat-value {
            font-weight: bold;
            color: #0f172a;
        }

        /* Projects */
        .project-item {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .project-header {
            width: 100%;
            margin-bottom: 5px;
        }
        .project-header td {
            vertical-align: top;
        }
        .project-title {
            font-size: 12pt;
            font-weight: bold;
            color: #1e293b;
        }
        .project-role {
            font-size: 10pt;
            font-style: italic;
            color: #2563eb;
            margin-bottom: 5px;
        }
        .project-meta {
            text-align: right;
            font-size: 9pt;
            color: #64748b;
        }
        .project-desc {
            font-size: 9.5pt;
            color: #475569;
            text-align: justify;
            margin-bottom: 8px;
        }
        .project-details {
            font-size: 9pt;
            color: #64748b;
        }
        .testimonial-box {
            margin-top: 10px;
            padding: 12px;
            background-color: #f1f5f9;
            border-left: 3px solid #cbd5e1;
            font-style: italic;
            color: #334155;
            font-size: 9pt;
        }
        .testimonial-author {
            margin-top: 5px;
            font-size: 8.5pt;
            color: #64748b;
            font-weight: bold;
        }
        .featured-tag {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            font-size: 8pt;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 8px;
            vertical-align: middle;
            text-transform: uppercase;
        }

        /* Badges */
        .badge-list {
            margin-top: 10px;
        }
        .badge-item {
            display: inline-block;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 5px 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            font-size: 9pt;
            color: #334155;
        }
        .badge-title {
            font-weight: bold;
            color: #0f172a;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 30px;
            left: 40px;
            right: 40px;
            text-align: center;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="name-title">{{ $freelancer->name }}</div>
                    <div class="job-title">Professional Freelancer</div>
                </td>
                <td class="contact-info">
                    {{ $freelancer->email }}<br>
                    @if($freelancer->phone_number) {{ $freelancer->phone_number }}<br> @endif
                    <strong>SkillKul Portfolio</strong><br>
                    Terakhir diperbarui: {{ $generated_at }}
                </td>
            </tr>
        </table>

        <!-- Profile & Summary -->
        <div class="section">
            <table class="summary-table">
                <tr>
                    <td class="profile-desc">
                        @if($freelancer->profile_description)
                            <div class="section-title">Profil</div>
                            <p>{{ $freelancer->profile_description }}</p>
                        @else
                            <div class="section-title">Profil</div>
                            <p>Freelancer profesional yang berdedikasi tinggi dalam memberikan hasil kerja berkualitas bagi klien. Berpengalaman menyelesaikan berbagai proyek dengan tingkat kepuasan yang sangat baik.</p>
                        @endif
                    </td>
                    <td class="stats-box">
                        <div class="section-title" style="font-size: 11pt; border-bottom: none; margin-bottom: 10px;">Ringkasan Pencapaian</div>
                        <div class="stat-item">
                            <span class="stat-label">Total Proyek:</span>
                            <span class="stat-value">{{ $stats['total_completed'] }} selesai</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Rating Rata-rata:</span>
                            <span class="stat-value">{{ number_format($stats['avg_rating'], 1) }} / 5.0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Total Klien:</span>
                            <span class="stat-value">{{ $stats['total_clients'] }} klien</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Tingkat Penyelesaian:</span>
                            <span class="stat-value">{{ $stats['completion_rate'] }}%</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Badges / Pencapaian -->
        @php $achievements = $freelancer->achievements ?? collect(); @endphp
        @if($achievements->isNotEmpty())
        <div class="section">
            <div class="section-title">Penghargaan & Pencapaian</div>
            <div class="badge-list">
                @foreach($achievements as $achievement)
                <div class="badge-item">
                    <span class="badge-title">{{ $achievement->badge_label }}</span>
                    <br>
                    <span style="font-size: 8pt; color: #64748b;">{{ $achievement->earned_at->format('M Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Experience / Projects -->
        <div class="section">
            <div class="section-title">Pengalaman Proyek</div>
            
            @forelse($portfolios as $portfolio)
            <div class="project-item">
                <table class="project-header">
                    <tr>
                        <td>
                            <div class="project-title">
                                {{ $portfolio->project_title }}
                                @if($portfolio->is_featured)
                                <span class="featured-tag">Unggulan</span>
                                @endif
                            </div>
                            @if($portfolio->freelancer_role)
                            <div class="project-role">{{ $portfolio->freelancer_role }}</div>
                            @endif
                        </td>
                        <td class="project-meta">
                            {{ $portfolio->completed_date?->format('M Y') ?? 'Selesai' }}<br>
                            Durasi: {{ $portfolio->duration_label }}
                        </td>
                    </tr>
                </table>

                @if($portfolio->project_description)
                <div class="project-desc">
                    {{ \Illuminate\Support\Str::limit($portfolio->project_description, 350) }}
                </div>
                @endif

                <div class="project-details">
                    @if($portfolio->project_category)<strong>Kategori:</strong> {{ $portfolio->project_category }} | @endif
                    @if($portfolio->client_rating)<strong>Rating Klien:</strong> {{ $portfolio->client_rating }}/5 | @endif
                    @if($portfolio->order?->client)<strong>Klien:</strong> {{ $portfolio->order->client->name }} @endif
                    @if($portfolio->cloud_link)<br><strong>Tautan Referensi:</strong> <a href="{{ $portfolio->cloud_link }}" style="color: #2563eb; text-decoration: none;">{{ $portfolio->cloud_link }}</a>@endif
                </div>

                @if($portfolio->client_testimonial)
                <div class="testimonial-box">
                    "{{ $portfolio->client_testimonial }}"
                    <div class="testimonial-author">&mdash; {{ $portfolio->order?->client?->name ?? 'Klien' }}</div>
                </div>
                @endif
            </div>
            @empty
            <p style="color: #64748b; font-style: italic;">Belum ada riwayat proyek yang ditambahkan.</p>
            @endforelse
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left;">SkillKul - Platform Pekerja Lepas Mahasiswa</td>
                <td style="text-align: right;"><span class="page-number"></span></td>
            </tr>
        </table>
    </div>

</body>
</html>
