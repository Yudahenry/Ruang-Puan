<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;

class RiwayatKonsultasiController extends Controller
{
    public function index()
    {
        $konsultasis = Konsultasi::with([
            'pemesanan.jadwalKonsultasi.konselor.user',
            'pemesanan.pembayaran',
        ])
        ->whereHas('pemesanan', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->latest()
        ->get();

        return view('pengguna.riwayat-konsultasi.index', compact('konsultasis'));
    }
}
