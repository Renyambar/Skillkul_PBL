<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

// ==========================================
// PEMBERITAHUAN GUEST (Tidak Perlu Login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    // Katalog Jasa
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');
});

// ==========================================
// RUTE DENGAN AUTENTIKASI (Perlu Login)
// ==========================================
Route::middleware('auth')->group(function () {

    // Dashboard & Profil
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manajemen Jasa Saya (Freelancer)
    Route::get('/my-services', [ServiceController::class, 'myServices'])->name('services.my');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Transaksi & Pesanan
    Route::get('/orders/my-orders', [OrderController::class, 'myOrders'])->name('orders.my_orders'); // Sisi Pembeli
    Route::get('/orders/incoming', [OrderController::class, 'incomingOrders'])->name('orders.incoming'); // Sisi Freelancer

    Route::get('/orders/checkout/{service}', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store'); // Buat Order Non-Project
    Route::post('/orders/custom-invoice', [OrderController::class, 'storeCustomInvoice'])->name('orders.custom_invoice'); // Buat Custom Order (Project)

    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});
