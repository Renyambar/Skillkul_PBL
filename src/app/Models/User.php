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
        'email',
        'password',
        'phone_number',
        'profile_description',
        'profile_photo_path',
        'role',
        'is_exam_mode',
        'exam_mode',
        'is_auto_portfolio',
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
            'password' => 'hashed',
            'is_exam_mode' => 'boolean',
            'is_auto_portfolio' => 'boolean',
            'wallet_balance' => 'decimal:2',
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

    // ─── Accessors ───────────────────────────────────────────

    /**
     * Cek apakah freelancer sedang sibuk.
     * Bernilai true jika mode ujian aktif ATAU ada pesanan yang sedang dikerjakan (in_progress).
     */
    public function getIsBusyAttribute(): bool
    {
        return $this->is_exam_mode
            || $this->freelancerOrders()
                ->where('status', 'in_progress')
                ->exists();
    }

    /**
     * Accessor for `exam_mode` to keep backward compatibility with views/controllers
     * that reference `exam_mode` while the DB column is `is_exam_mode`.
     */
    public function getExamModeAttribute(): bool
    {
        return (bool) ($this->attributes['is_exam_mode'] ?? false);
    }

    /**
     * Mutator to map `exam_mode` attribute to `is_exam_mode` column.
     */
    public function setExamModeAttribute($value): void
    {
        $this->attributes['is_exam_mode'] = (bool) $value;
    }
}
