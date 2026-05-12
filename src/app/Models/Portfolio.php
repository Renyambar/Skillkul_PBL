<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'freelancer_id',
        'order_id',
        'project_title',
        'completed_date',
        'pdf_file_path',
    ];

    /**
     * Casting tipe data khusus.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completed_date' => 'date',
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
}
