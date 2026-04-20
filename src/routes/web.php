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
    // Dashboard Klien
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

    // Profile Management
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/toggle-exam-mode', [ProfileController::class, 'toggleExamMode'])->name('profile.toggleExamMode');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form Verifikasi (Jika role=freelancer tapi belum isi KTM)
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // Alur Transaksi Klien
    Route::get('/checkout/{order_id}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/{order_id}', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/pesanan-saya', [OrderController::class, 'clientOrders'])->name('pesanan.klien');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('pesanan.detail');
    Route::post('/pesanan/{id}/review', [OrderController::class, 'review'])->name('orders.review');
});

// ============================================================
// 3. RUTE PORTAL FREELANCER
// ============================================================

Route::middleware(['auth'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/dasbor', [DashboardController::class, 'index'])->name('dasbor');
    Route::get('/layanan', function () {
        return view('freelancer.services.index');
    })->name('jasa.index');
    Route::get('/buka-jasa', [ServiceController::class, 'create'])->name('jasa.create');
    Route::post('/buka-jasa', [ServiceController::class, 'store'])->name('jasa.store');
    Route::get('/buat-tagihan', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/buat-tagihan', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/dompet', [WalletController::class, 'index'])->name('dompet');
    Route::get('/pesanan', function () {
        return view('freelancer.orders.index');
    })->name('pesanan');
});

// ============================================================
// 4. RUTE PORTAL ADMIN
// ============================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
});

require __DIR__.'/auth.php';
