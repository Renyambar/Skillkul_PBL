<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Portfolio
 *
 * Menyimpan project portfolio freelancer yang di-generate dari order yang sudah selesai.
 * Hanya berlaku untuk service.type = 'project'.
 *
 * Visibility:
 *  - is_portfolio = true  → tampil di halaman publik /portfolio/{username}
 *  - is_portfolio = false → tersembunyi (draft)
 *
 * Featured:
 *  - is_featured = true → tampil paling atas (max 3 per freelancer)
 */
class Portfolio extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioFactory> */
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        // ── Kolom lama ───────────────────────────────────────
        'freelancer_id',
        'order_id',
        'project_title',
        'completed_date',
        'pdf_file_path',

        // ── Kolom baru (revamp) ───────────────────────────────
        'project_description',
        'project_category',
        'freelancer_role',
        'project_duration_days',
        'cloud_link',
        'client_rating',
        'client_testimonial',
        'is_portfolio',
        'is_featured',
        'sort_order',
    ];

    /**
     * Casting tipe data khusus.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completed_date'       => 'date',
            'is_portfolio'         => 'boolean',
            'is_featured'          => 'boolean',
            'client_rating'        => 'integer',
            'project_duration_days'=> 'integer',
            'sort_order'           => 'integer',
        ];
    }

    // ─── Relasi ──────────────────────────────────────────────

    /**
     * Freelancer pemilik portfolio.
     */
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    /**
     * Pesanan asal portfolio ini di-generate.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ─── Scopes ──────────────────────────────────────────────

    /**
     * Scope: Hanya portfolio yang ditampilkan publik (is_portfolio = true).
     */
    public function scopePublic($query)
    {
        return $query->where('is_portfolio', true);
    }

    /**
     * Scope: Hanya featured portfolio (is_featured = true).
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Urutkan — featured dulu, lalu sort_order, lalu terbaru.
     */
    public function scopeOrdered($query)
    {
        return $query
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('completed_date');
    }

    // ─── Accessors ───────────────────────────────────────────

    /**
     * Label durasi proyek dalam format human-readable.
     * Contoh: "7 Hari", "30 Hari"
     */
    public function getDurationLabelAttribute(): string
    {
        if (! $this->project_duration_days) {
            return 'Sesuai Kesepakatan';
        }

        return $this->project_duration_days . ' Hari';
    }

    /**
     * Bintang rating sebagai array boolean untuk rendering di view.
     * Contoh untuk rating 4: [true, true, true, true, false]
     *
     * @return bool[]
     */
    public function getRatingStarsAttribute(): array
    {
        $rating = $this->client_rating ?? 0;
        return array_map(fn ($i) => $i <= $rating, range(1, 5));
    }
}
