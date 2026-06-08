<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\User;
use App\Services\AchievementService;
use App\Services\PortfolioService;
use Illuminate\View\View;

/**
 * PublicPortfolioController
 *
 * Mengelola halaman publik portfolio freelancer:
 * /portfolio/{username}
 *
 * Dapat diakses tanpa login (publik penuh).
 * Menampilkan profil, skills, featured projects, portfolio, testimonial, dan achievement.
 */
class PublicPortfolioController extends Controller
{
    public function __construct(
        protected PortfolioService   $portfolioService,
        protected AchievementService $achievementService,
    ) {}

    /**
     * Tampilkan halaman publik portfolio freelancer.
     *
     * @param  string  $username  Username (name slug) atau bagian dari nama user
     * @return View
     */
    public function show(string $username): View
    {
        // Cari freelancer berdasarkan 'name' yang di-slug-kan
        // Strategi: cari exact match dulu, fallback ke LIKE
        $freelancer = User::where('role', 'freelancer')
            ->where('is_active', true)
            ->where(function ($q) use ($username) {
                // Exact slug match
                $q->whereRaw('LOWER(REPLACE(name, " ", "-")) = ?', [strtolower($username)])
                  // Atau exact name match
                  ->orWhere('name', $username);
            })
            ->with(['services.category', 'achievements'])
            ->firstOrFail();

        // Featured portfolios (max 3)
        $featuredPortfolios = Portfolio::with(['order.review', 'order.client'])
            ->where('freelancer_id', $freelancer->id)
            ->public()
            ->featured()
            ->ordered()
            ->limit(3)
            ->get();

        // Semua portfolio publik (non-featured)
        $allPortfolios = Portfolio::with(['order.review', 'order.client'])
            ->where('freelancer_id', $freelancer->id)
            ->public()
            ->ordered()
            ->paginate(9);

        // Testimoni dari client (ambil dari portfolio yang punya testimonial)
        $testimonials = Portfolio::with(['order.client'])
            ->where('freelancer_id', $freelancer->id)
            ->public()
            ->whereNotNull('client_testimonial')
            ->latest('completed_date')
            ->limit(6)
            ->get();

        // Statistik
        $stats = $this->portfolioService->calculateStats($freelancer);

        // Achievements yang sudah di-unlock
        $achievements  = $freelancer->achievements;
        $allBadges     = $this->achievementService->getAllBadgeDefinitions();

        // Skills: ambil dari kategori service yang aktif
        $skills = $freelancer->services()
            ->where('is_active', true)
            ->with('category')
            ->get()
            ->pluck('category.name')
            ->filter()
            ->unique()
            ->values();

        return view('portfolio.public', compact(
            'freelancer',
            'featuredPortfolios',
            'allPortfolios',
            'testimonials',
            'stats',
            'achievements',
            'allBadges',
            'skills'
        ));
    }
}
