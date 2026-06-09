<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'freelancer_id',
        'category_id',
        'title',
        'description',
        'price',
        'price_max',
        'type',
        'is_active',
        'image',
        'estimated_days',
    ];

    protected function casts(): array
    {
        return [
            'is_active'       => 'boolean',
            'price'           => 'decimal:2',
            'price_max'       => 'decimal:2',
            'estimated_days'  => 'integer',
        ];
    }

    // ─── Relations ────────────────────────────────────────────
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Review yang masuk melalui pesanan layanan ini.
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Order::class);
    }

    // ─── Scopes ───────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope: Jasa yang tersedia di katalog publik.
     *
     * Kondisi yang harus terpenuhi:
     * 1. Jasa harus aktif (is_active = true)
     * 2. Freelancer pemilik tidak sedang dalam mode ujian (is_exam_mode = false)
     * 3. Tidak ada pesanan 'in_progress' untuk jasa ini (kapasitas 1-on-1)
     *
     * Digunakan di ServiceController::index() untuk memastikan hanya jasa
     * yang benar-benar tersedia yang tampil di lokapasar.
     */
    public function scopeAvailableInCatalog($query)
    {
        return $query
            ->where('is_active', true)
            ->whereHas('freelancer', function ($q) {
                $q->where('is_exam_mode', false)
                  ->where('is_active', true); // Freelancer tidak disuspend
            })
            ->whereDoesntHave('orders', function ($q) {
                // Kapasitas 1-on-1: blokir jika ada order yang sedang berjalan
                $q->whereIn('status', ['in_progress', 'delivered', 'revision']);
            });
    }

    // ─── Accessors ────────────────────────────────────────────

    public function getPriceRangeAttribute(): string
    {
        if ($this->type === 'project' && $this->price_max) {
            return 'Rp' . number_format($this->price, 0, ',', '.') .
                   ' – Rp' . number_format($this->price_max, 0, ',', '.');
        }
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Cek apakah jasa ini sedang dikerjakan (sudah ada order aktif).
     * Digunakan untuk menampilkan badge "Sedang Dikerjakan" di dashboard freelancer.
     */
    public function getHasActiveOrderAttribute(): bool
    {
        return $this->orders()
            ->whereIn('status', ['in_progress', 'delivered', 'revision'])
            ->exists();
    }

    /**
     * Label estimasi pengerjaan dalam format human-readable.
     * Contoh: 1 Hari, 3 Hari, Sesuai Kesepakatan
     */
    public function getEstimatedLabelAttribute(): string
    {
        if (! $this->estimated_days) {
            return 'Sesuai Kesepakatan';
        }
        return $this->estimated_days . ' Hari';
    }
}
