<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Escrow Model
 *
 * Mewakili dana yang ditahan platform antara pembayaran client
 * dan penyelesaian order oleh freelancer.
 *
 * Lifecycle:
 *   held → released  (order completed)
 *   held → refunded  (order cancelled)
 *
 * @property int         $id
 * @property string      $order_id
 * @property float       $amount
 * @property float       $platform_fee
 * @property float       $freelancer_amount
 * @property string      $status           held|released|refunded
 * @property \Carbon\Carbon|null $held_at
 * @property \Carbon\Carbon|null $released_at
 * @property \Carbon\Carbon|null $refunded_at
 * @property int|null    $released_to_user_id
 * @property string|null $release_type
 */
class Escrow extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'platform_fee',
        'freelancer_amount',
        'status',
        'held_at',
        'released_at',
        'refunded_at',
        'released_to_user_id',
        'release_type',
    ];

    protected function casts(): array
    {
        return [
            'amount'            => 'decimal:2',
            'platform_fee'      => 'decimal:2',
            'freelancer_amount' => 'decimal:2',
            'held_at'           => 'datetime',
            'released_at'       => 'datetime',
            'refunded_at'       => 'datetime',
        ];
    }

    // ─── Relations ────────────────────────────────────────────

    /**
     * Order yang memiliki escrow ini.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * User penerima dana saat release atau refund.
     * Bisa freelancer (release) atau client (refund).
     */
    public function releasedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_to_user_id');
    }

    /**
     * Transaksi wallet yang terkait dengan escrow ini.
     */
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // ─── Scopes ───────────────────────────────────────────────

    /** Escrow yang masih ditahan (belum dilepas). */
    public function scopeHeld($query)
    {
        return $query->where('status', 'held');
    }

    /** Escrow yang sudah dilepas ke freelancer. */
    public function scopeReleased($query)
    {
        return $query->where('status', 'released');
    }

    /** Escrow yang sudah direfund ke client. */
    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    // ─── Helpers ──────────────────────────────────────────────

    /** Cek apakah escrow masih dalam status held (aman untuk diproses). */
    public function isHeld(): bool
    {
        return $this->status === 'held';
    }

    /** Cek apakah escrow sudah selesai (released atau refunded). */
    public function isSettled(): bool
    {
        return in_array($this->status, ['released', 'refunded']);
    }
}
