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
            font-family: 'Helvetica Neue', 'Segoe UI', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #334155; /* Slate 700 */
            line-height: 1.6;
            background: #ffffff;
        }

        /* Container */
        .container {
            width: 100%;
            padding: 40px 50px;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1d4ed8; /* Blue 700 */
            padding-bottom: 25px;
            margin-bottom: 35px;
        }
        .header-table td {
            vertical-align: bottom;
        }
        .name-title {
            font-size: 26pt;
            font-weight: 800;
            color: #0f172a; /* Slate 900 */
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .job-title {
            font-size: 13pt;
            color: #1d4ed8; /* Blue 700 */
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .contact-info {
            text-align: right;
            font-size: 9.5pt;
            color: #475569; /* Slate 600 */
            line-height: 1.6;
        }
        .contact-info strong {
            color: #0f172a;
        }

        /* Sections */
        .section {
            margin-bottom: 35px;
        }
        .section-title {
            font-size: 13pt;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0; /* Slate 200 */
            text-transform: uppercase;
            letter-spacing: 1px;
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
            width: 62%;
            padding-right: 35px;
            text-align: justify;
        }
        .stats-box {
            width: 38%;
            background-color: #f8fafc;
            border-top: 3px solid #1d4ed8;
            border-radius: 6px;
            padding: 20px;
        }
        .stats-box .section-title {
            font-size: 10.5pt;
            border-bottom: none;
            margin-bottom: 12px;
            padding-bottom: 0;
            color: #1d4ed8;
        }
        .stat-item {
            margin-bottom: 10px;
            font-size: 9.5pt;
        }
        .stat-label {
            color: #64748b;
            display: inline-block;
            width: 125px;
        }
        .stat-value {
            font-weight: 700;
            color: #0f172a;
        }

        /* Badges / Penghargaan */
        .badge-list {
            margin-top: 15px;
        }
        .badge-item {
            display: inline-block;
            background-color: #f1f5f9; /* Slate 100 */
            border: 1px solid #cbd5e1; /* Slate 300 */
            border-radius: 20px;
            padding: 6px 14px;
            margin-right: 8px;
            margin-bottom: 12px;
            font-size: 9pt;
            color: #334155;
        }
        .badge-title {
            font-weight: 700;
            color: #1d4ed8;
        }

        /* Projects */
        .project-item {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #e2e8f0;
            page-break-inside: avoid;
        }
        .project-item:last-child {
            border-bottom: none;
        }
        .project-header {
            width: 100%;
            margin-bottom: 8px;
        }
        .project-header td {
            vertical-align: top;
        }
        .project-title {
            font-size: 13pt;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 3px;
        }
        .featured-tag {
            display: inline-block;
            background-color: #10b981; /* Emerald 500 for a pop of color */
            color: white;
            font-size: 7.5pt;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 12px;
            margin-left: 8px;
            vertical-align: middle;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .project-role {
            font-size: 10pt;
            font-weight: 600;
            color: #3b82f6; /* Blue 500 */
            margin-bottom: 8px;
        }
        .project-meta {
            text-align: right;
            font-size: 9pt;
            color: #64748b;
            font-weight: 600;
        }
        .project-desc {
            font-size: 9.5pt;
            color: #475569;
            text-align: justify;
            margin-bottom: 12px;
            line-height: 1.6;
        }
        .project-details {
            font-size: 9pt;
            color: #64748b;
            background-color: #f8fafc;
            padding: 8px 12px;
            border-radius: 4px;
        }
        .project-details strong {
            color: #334155;
        }
        .project-details a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
        
        /* Testimonial */
        .testimonial-box {
            margin-top: 15px;
            padding: 12px 18px;
            background-color: #fefce8; /* Soft yellow hint for distinction */
            border-left: 4px solid #facc15; /* Yellow 400 */
            border-radius: 0 6px 6px 0;
            font-style: italic;
            color: #475569;
            font-size: 9.5pt;
        }
        .testimonial-author {
            margin-top: 6px;
            font-size: 8.5pt;
            color: #0f172a;
            font-weight: 700;
            font-style: normal;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 30px;
            left: 50px;
            right: 50px;
            text-align: center;
            font-size: 8.5pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .page-number:before {
            content: "Halaman " counter(page);
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="container">
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
                    Diperbarui: {{ $generated_at }}
                </td>
            </tr>
        </table>

        <div class="section">
            <table class="summary-table">
                <tr>
                    <td class="profile-desc">
                        <div class="section-title">Profil Singkat</div>
                        @if($freelancer->profile_description)
                            <p>{{ $freelancer->profile_description }}</p>
                        @else
                            <p>Freelancer profesional yang berdedikasi tinggi dalam memberikan hasil kerja berkualitas bagi klien. Berpengalaman menyelesaikan berbagai proyek dengan tingkat kepuasan yang sangat baik, tepat waktu, dan komunikatif.</p>
                        @endif
                    </td>
                    <td class="stats-box">
                        <div class="section-title">Ringkasan Pencapaian</div>
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
                            <span class="stat-label">Penyelesaian:</span>
                            <span class="stat-value">{{ $stats['completion_rate'] }}%</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        @php $achievements = $freelancer->achievements ?? collect(); @endphp
        @if($achievements->isNotEmpty())
        <div class="section">
            <div class="section-title">Penghargaan & Pencapaian</div>
            <div class="badge-list">
                @foreach($achievements as $achievement)
                <div class="badge-item">
                    <span class="badge-title">{{ $achievement->badge_label }}</span>
                    <span style="color: #94a3b8; margin-left: 5px;">| {{ $achievement->earned_at->format('M Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

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
                            <span style="font-weight: normal; font-size: 8.5pt;">Durasi: {{ $portfolio->duration_label }}</span>
                        </td>
                    </tr>
                </table>

                @if($portfolio->project_description)
                <div class="project-desc">
                    {{ \Illuminate\Support\Str::limit($portfolio->project_description, 350) }}
                </div>
                @endif

                <div class="project-details">
                    @if($portfolio->project_category)<strong>Kategori:</strong> {{ $portfolio->project_category }} &nbsp;|&nbsp; @endif
                    @if($portfolio->client_rating)<strong>Rating Klien:</strong> {{ $portfolio->client_rating }}/5 &nbsp;|&nbsp; @endif
                    @if($portfolio->order?->client)<strong>Klien:</strong> {{ $portfolio->order->client->name }} @endif
                    @if($portfolio->cloud_link)<br><br><strong>Tautan Referensi:</strong> <a href="{{ $portfolio->cloud_link }}" target="_blank">{{ $portfolio->cloud_link }}</a>@endif
                </div>

                @if($portfolio->client_testimonial)
                <div class="testimonial-box">
                    "{{ $portfolio->client_testimonial }}"
                    <div class="testimonial-author">&mdash; {{ $portfolio->order?->client?->name ?? 'Klien' }}</div>
                </div>
                @endif
            </div>
            @empty
            <p style="color: #94a3b8; font-style: italic; text-align: center; padding: 20px;">Belum ada riwayat proyek yang ditambahkan saat ini.</p>
            @endforelse
        </div>

    </div>

    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left; font-weight: 600;">SkillKul - Platform Pekerja Lepas Mahasiswa</td>
                <td style="text-align: right;"><span class="page-number"></span></td>
            </tr>
        </table>
    </div>

</body>
</html>