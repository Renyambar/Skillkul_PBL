<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Portfolio;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * PortfolioController
 *
 * Mengelola fitur Auto-Portfolio SkillKul:
 * - Menampilkan daftar portfolio freelancer
 * - Generate PDF CV otomatis dari pesanan selesai dengan rating >= 4
 * - Download file PDF yang sudah ada
 */
class PortfolioController extends Controller
{
    /**
     * Tampilkan semua portfolio milik freelancer yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Ambil semua portfolio milik freelancer yang login, beserta relasi order & review-nya
        $portfolios = Portfolio::with(['order.review', 'order.service'])
            ->where('freelancer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('freelancer.portfolios.index', compact('portfolios'));
    }

    /**
     * Generate PDF portfolio otomatis dari pesanan yang memenuhi syarat.
     *
     * Syarat:
     * - Status pesanan = 'completed'
     * - Memiliki review dengan rating >= 4
     * - Belum pernah di-generate (belum ada record di tabel portfolios)
     *
     * Alur:
     * 1. Query order yang memenuhi syarat
     * 2. Kumpulkan semua data project untuk PDF
     * 3. Render template Blade ke PDF menggunakan DomPDF
     * 4. Simpan file ke storage/app/public/portfolios/
     * 5. Insert record ke tabel portfolios
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate(): RedirectResponse
    {
        $freelancer = auth()->user();

        // ── 1. Query order memenuhi syarat (belum punya portfolio) ────────
        $eligibleOrders = Order::with(['service', 'review', 'client'])
            ->where('freelancer_id', $freelancer->id)
            ->where('status', 'completed')
            ->whereHas('review', function ($q) {
                // Hanya order dengan rating >= 4 yang masuk portfolio
                $q->where('rating', '>=', 4);
            })
            ->whereDoesntHave('portfolio') // Hindari duplikasi
            ->get();

        // Tidak ada order memenuhi syarat
        if ($eligibleOrders->isEmpty()) {
            return redirect()->route('freelancer.portfolio.index')
                ->with('info', 'Belum ada pesanan selesai dengan rating ≥ 4 yang bisa di-generate.');
        }

        // ── 2. Kumpulkan data project untuk template PDF ─────────────────
        // Data ini akan dipass ke Blade template sebagai variabel $projects
        $projects = $eligibleOrders->map(function (Order $order) {
            return [
                'title'          => $order->service->title ?? 'Proyek Tanpa Judul',
                'description'    => $order->service->description ?? '-',
                'rating'         => $order->review->rating,
                'comment'        => $order->review->comment ?? '',
                'completed_date' => $order->updated_at->format('d F Y'),
                'client_name'    => $order->client->name,
                'order'          => $order, // objek asli untuk keperluan lain
            ];
        });

        // ── 3. Render Blade template ke PDF menggunakan DomPDF ───────────
        $pdf = Pdf::loadView('portfolios.pdf-template', [
            'freelancer'   => $freelancer,
            'projects'     => $projects,
            'generated_at' => now()->format('d F Y, H:i'),
        ])
        ->setPaper('A4', 'portrait')
        ->setOptions([
            'dpi'                       => 150,
            'isRemoteEnabled'           => false, // Nonaktifkan resource eksternal
            'isHtml5ParserEnabled'      => true,
            'defaultFont'               => 'sans-serif',
            'chroot'                    => public_path(), // Batasi akses file lokal
        ]);

        // ── 4. Simpan PDF ke storage ─────────────────────────────────────
        // Nama file unik: portfolio_{freelancer_id}_{timestamp}.pdf
        $fileName  = 'portfolio_' . $freelancer->id . '_' . now()->format('Ymd_His') . '.pdf';
        $filePath  = 'portfolios/' . $fileName;

        // Pastikan direktori ada
        Storage::disk('public')->makeDirectory('portfolios');

        // Simpan konten PDF ke disk
        Storage::disk('public')->put($filePath, $pdf->output());

        Log::info('[Portfolio] File PDF berhasil dibuat.', [
            'freelancer_id' => $freelancer->id,
            'file_path'     => $filePath,
            'order_count'   => $eligibleOrders->count(),
        ]);

        // ── 5. Insert record portfolio untuk setiap order ─────────────────
        // Semua order dalam satu generate session merujuk ke satu file PDF yang sama
        $createdCount = 0;
        foreach ($eligibleOrders as $order) {
            Portfolio::create([
                'freelancer_id'  => $freelancer->id,
                'order_id'       => $order->id,
                'project_title'  => $order->service->title ?? 'Proyek',
                'completed_date' => $order->updated_at->toDateString(),
                'pdf_file_path'  => $filePath,
            ]);
            $createdCount++;
        }

        return redirect()->route('freelancer.portfolio.index')
            ->with('success', "Portfolio PDF berhasil di-generate dari {$createdCount} pesanan. Silakan unduh.");
    }

    /**
     * Download file PDF portfolio berdasarkan ID.
     *
     * Hanya freelancer pemilik portfolio yang dapat mengunduh.
     *
     * @param  int  $id  ID record portfolio
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function download(int $id)
    {
        // Cari portfolio & pastikan milik freelancer yang login
        $portfolio = Portfolio::where('id', $id)
            ->where('freelancer_id', auth()->id())
            ->firstOrFail();

        // Pastikan file fisik masih ada di storage
        if (! Storage::disk('public')->exists($portfolio->pdf_file_path)) {
            Log::warning('[Portfolio] File PDF tidak ditemukan di storage.', [
                'portfolio_id' => $portfolio->id,
                'file_path'    => $portfolio->pdf_file_path,
            ]);

            return redirect()->route('freelancer.portfolio.index')
                ->with('error', 'File PDF tidak ditemukan. Silakan generate ulang.');
        }

        // Nama file yang tampil saat diunduh
        $downloadName = 'SkillKul_Portfolio_' . str_replace(' ', '_', auth()->user()->name) . '.pdf';

        // Stream file ke browser sebagai download
        return Storage::disk('public')->download($portfolio->pdf_file_path, $downloadName);
    }
}
