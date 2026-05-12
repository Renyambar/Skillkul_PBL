<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    // ─── UUID Primary Key ────────────────────────────────────
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Auto-generate UUID saat membuat order baru.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Order $order) {
            if (empty($order->{$order->getKeyName()})) {
                $order->{$order->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'client_id',
        'freelancer_id',
        'service_id',
        'type',
        'status',
        'order_notes',
        'client_gdrive_link',
        'freelancer_result_link',
        'total_price',
        'midtrans_snap_token',
        'midtrans_transaction_id',
    ];

    /**
     * Casting tipe data khusus.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    // ─── Relasi ──────────────────────────────────────────────

    /**
     * Client yang memesan jasa.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Freelancer yang mengerjakan pesanan.
     */
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    /**
     * Layanan (jasa) yang dipesan.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Review dari client setelah pesanan selesai.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Portfolio yang di-generate dari pesanan ini.
     */
    public function portfolio()
    {
        return $this->hasOne(Portfolio::class);
    }
}
