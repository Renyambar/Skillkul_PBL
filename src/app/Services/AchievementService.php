<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\Log;

/**
 * AchievementService
 *
 * Menghitung dan memberikan badge/pencapaian kepada freelancer.
 * HANYA menghitung dari project-based services (service.type = 'project').
 *
 * Dipanggil setiap kali sebuah order project berstatus 'completed'.
 *
 * Definisi badge:
 * - first_project      : Total project completed ≥ 1
 * - five_projects      : Total project completed ≥ 5
 * - ten_projects       : Total project completed ≥ 10
 * - top_rated          : Avg rating ≥ 4.5 dengan minimal 3 review
 * - excellent_feedback : Mendapat rating 5★ minimal 3 kali
 */
class AchievementService
{
    /**
     * Hitung ulang semua badge untuk freelancer tertentu dan unlock yang baru.
     *
     * @param  User  $freelancer
     * @return string[]  Daftar badge_key yang baru di-unlock pada pemanggilan ini
     */
    public function recalculate(User $freelancer): array
    {
        // Ambil semua order project yang sudah completed beserta review-nya
        $completedProjectOrders = $freelancer->freelancerOrders()
            ->with(['service', 'review'])
            ->whereHas('service', fn ($q) => $q->where('type', 'project'))
            ->where('status', 'completed')
            ->get();

        $totalCompleted = $completedProjectOrders->count();

        // Review yang masuk (order yang punya review)
        $reviewedOrders = $completedProjectOrders->filter(fn ($o) => $o->review !== null);
        $totalReviews   = $reviewedOrders->count();
        $avgRating      = $totalReviews > 0
            ? $reviewedOrders->avg(fn ($o) => $o->review->rating)
            : 0;
        $perfectRatings = $reviewedOrders->filter(fn ($o) => $o->review->rating === 5)->count();

        // Definisi badge → [condition]
        $badgeDefinitions = [
            'first_project'      => $totalCompleted >= 1,
            'five_projects'      => $totalCompleted >= 5,
            'ten_projects'       => $totalCompleted >= 10,
            'top_rated'          => $totalReviews >= 3 && $avgRating >= 4.5,
            'excellent_feedback' => $perfectRatings >= 3,
        ];

        $newlyUnlocked = [];

        foreach ($badgeDefinitions as $badgeKey => $condition) {
            if ($condition) {
                $wasNew = $this->awardBadge($freelancer, $badgeKey);
                if ($wasNew) {
                    $newlyUnlocked[] = $badgeKey;
                }
            }
        }

        if (! empty($newlyUnlocked)) {
            Log::info('[AchievementService] Badge baru diraih.', [
                'freelancer_id' => $freelancer->id,
                'badges'        => $newlyUnlocked,
            ]);
        }

        return $newlyUnlocked;
    }

    /**
     * Berikan satu badge ke freelancer jika belum pernah diberikan.
     *
     * @param  User    $freelancer
     * @param  string  $badgeKey
     * @return bool    true jika badge baru pertama kali diberikan, false jika sudah ada
     */
    protected function awardBadge(User $freelancer, string $badgeKey): bool
    {
        $exists = UserAchievement::where('user_id', $freelancer->id)
            ->where('badge_key', $badgeKey)
            ->exists();

        if ($exists) {
            return false; // Sudah punya
        }

        UserAchievement::create([
            'user_id'   => $freelancer->id,
            'badge_key' => $badgeKey,
            'earned_at' => now(),
        ]);

        return true;
    }

    /**
     * Ambil semua badge yang MUNGKIN diraih (untuk tampilan "terkunci").
     * Digunakan di halaman portfolio untuk menampilkan progress badge.
     *
     * @return array<string, array{label: string, description: string, icon: string}>
     */
    public function getAllBadgeDefinitions(): array
    {
        return [
            'first_project' => [
                'label'       => 'Proyek Pertama',
                'description' => 'Menyelesaikan proyek pertama',
                'icon'        => '🚀',
                'color'       => 'blue',
            ],
            'five_projects' => [
                'label'       => '5 Proyek Selesai',
                'description' => 'Menyelesaikan 5 proyek berbasis project',
                'icon'        => '⭐',
                'color'       => 'yellow',
            ],
            'ten_projects' => [
                'label'       => '10 Proyek Selesai',
                'description' => 'Menyelesaikan 10 proyek berbasis project',
                'icon'        => '🏆',
                'color'       => 'purple',
            ],
            'top_rated' => [
                'label'       => 'Top Rated',
                'description' => 'Rata-rata rating ≥ 4.5 dari minimal 3 ulasan',
                'icon'        => '💎',
                'color'       => 'cyan',
            ],
            'excellent_feedback' => [
                'label'       => 'Feedback Terbaik',
                'description' => 'Mendapat rating 5 bintang minimal 3 kali',
                'icon'        => '❤️',
                'color'       => 'red',
            ],
        ];
    }
}
