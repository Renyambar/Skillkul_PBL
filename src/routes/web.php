<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// ============================================================
// 1. RUTE PUBLIK (Dapat diakses tanpa login)
// ============================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/keamanan', function () {
    return view('keamanan');
})->name('keamanan');

// ============================================================
// 2. RUTE PORTAL KLIEN (Wajib Login)
// ============================================================

Route::get('/katalog', [ServiceController::class, 'index'])->name('katalog');
Route::get('/jasa/{id}', [ServiceController::class, 'show'])->name('jasa.detail');
Route::get('/profil/{username}', [ProfileController::class, 'show'])->name('profil.publik');

Route::middleware(['auth'])->group(function () {
    // Dashboard umum — tidak memerlukan 'verified' agar user
    // dapat melihat notifikasi "harap verifikasi email Anda".
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'freelancer') {
            return redirect()->route('freelancer.dasbor');
        }
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index');
        }
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Management
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/toggle-exam-mode', [ProfileController::class, 'toggleExamMode'])->name('profile.toggleExamMode');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form Verifikasi (Jika role=freelancer tapi belum isi KTM)
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // Alur Transaksi Klien
    Route::post('/pesan-jasa/{service_id}', [CheckoutController::class, 'createOrder'])->name('order.create');
    Route::get('/checkout/{order_id}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/{order_id}', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/pesanan-saya', [OrderController::class, 'clientOrders'])->name('pesanan.klien');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('pesanan.detail');
    Route::post('/pesanan/{id}/terima', [OrderController::class, 'acceptOrder'])->name('orders.accept');
    Route::post('/pesanan/{id}/minta-revisi', [OrderController::class, 'requestRevision'])->name('orders.requestRevision');

    // Laporan Klien
    Route::get('/laporan/buat', [\App\Http\Controllers\ReportController::class, 'create'])->name('laporan.buat');
    Route::post('/laporan', [\App\Http\Controllers\ReportController::class, 'store'])->name('laporan.store');

    // Midtrans: Generate Snap Token (dipanggil via AJAX dari halaman checkout)
    Route::post('/midtrans/snap-token/{order_id}', [MidtransController::class, 'getSnapToken'])->name('midtrans.snapToken');

    // ── Wallet Client ──────────────────────────────────────────────────
    Route::get('/dompet', [WalletController::class, 'clientWallet'])->name('client.dompet');

    // ── Withdrawal (Client & Freelancer — shared routes) ───────────────
    Route::get('/withdrawal', [\App\Http\Controllers\WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('/withdrawal', [\App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdrawal.store');
    Route::get('/withdrawal/history', [\App\Http\Controllers\WithdrawalController::class, 'history'])->name('withdrawal.history');

    // ── Notifikasi In-App ──────────────────────────────────────────────
    Route::get('/notifikasi', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/baca', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/baca-semua', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifikasi.readAll');
});

// ============================================================
// 5. WEBHOOK MIDTRANS (Tanpa Auth — Dikecualikan dari CSRF)
// ============================================================

// PENTING: Tambahkan '/midtrans/notification' ke VerifyCsrfToken $except
Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('midtrans.notification');

// ============================================================
// 3. RUTE PORTAL FREELANCER
// ============================================================

Route::middleware(['auth', 'verified', 'role:freelancer'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/dasbor', [DashboardController::class, 'index'])->name('dasbor');
    Route::get('/layanan', [ServiceController::class, 'myServices'])->name('jasa.index');
    Route::get('/buka-jasa', [ServiceController::class, 'create'])->name('jasa.create');
    Route::post('/buka-jasa', [ServiceController::class, 'store'])->name('jasa.store');
    Route::get('/jasa/{service}/edit', [ServiceController::class, 'edit'])->name('jasa.edit');
    Route::put('/jasa/{service}', [ServiceController::class, 'update'])->name('jasa.update');
    Route::delete('/jasa/{service}', [ServiceController::class, 'destroy'])->name('jasa.destroy');
    Route::post('/jasa/{service}/toggle', [ServiceController::class, 'toggle'])->name('jasa.toggle');
    Route::get('/buat-tagihan', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/buat-tagihan', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/dompet', [WalletController::class, 'index'])->name('dompet');
    Route::get('/pesanan', [OrderController::class, 'freelancerOrders'])->name('pesanan');
    Route::post('/pesanan/{id}/kirim-hasil', [OrderController::class, 'submitResult'])->name('pesanan.submitResult');
    Route::post('/pesanan/{id}/kirim-revisi', [OrderController::class, 'submitResult'])->name('pesanan.submitRevision'); // Re-submit after revision

    // ── Portfolio & Auto-Generate PDF ──
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('/portfolio/generate', [PortfolioController::class, 'generate'])->name('portfolio.generate');
    Route::get('/portfolio/{id}/download', [PortfolioController::class, 'download'])->name('portfolio.download');
});

// ============================================================
// 4. RUTE PORTAL ADMIN (Hanya Pantau & Toggle Status)
// ============================================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // ── Admin Dashboard Alias ──
    Route::get('/dashboard', fn () => redirect()->route('admin.users.index'))->name('dashboard');
    // ── Manajemen User ──
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggle'])->name('users.toggle');

    // ── Manajemen Laporan ──
    Route::get('/laporan', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{report}', [\App\Http\Controllers\Admin\ReportController::class, 'show'])->name('laporan.show');
    Route::post('/laporan/{report}/resolve', [\App\Http\Controllers\Admin\ReportController::class, 'resolve'])->name('laporan.resolve');

    // ── Pantau Katalog Jasa ──
    Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [AdminServiceController::class, 'show'])->name('services.show');
    Route::post('/services/{service}/toggle', [AdminServiceController::class, 'toggle'])->name('services.toggle');

    // ── Payment System: Withdrawal Management ──────────────────────────
    Route::get('/withdrawal', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::post('/withdrawal/{id}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawal.approve');
    Route::post('/withdrawal/{id}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawal.reject');
    Route::post('/withdrawal/{id}/complete', [\App\Http\Controllers\Admin\WithdrawalController::class, 'complete'])->name('withdrawal.complete');

    // ── Payment System: Escrow Dashboard ──────────────────────────────
    Route::get('/escrow', [\App\Http\Controllers\Admin\WithdrawalController::class, 'escrowDashboard'])->name('escrow.index');

    // ── Payment System: Ledger Transaksi ──────────────────────────────
    Route::get('/transaksi', [\App\Http\Controllers\Admin\WithdrawalController::class, 'transactions'])->name('transactions.index');
});

require __DIR__ . '/auth.php';

