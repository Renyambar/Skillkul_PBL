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
use Illuminate\Support\Facades\Route;

// ============================================================
// 1. RUTE PUBLIK (Dapat diakses tanpa login)
// ============================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/katalog', [ServiceController::class, 'index'])->name('katalog');

Route::get('/jasa/{id}', [ServiceController::class, 'show'])->name('jasa.detail');

Route::get('/profil/{username}', [ProfileController::class, 'show'])->name('profil.publik');

// ============================================================
// 2. RUTE WAJIB LOGIN (Klien & Freelancer)
// ============================================================

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/toggle-exam-mode', [ProfileController::class, 'toggleExamMode'])->name('profile.toggleExamMode');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form Verifikasi (Jika role=freelancer tapi belum isi KTM)
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store']);

    // Alur Transaksi Klien
    Route::get('/checkout/{order_id}', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/pesanan-saya', [OrderController::class, 'clientOrders'])->name('pesanan.klien');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('pesanan.detail');
});

// ============================================================
// 3. RUTE KHUSUS FREELANCER TERVERIFIKASI
// ============================================================

Route::middleware(['auth', 'check.ktm'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/dasbor', [DashboardController::class, 'index'])->name('dasbor');
    Route::get('/buka-jasa', [ServiceController::class, 'create'])->name('jasa.create');
    Route::get('/buat-tagihan', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('/dompet', [WalletController::class, 'index'])->name('dompet');
});

require __DIR__.'/auth.php';
