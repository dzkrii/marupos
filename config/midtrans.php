<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk integrasi Midtrans payment gateway.
    | Pastikan menggunakan kredensial Sandbox untuk testing.
    |
    */

    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'G459560778'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'Mid-client-8TN7WzoqVpmv3MxK'),
    'server_key' => env('MIDTRANS_SERVER_KEY', 'Mid-server-70eyjXB2biZs5IfVoIynOw8Y'),

    // Set to true for sandbox/testing, false for production
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Set to true to sanitize user input
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    // Set to true to enable 3D Secure
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    // Snap API URL
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false) 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
