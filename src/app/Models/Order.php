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
        'deadline',
        'revision_count',
        'revision_limit',
        'client_gdrive_link',
        'freelancer_result_link',
        'total_price',
        'midtrans_snap_token',
        'midtrans_transaction_id',
        // Lifecycle timestamps (ditambahkan via migration 2026_05_30_000005)
        'submitted_at',
        'completed_at',
        'cancelled_at',
        'escrow_released_at',
    ];

    /**
     * Casting tipe data khusus.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_price'        => 'decimal:2',
            'deadline'           => 'datetime',
            'revision_count'     => 'integer',
            'revision_limit'     => 'integer',
            'submitted_at'       => 'datetime',
            'completed_at'       => 'datetime',
            'cancelled_at'       => 'datetime',
            'escrow_released_at' => 'datetime',
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

    /**
     * Pembayaran (Midtrans) terkait pesanan ini.
     * Satu pesanan dapat memiliki beberapa percobaan pembayaran.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Pembayaran sukses terbaru untuk pesanan ini.
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /**
     * Laporan yang dibuat berdasarkan pesanan ini.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Escrow yang menahan dana untuk order ini.
     * Satu order = satu escrow record (UNIQUE).
     */
    public function escrow()
    {
        return $this->hasOne(Escrow::class, 'order_id');
    }

    /**
     * Semua entri ledger wallet yang terkait dengan order ini.
     */
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, 'order_id');
    }

    // ─── Accessors ───────────────────────────────────────────

    /**
     * Cek apakah client masih bisa meminta revisi.
     * Digunakan di view untuk menampilkan/menyembunyikan tombol revisi.
     */
    public function getCanRequestRevisionAttribute(): bool
    {
        return $this->status === 'delivered'
            && $this->revision_count < $this->revision_limit;
    }

    /**
     * Label status order dalam Bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'         => 'Menunggu Pembayaran',
            'waiting_payment' => 'Menunggu Pembayaran',
            'paid'            => 'Dibayar',
            'in_progress'     => 'Sedang Dikerjakan',
            'delivered'       => 'Terkirim, Menunggu Konfirmasi',
            'revision'        => 'Revisi Diminta',
            'completed'       => 'Selesai',
            'canceled'        => 'Dibatalkan',
            default           => ucfirst($this->status),
        };
    }

    /**
     * Warna badge status untuk tampilan UI.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending', 'waiting_payment' => 'yellow',
            'paid'                       => 'blue',
            'in_progress', 'revision'    => 'indigo',
            'delivered'                  => 'orange',
            'completed'                  => 'green',
            'canceled'                   => 'red',
            default                      => 'gray',
        };
    }
}
