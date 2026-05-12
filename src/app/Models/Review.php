<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'client_id',
        'rating',
        'comment',
    ];

    /**
     * Casting tipe data khusus.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    // ─── Relasi ──────────────────────────────────────────────

    /**
     * Pesanan yang di-review.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Client yang memberikan review.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
