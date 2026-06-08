<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Portfolio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * PortfolioService
 *
 * Bertanggung jawab atas semua logika bisnis terkait portfolio:
 * - Build portfolio entry dari order
 * - Sinkronisasi featured limit (max 3)
 * - Generate PDF dari portfolio yang sudah diset is_portfolio = true
 * - Hitung statistik portfolio freelancer
 *
 * HANYA memproses order dari service bertipe 'project'.
 */
class PortfolioService
{
    /**
     * Buat atau update record portfolio dari sebuah order.
     *
     * Semua field di-populate otomatis dari data order, kecuali
     * freelancer_role dan cloud_link yang bisa di-override via $customData.
     *
     * @param  Order  $order       Order yang sudah 'completed' & bertipe 'project'
     * @param  array  $customData  Override data (freelancer_role, cloud_link)
     * @return Portfolio
     * @throws \InvalidArgumentException jika order bukan project type atau belum completed
     */
    public function buildFromOrder(Order $order, array $customData = []): Portfolio
    {
        // Guard: hanya project-based
        if ($order->service?->type !== 'project') {
            throw new \InvalidArgumentException(
                "Order #{$order->id} bukan dari layanan bertipe 'project'."
            );
        }

        // Guard: hanya completed
        if ($order->status !== 'completed') {
            throw new \InvalidArgumentException(
                "Order #{$order->id} belum berstatus 'completed'."
            );
        }

        // Hitung durasi pengerjaan
        $durationDays = null;
        if ($order->completed_at && $order->created_at) {
            $durationDays = (int) $order->created_at->diffInDays($order->completed_at);
            $durationDays = max(1, $durationDays); // Minimal 1 hari
        }

        $portfolio = Portfolio::updateOrCreate(
            ['order_id' => $order->id],
            [
                'freelancer_id'         => $order->freelancer_id,
                'project_title'         => $order->service->title ?? 'Proyek Tanpa Judul',
                'project_description'   => $order->service->description ?? null,
                'project_category'      => $order->service->category?->name ?? null,
                'freelancer_role'       => $customData['freelancer_role'] ?? null,
                'project_duration_days' => $durationDays,
                'cloud_link'            => $customData['cloud_link']
                                          ?? $order->freelancer_result_link,
                'client_rating'         => $order->review?->rating ?? null,
                'client_testimonial'    => $order->review?->comment ?? null,
                'completed_date'        => $order->completed_at?->toDateString()
                                          ?? $order->updated_at->toDateString(),
                'is_portfolio'          => true, // Langsung tampil
                'is_featured'           => false,
                'sort_order'            => 0,
            ]
        );

        Log::info('[PortfolioService] Portfolio entry dibuat/diperbarui.', [
            'portfolio_id' => $portfolio->id,
            'order_id'     => $order->id,
            'freelancer'   => $order->freelancer_id,
        ]);

        return $portfolio;
    }

    /**
     * Pastikan freelancer tidak memiliki lebih dari 3 featured portfolio.
     *
     * Jika melebihi, non-featured yang paling lama (sort by completed_date asc).
     *
     * @param  User  $freelancer
     */
    public function syncFeaturedLimit(User $freelancer): void
    {
        $featuredPortfolios = Portfolio::where('freelancer_id', $freelancer->id)
            ->where('is_featured', true)
            ->orderByDesc('completed_date')
            ->get();

        if ($featuredPortfolios->count() <= 3) {
            return;
        }

        // Non-featured yang paling lama (index 3+)
        $toUnfeature = $featuredPortfolios->slice(3);
        foreach ($toUnfeature as $portfolio) {
            $portfolio->update(['is_featured' => false]);
        }

        Log::info('[PortfolioService] Featured limit sync — beberapa portfolio di-unfeature.', [
            'freelancer_id' => $freelancer->id,
            'count_removed' => $toUnfeature->count(),
        ]);
    }

    /**
     * Generate PDF portfolio untuk freelancer.
     *
     * Hanya mengambil portfolio dengan is_portfolio = true.
     * PDF disimpan ke storage/app/public/portfolios/.
     *
     * @param  User  $freelancer
     * @return string  Path file PDF relatif ke disk 'public'
     */
    public function generatePdf(User $freelancer): string
    {
        // Ambil semua portfolio publik, featured dulu
        $portfolios = Portfolio::with(['order.review', 'order.client', 'order.service'])
            ->where('freelancer_id', $freelancer->id)
            ->public()
            ->ordered()
            ->get();

        // Hitung statistik
        $stats = $this->calculateStats($freelancer);

        // Render PDF
        $pdf = Pdf::loadView('portfolios.pdf-template', [
            'freelancer'   => $freelancer,
            'portfolios'   => $portfolios,
            'stats'        => $stats,
            'generated_at' => now()->format('d F Y, H:i'),
        ])
        ->setPaper('A4', 'portrait')
        ->setOptions([
            'dpi'                  => 150,
            'isRemoteEnabled'      => false,
            'isHtml5ParserEnabled' => true,
            'defaultFont'          => 'sans-serif',
            'chroot'               => public_path(),
        ]);

        // Simpan ke storage
        Storage::disk('public')->makeDirectory('portfolios');
        $fileName = 'portfolio_' . $freelancer->id . '_' . now()->format('Ymd_His') . '.pdf';
        $filePath = 'portfolios/' . $fileName;
        Storage::disk('public')->put($filePath, $pdf->output());

        Log::info('[PortfolioService] PDF portfolio dibuat.', [
            'freelancer_id' => $freelancer->id,
            'file_path'     => $filePath,
            'count'         => $portfolios->count(),
        ]);

        return $filePath;
    }

    /**
     * Hitung statistik portfolio freelancer secara otomatis.
     *
     * Semua statistik hanya dari project-based services.
     *
     * @param  User  $freelancer
     * @return array{
     *   total_completed: int,
     *   total_portfolio: int,
     *   avg_rating: float,
     *   total_clients: int,
     *   completion_rate: float
     * }
     */
    public function calculateStats(User $freelancer): array
    {
        // Total order project yang selesai
        $completedOrders = $freelancer->freelancerOrders()
            ->where('status', 'completed')
            ->whereHas('service', fn ($q) => $q->where('type', 'project'))
            ->get();

        $totalCompleted = $completedOrders->count();

        // Total portfolio entries yang dipublikasikan
        $totalPortfolio = Portfolio::where('freelancer_id', $freelancer->id)
            ->public()
            ->count();

        // Rata-rata rating dari semua review project
        $avgRating = $completedOrders
            ->filter(fn ($o) => $o->review !== null)
            ->avg(fn ($o) => $o->review->rating) ?? 0;

        // Total client unik
        $totalClients = $completedOrders
            ->pluck('client_id')
            ->unique()
            ->count();

        // Completion rate: completed / (completed + canceled) × 100
        $totalOrders = $freelancer->freelancerOrders()
            ->whereHas('service', fn ($q) => $q->where('type', 'project'))
            ->whereIn('status', ['completed', 'canceled'])
            ->count();

        $completionRate = $totalOrders > 0
            ? round(($totalCompleted / $totalOrders) * 100, 1)
            : 0;

        return [
            'total_completed' => $totalCompleted,
            'total_portfolio' => $totalPortfolio,
            'avg_rating'      => round($avgRating, 1),
            'total_clients'   => $totalClients,
            'completion_rate' => $completionRate,
        ];
    }
}
