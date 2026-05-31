<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * WalletTransaction Model — Immutable Financial Ledger
 *
 * Setiap baris mewakili satu perubahan saldo pada wallet user.
 * Model ini bersifat READ-ONLY dari perspektif aplikasi —
 * hanya boleh dibuat (create), tidak boleh diubah (update/delete).
 *
 * Gunakan WalletService untuk membuat entry baru.
 *
 * @property int         $id
 * @property int         $user_id
 * @property string|null $order_id
 * @property int|null    $escrow_id
 * @property int|null    $withdrawal_id
 * @property string      $type           credit|debit
 * @property string      $category       escrow_release|refund|withdrawal|withdrawal_reversal
 * @property float       $amount
 * @property float       $balance_before
 * @property float       $balance_after
 * @property string      $description
 */
class WalletTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'escrow_id',
        'withdrawal_id',
        'type',
        'category',
        'amount',
        'balance_before',
        'balance_after',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount'         => 'decimal:2',
            'balance_before' => 'decimal:2',
            'balance_after'  => 'decimal:2',
        ];
    }

    // ─── Relations ────────────────────────────────────────────

    /**
     * Pemilik wallet yang mengalami perubahan saldo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order yang menjadi sumber transaksi (nullable).
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Escrow yang terkait dengan transaksi ini (nullable).
     */
    public function escrow(): BelongsTo
    {
        return $this->belongsTo(Escrow::class);
    }

    /**
     * Request withdrawal yang terkait (nullable).
     */
    public function withdrawal(): BelongsTo
    {
        return $this->belongsTo(Withdrawal::class);
    }

    // ─── Scopes ───────────────────────────────────────────────

    /** Filter hanya transaksi kredit (saldo masuk). */
    public function scopeCredits($query)
    {
        return $query->where('type', 'credit');
    }

    /** Filter hanya transaksi debit (saldo keluar). */
    public function scopeDebits($query)
    {
        return $query->where('type', 'debit');
    }

    /** Filter berdasarkan kategori. */
    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // ─── Helpers ──────────────────────────────────────────────

    /** Label kategori dalam Bahasa Indonesia. */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'escrow_release'      => 'Dana Order Diterima',
            'refund'              => 'Refund Order',
            'withdrawal'          => 'Penarikan Saldo',
            'withdrawal_reversal' => 'Pembatalan Penarikan',
            default               => ucfirst(str_replace('_', ' ', $this->category)),
        };
    }

    /** Apakah transaksi ini adalah kredit (saldo masuk)? */
    public function isCredit(): bool
    {
        return $this->type === 'credit';
    }
}
