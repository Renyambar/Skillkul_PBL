<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Payment Model
 *
 * Tracks each Midtrans payment transaction per order.
 * One order can have multiple payment attempts (e.g., expired then retried).
 * The raw Midtrans webhook response is stored as JSON for full audit trail.
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'midtrans_transaction_id',
        'midtrans_order_id',
        'payment_method',
        'gross_amount',
        'payment_status',
        'paid_at',
        'raw_response',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount'  => 'decimal:2',
            'paid_at'       => 'datetime',
            'raw_response'  => 'array',
        ];
    }

    // ─── Relasi ──────────────────────────────────────────────

    /**
     * Pesanan yang terkait dengan pembayaran ini.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
