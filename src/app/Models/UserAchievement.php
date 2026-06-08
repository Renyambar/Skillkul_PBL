<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * UserAchievement
 *
 * Menyimpan badge pencapaian freelancer. Badge hanya dihitung
 * dari project-based services (service.type = 'project').
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $badge_key
 * @property \Carbon\Carbon $earned_at
 */
class UserAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'badge_key',
        'earned_at',
    ];

    protected function casts(): array
    {
        return [
            'earned_at' => 'datetime',
        ];
    }

    // ─── Relasi ──────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Accessors ───────────────────────────────────────────

    /**
     * Label badge dalam Bahasa Indonesia.
     */
    public function getBadgeLabelAttribute(): string
    {
        return match ($this->badge_key) {
            'first_project'      => 'Proyek Pertama',
            'five_projects'      => '5 Proyek Selesai',
            'ten_projects'       => '10 Proyek Selesai',
            'top_rated'          => 'Top Rated',
            'excellent_feedback' => 'Feedback Terbaik',
            default              => ucfirst(str_replace('_', ' ', $this->badge_key)),
        };
    }

    /**
     * Deskripsi singkat badge.
     */
    public function getBadgeDescriptionAttribute(): string
    {
        return match ($this->badge_key) {
            'first_project'      => 'Menyelesaikan proyek pertama',
            'five_projects'      => 'Menyelesaikan 5 proyek berbasis project',
            'ten_projects'       => 'Menyelesaikan 10 proyek berbasis project',
            'top_rated'          => 'Rata-rata rating ≥ 4.5 dari minimal 3 ulasan',
            'excellent_feedback' => 'Mendapat rating 5 bintang minimal 3 kali',
            default              => '—',
        };
    }

    /**
     * Emoji ikon untuk badge (tampilan UI).
     */
    public function getBadgeIconAttribute(): string
    {
        return match ($this->badge_key) {
            'first_project'      => '🚀',
            'five_projects'      => '⭐',
            'ten_projects'       => '🏆',
            'top_rated'          => '💎',
            'excellent_feedback' => '❤️',
            default              => '🎖️',
        };
    }

    /**
     * Warna tema badge (untuk Tailwind class).
     */
    public function getBadgeColorAttribute(): string
    {
        return match ($this->badge_key) {
            'first_project'      => 'blue',
            'five_projects'      => 'yellow',
            'ten_projects'       => 'purple',
            'top_rated'          => 'cyan',
            'excellent_feedback' => 'red',
            default              => 'gray',
        };
    }
}
