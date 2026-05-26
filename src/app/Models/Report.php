<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Report Model
 *
 * Represents a client report against a freelancer for misconduct or fraud.
 * Admin reviews and resolves reports through the admin panel.
 */
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reported_id',
        'order_id',
        'category',
        'description',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            // status and category are stored as strings (enum in DB)
        ];
    }

    // ─── Relasi ──────────────────────────────────────────────

    /**
     * User yang membuat laporan.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * User yang dilaporkan.
     */
    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }

    /**
     * Pesanan yang menjadi konteks laporan (opsional).
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
