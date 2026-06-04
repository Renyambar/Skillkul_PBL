<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * OrderRevision Model
 *
 * Menyimpan setiap permintaan revisi dari client untuk satu order.
 * Dibuat immutable — hanya bisa create, tidak edit/delete.
 *
 * @property int         $id
 * @property string      $order_id
 * @property int         $requested_by
 * @property string      $notes
 * @property string|null $drive_link
 * @property int         $revision_number
 */
class OrderRevision extends Model
{
    protected $fillable = [
        'order_id',
        'requested_by',
        'notes',
        'drive_link',
        'revision_number',
    ];

    protected function casts(): array
    {
        return [
            'revision_number' => 'integer',
        ];
    }

    // ─── Relations ────────────────────────────────────────────

    /** Order yang diminta revisi. */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** Client yang mengajukan revisi. */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
