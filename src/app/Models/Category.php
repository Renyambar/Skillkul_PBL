<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'icon'];

    // ─── Relations ────────────────────────────────────────────

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // ─── Accessors ────────────────────────────────────────────

    /**
     * Jumlah jasa aktif yang menggunakan kategori ini.
     */
    public function getActiveServicesCountAttribute(): int
    {
        return $this->services()->where('is_active', true)->count();
    }
}
