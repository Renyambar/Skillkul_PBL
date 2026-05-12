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
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price'     => 'decimal:2',
            'price_max' => 'decimal:2',
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

    // ─── Accessors ────────────────────────────────────────────
    public function getPriceRangeAttribute(): string
    {
        if ($this->type === 'project' && $this->price_max) {
            return 'Rp ' . number_format($this->price, 0, ',', '.') .
                   ' – Rp ' . number_format($this->price_max, 0, ',', '.');
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
