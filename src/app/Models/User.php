<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nim',
        'email',
        'password',
        'phone_number',
        'profile_description',
        'profile_photo_path',
        'role',
        'is_exam_mode',      // Satu-satunya kolom mode ujian (kolom 'exam_mode' dihapus via migrasi fix)
        'is_auto_portfolio',
        'is_active',         // Flag suspensi akun oleh admin
        'wallet_balance',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data khusus.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_exam_mode'      => 'boolean',
            'is_auto_portfolio' => 'boolean',
            'is_active'         => 'boolean',
            'wallet_balance'    => 'decimal:2',
        ];
    }

    // ─── Relasi ──────────────────────────────────────────────

    /**
     * Layanan (jasa) yang ditawarkan freelancer.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'freelancer_id');
    }

    /**
     * Pesanan yang dibuat oleh client.
     */
    public function clientOrders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    /**
     * Pesanan yang dikerjakan oleh freelancer.
     */
    public function freelancerOrders()
    {
        return $this->hasMany(Order::class, 'freelancer_id');
    }

    /**
     * Review yang diberikan oleh client.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    /**
     * Portofolio milik freelancer.
     */
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'freelancer_id');
    }

    /**
     * Laporan yang dibuat oleh user ini (sebagai pelapor).
     */
    public function reportsMade()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    /**
     * Laporan yang ditujukan kepada user ini (sebagai yang dilaporkan).
     */
    public function reportsReceived()
    {
        return $this->hasMany(Report::class, 'reported_id');
    }

    // ─── Accessors ───────────────────────────────────────────

    /**
     * Cek apakah freelancer sedang sibuk.
     *
     * Bernilai true jika:
     *  - Mode ujian aktif (is_exam_mode = true), ATAU
     *  - Ada pesanan yang sedang dikerjakan (in_progress)
     *
     * Digunakan di CheckoutController dan ServiceController untuk memblokir order baru.
     */
    public function getIsBusyAttribute(): bool
    {
        return $this->is_exam_mode
            || $this->freelancerOrders()
                ->where('status', 'in_progress')
                ->exists();
    }
}
