<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function regenerateAccessCode()
    {
        $user = auth()->user();
        $outlet = $user->currentOutlet;

        if (!$outlet) {
            return back()->with('error', 'Outlet tidak ditemukan.');
        }

        // Generate 6 digit random number
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $outlet->update(['qr_access_code' => $code]);

        return back()->with('success', 'Kode akses QR berhasil diperbarui: ' . $code);
    }
}
