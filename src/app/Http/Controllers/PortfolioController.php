<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * PortfolioController
 *
 * Mengelola fitur Project Portfolio SkillKul untuk freelancer:
 * - Tampilkan daftar portfolio + order yang bisa ditambahkan
 * - Tambah order ke portfolio (hanya project type)
 * - Edit data portfolio
 * - Toggle visibility (is_portfolio)
 * - Toggle featured (is_featured, max 3)
 * - Generate PDF
 * - Download PDF
 * - Hapus dari portfolio (set is_portfolio = false)
 */
class PortfolioController extends Controller
{
    public function __construct(protected PortfolioService $portfolioService) {}

    // ─── Index ────────────────────────────────────────────────

    /**
     * Tampilkan halaman portfolio freelancer + daftar order eligible.
     */
    public function index(): View
    {
        $freelancer = auth()->user();

        // Portfolio yang sudah dibuat (semua, termasuk yang hidden)
        $portfolios = Portfolio::with(['order.review', 'order.service'])
            ->where('freelancer_id', $freelancer->id)
            ->ordered()
            ->paginate(12, ['*'], 'portfolio');

        // Order project yang COMPLETED tapi belum punya portfolio entry
        $eligibleOrders = Order::with(['service.category', 'review'])
            ->where('freelancer_id', $freelancer->id)
            ->where('status', 'completed')
            ->whereHas('service', fn ($q) => $q->where('type', 'project'))
            ->whereDoesntHave('portfolio')
            ->latest('completed_at')
            ->get();

        // Statistik
        $stats = $this->portfolioService->calculateStats($freelancer);

        // Achievements
        $achievements        = $freelancer->achievements()->get();
        $allBadges           = app(\App\Services\AchievementService::class)->getAllBadgeDefinitions();
        $unlockedBadgeKeys   = $achievements->pluck('badge_key')->toArray();

        return view('freelancer.portfolios.index', compact(
            'portfolios',
            'eligibleOrders',
            'stats',
            'achievements',
            'allBadges',
            'unlockedBadgeKeys'
        ));
    }

    // ─── Add to Portfolio ─────────────────────────────────────

    /**
     * Tampilkan form untuk menambahkan order ke portfolio.
     */
    public function create(string $orderId): View
    {
        $order = Order::with(['service.category', 'review', 'client'])
            ->where('freelancer_id', auth()->id())
            ->findOrFail($orderId);

        // Pastikan order bisa ditambahkan ke portfolio
        abort_unless($order->can_add_to_portfolio, 422, 'Order ini tidak dapat ditambahkan ke portfolio.');

        return view('freelancer.portfolios.add', compact('order'));
    }

    /**
     * Simpan order ke portfolio freelancer.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_id'       => ['required', 'string'],
            'freelancer_role'=> ['nullable', 'string', 'max:100'],
            'cloud_link'     => ['nullable', 'url', 'max:500'],
        ], [
            'cloud_link.url' => 'Link cloud harus berupa URL yang valid.',
        ]);

        $order = Order::with(['service.category', 'review'])
            ->where('freelancer_id', auth()->id())
            ->findOrFail($validated['order_id']);

        // Guard: hanya project type
        if ($order->service?->type !== 'project') {
            return redirect()->back()
                ->with('error', 'Hanya pesanan dari layanan berbasis project yang dapat dijadikan portfolio.');
        }

        // Guard: harus completed
        if ($order->status !== 'completed') {
            return redirect()->back()
                ->with('error', 'Pesanan belum selesai.');
        }

        // Guard: belum ada portfolio
        if ($order->portfolio()->exists()) {
            return redirect()->route('freelancer.portfolio.index')
                ->with('info', 'Pesanan ini sudah ada di portfolio Anda.');
        }

        $this->portfolioService->buildFromOrder($order, [
            'freelancer_role' => $validated['freelancer_role'] ?? null,
            'cloud_link'      => $validated['cloud_link'] ?? null,
        ]);

        return redirect()->route('freelancer.portfolio.index')
            ->with('success', 'Project berhasil ditambahkan ke portfolio! 🎉');
    }

    // ─── Edit Portfolio ───────────────────────────────────────

    /**
     * Tampilkan form edit portfolio.
     */
    public function edit(int $id): View
    {
        $portfolio = Portfolio::where('freelancer_id', auth()->id())
            ->with('order.service')
            ->findOrFail($id);

        return view('freelancer.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update data portfolio (role, cloud_link, dll).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $portfolio = Portfolio::where('freelancer_id', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'freelancer_role' => ['nullable', 'string', 'max:100'],
            'cloud_link'      => ['nullable', 'url', 'max:500'],
        ], [
            'cloud_link.url' => 'Link cloud harus berupa URL yang valid.',
        ]);

        $portfolio->update($validated);

