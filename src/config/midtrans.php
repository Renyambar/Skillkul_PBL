<?php

/**
 * Konfigurasi Midtrans Payment Gateway
 *
 * File ini menyimpan semua konfigurasi yang dibutuhkan untuk integrasi
 * dengan Midtrans (Snap API). Semua key dibaca dari file .env agar
 * tidak ter-expose di repository.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Merchant ID
    |--------------------------------------------------------------------------
    |
    | ID merchant yang didapatkan dari dashboard Midtrans.
    |
    */
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Server Key
    |--------------------------------------------------------------------------
    |
    | Server Key digunakan untuk komunikasi server-to-server (backend).
    | JANGAN pernah expose key ini di frontend/client-side.
    |
    */
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Client Key
    |--------------------------------------------------------------------------
    |
    | Client Key digunakan untuk Snap.js di frontend/browser.
    | Key ini aman untuk di-embed di halaman HTML.
    |
    */
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Environment (Sandbox / Production)
    |--------------------------------------------------------------------------
    |
    | true  = Sandbox (testing, transaksi tidak nyata)
    | false = Production (transaksi uang asli)
    |
    | Pastikan menggunakan key yang sesuai dengan environment.
    |
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitasi & 3DS
    |--------------------------------------------------------------------------
    |
    | is_sanitized: Sanitasi parameter request secara otomatis.
    | is_3ds: Aktifkan 3D Secure untuk transaksi kartu kredit (recommended).
    |
    */
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    /*
    |--------------------------------------------------------------------------
    | URL Endpoints
    |--------------------------------------------------------------------------
    |
    | URL Snap untuk Sandbox dan Production.
    | Digunakan untuk mengarahkan pembayaran ke halaman Snap Midtrans.
    |
    */
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',

];
