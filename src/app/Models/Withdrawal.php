<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Withdrawal Model
 *
 * Mewakili request penarikan saldo oleh client atau freelancer.
 *
 * Workflow:
 *   pending → approved → completed   (normal flow)
 *   pending → rejected               (admin tolak)
 *   approved → rejected              (admin bisa reject sebelum complete)
 *
 * PENTING: Saldo baru berkurang di users.wallet_balance
 * HANYA saat admin mark as completed melalui WalletService::debit().
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $bank_name
 * @property string      $account_number
 * @property string      $account_holder
 * @property float       $amount
 * @property string      $status          pending|approved|rejected|completed
 * @property string|null $admin_note
 * @property \Carbon\Carbon|null $requested_at
 * @property \Carbon\Carbon|null $reviewed_at
 * @property \Carbon\Carbon|null $completed_at
 * @property int|null    $reviewed_by
 */
class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_holder',
        'amount',
        'status',
        'admin_note',
        'requested_at',
        'reviewed_at',
        'completed_at',
        'reviewed_by',
    ];

    protected function casts(): array
    {
        return [
            'amount'       => 'decimal:2',
            'requested_at' => 'datetime',
            'reviewed_at'  => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // ─── Relations ────────────────────────────────────────────

    /**
     * User yang mengajukan withdrawal (client atau freelancer).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Admin yang mereview withdrawal ini.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Transaksi wallet yang terkait (dibuat saat status = completed).
     */
    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // ─── Scopes ───────────────────────────────────────────────

    /** Filter withdrawal yang menunggu review admin. */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /** Filter withdrawal yang sudah disetujui tapi belum ditransfer. */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /** Filter withdrawal yang sudah selesai. */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // ─── Accessors ────────────────────────────────────────────

    /** Label status dalam Bahasa Indonesia. */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'Menunggu Review',
            'approved'  => 'Disetujui — Menunggu Transfer',
            'rejected'  => 'Ditolak',
            'completed' => 'Selesai',
            default     => ucfirst($this->status),
        };
    }

    /** Warna badge status untuk UI. */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'yellow',
            'approved'  => 'blue',
            'rejected'  => 'red',
            'completed' => 'green',
            default     => 'gray',
        };
    }

    /** Apakah withdrawal ini masih bisa diproses (approved/pending)? */
    public function isActionable(): bool
    {
        return in_array($this->status, ['pending', 'approved']);
    }
}
