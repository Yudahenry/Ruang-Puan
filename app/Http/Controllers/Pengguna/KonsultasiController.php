<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use App\Models\JadwalKonsultasi;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    public function index()
    {
        $konsolors = Konselor::where('status_verifikasi', 'disetujui')
            ->with(['user', 'jadwalKonsultasis' => function($query) {
                $query->where('status', 'tersedia')
                      ->where('tanggal', '>=', now()->toDateString());
            }])
            ->get();
        
        return view('konselor.index', compact('konsolors'));
    }

    public function pilihJadwal(Konselor $konselor)
    {
        $konselor->load(['user', 'jadwalKonsultasis' => function($query) {
            $query->where('status', 'tersedia')
                  ->where('tanggal', '>=', now()->toDateString());
        }]);
        
        // Perhatikan: diarahkan ke folder 'konsultasi.jadwal'
        return view('konsultasi.jadwal', compact('konselor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_konsultasis,id',
        ]);

        $jadwal = JadwalKonsultasi::findOrFail($request->jadwal_id);
        
        if ($jadwal->status !== 'tersedia') {
            return back()->withErrors(['jadwal' => 'Jadwal ini sudah tidak tersedia.']);
        }

        $pemesanan = Pemesanan::create([
            'user_id' => Auth::id(),
            'jadwal_id' => $jadwal->id,
            'status' => 'menunggu_pembayaran',
        ]);

        $jadwal->update(['status' => 'terpesan']);

        return redirect()->route('pengguna.dashboard')->with('success', 'Pemesanan konsultasi berhasil dibuat. Silakan lakukan pembayaran.');
    }
}