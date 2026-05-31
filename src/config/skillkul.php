<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Platform Fee Percentage
    |--------------------------------------------------------------------------
    |
    | Persentase fee yang diambil platform dari setiap order yang selesai.
    | Freelancer menerima: (100 - platform_fee_percent)% dari total_price.
    |
    | Contoh: 8 artinya platform ambil 8%, freelancer terima 92%.
    |
    */
    'platform_fee_percent' => (float) env('PLATFORM_FEE_PERCENT', 8),

    /*
    |--------------------------------------------------------------------------
    | Auto-Complete Delay (Hours)
    |--------------------------------------------------------------------------
    |
    | Berapa jam setelah freelancer submit hasil (status = delivered),
    | sistem otomatis menyelesaikan order jika client tidak memberi respon.
    |
    */
    'auto_complete_hours' => (int) env('AUTO_COMPLETE_HOURS', 48),

    /*
    |--------------------------------------------------------------------------
    | Minimum Withdrawal Amount
    |--------------------------------------------------------------------------
    |
    | Nominal minimum penarikan saldo (dalam Rupiah).
    |
    */
    'min_withdrawal_amount' => (int) env('MIN_WITHDRAWAL_AMOUNT', 50000),

];