        return redirect()->route('freelancer.portfolio.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    // ─── Visibility Toggle ────────────────────────────────────

    /**
     * Toggle is_portfolio (tampil/sembunyikan dari halaman publik).
     */
    public function toggleVisibility(int $id): RedirectResponse
    {
        $portfolio = Portfolio::where('freelancer_id', auth()->id())
            ->findOrFail($id);

        $newState = ! $portfolio->is_portfolio;

        // Jika disembunyikan, juga non-featured
        $portfolio->update([
            'is_portfolio' => $newState,
            'is_featured'  => $newState ? $portfolio->is_featured : false,
        ]);

        $message = $newState
            ? 'Project ditampilkan di portfolio publik.'
            : 'Project disembunyikan dari portfolio publik.';

        return redirect()->route('freelancer.portfolio.index')
            ->with('success', $message);
    }

    // ─── Featured Toggle ──────────────────────────────────────

    /**
     * Toggle is_featured (max 3 per freelancer).
     */
    public function toggleFeatured(int $id): RedirectResponse
    {
        $portfolio = Portfolio::where('freelancer_id', auth()->id())
            ->findOrFail($id);

        // Pastikan portfolio sudah visible sebelum di-featured
        if (! $portfolio->is_portfolio && ! $portfolio->is_featured) {
            return redirect()->route('freelancer.portfolio.index')
                ->with('error', 'Aktifkan visibilitas portfolio terlebih dahulu sebelum menjadikannya featured.');
        }

        // Cek limit featured (max 3)
        if (! $portfolio->is_featured) {
            $currentFeaturedCount = Portfolio::where('freelancer_id', auth()->id())
                ->where('is_featured', true)
                ->count();

            if ($currentFeaturedCount >= 3) {
                return redirect()->route('freelancer.portfolio.index')
                    ->with('error', 'Maksimal 3 Featured Projects. Hapus featured lain terlebih dahulu.');
            }
        }

        $portfolio->update(['is_featured' => ! $portfolio->is_featured]);

        $message = $portfolio->fresh()->is_featured
            ? '⭐ Project ditambahkan ke Featured Projects!'
            : 'Project dihapus dari Featured Projects.';

        return redirect()->route('freelancer.portfolio.index')
            ->with('success', $message);
    }

    // ─── Destroy ──────────────────────────────────────────────

    /**
     * Hapus project dari portfolio (set is_portfolio = false, bukan delete record).
     * Record tetap ada agar bisa di-re-add nantinya.
     */
    public function destroy(int $id): RedirectResponse
    {
        $portfolio = Portfolio::where('freelancer_id', auth()->id())
            ->findOrFail($id);

        $portfolio->update([
            'is_portfolio' => false,
            'is_featured'  => false,
        ]);

        return redirect()->route('freelancer.portfolio.index')
            ->with('success', 'Project dihapus dari portfolio.');
    }

    // ─── Generate PDF ─────────────────────────────────────────

    /**
     * Generate PDF portfolio dari semua project dengan is_portfolio = true.
     */
    public function generatePdf(): RedirectResponse
    {
        $freelancer = auth()->user();

        $portfolioCount = Portfolio::where('freelancer_id', $freelancer->id)
            ->public()
            ->count();

        if ($portfolioCount === 0) {
            return redirect()->route('freelancer.portfolio.index')
                ->with('info', 'Belum ada project yang ditampilkan di portfolio. Aktifkan visibilitas minimal satu project terlebih dahulu.');
        }

        try {
            $filePath = $this->portfolioService->generatePdf($freelancer);

            // Simpan path PDF ke semua portfolio (opsional — referensi)
            Portfolio::where('freelancer_id', $freelancer->id)
                ->public()
                ->update(['pdf_file_path' => $filePath]);

            return redirect()->route('freelancer.portfolio.index')
                ->with('success', "Portfolio PDF berhasil dibuat dari {$portfolioCount} project. Klik Unduh PDF untuk mengunduh.")
                ->with('pdf_path', $filePath);

        } catch (\Exception $e) {
            Log::error('[PortfolioController] Gagal generate PDF.', [
                'error'         => $e->getMessage(),
                'freelancer_id' => $freelancer->id,
            ]);

            return redirect()->route('freelancer.portfolio.index')
                ->with('error', 'Gagal membuat PDF portfolio. Silakan coba lagi.');
        }
    }

    // ─── Download ─────────────────────────────────────────────

    /**
     * Download file PDF portfolio berdasarkan ID portfolio.
     */
    public function download(int $id)
    {
        $portfolio = Portfolio::where('id', $id)
            ->where('freelancer_id', auth()->id())
            ->firstOrFail();

        if (! $portfolio->pdf_file_path || ! Storage::disk('public')->exists($portfolio->pdf_file_path)) {
            Log::warning('[PortfolioController] File PDF tidak ditemukan.', [
                'portfolio_id' => $portfolio->id,
                'file_path'    => $portfolio->pdf_file_path,
            ]);

            return redirect()->route('freelancer.portfolio.index')
                ->with('error', 'File PDF tidak ditemukan. Silakan generate ulang.');
        }

        $downloadName = 'SkillKul_Portfolio_' . str_replace(' ', '_', auth()->user()->name) . '.pdf';

        return Storage::disk('public')->download($portfolio->pdf_file_path, $downloadName);
    }

    // ─── Download Latest PDF ──────────────────────────────────

    /**
     * Download PDF terbaru dari portfolio freelancer yang sedang login.
     */
    public function downloadLatest()
    {
        $freelancer = auth()->user();

        // Cari portfolio dengan pdf_file_path terbaru
        $portfolio = Portfolio::where('freelancer_id', $freelancer->id)
            ->whereNotNull('pdf_file_path')
            ->latest()
            ->first();

        if (! $portfolio || ! Storage::disk('public')->exists($portfolio->pdf_file_path)) {
            return redirect()->route('freelancer.portfolio.index')
                ->with('error', 'File PDF tidak ditemukan. Silakan generate ulang portfolio PDF Anda.');
        }

        $downloadName = 'SkillKul_Portfolio_' . str_replace(' ', '_', $freelancer->name) . '.pdf';

        return Storage::disk('public')->download($portfolio->pdf_file_path, $downloadName);
    }
}
