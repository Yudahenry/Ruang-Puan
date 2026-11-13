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
            ->whereHas('user', fn ($q) => $q->where('status', 'aktif'))
            ->with(['user', 'jadwalKonsultasis' => function($query) {
                $query->where('status', 'tersedia')
                      ->whereDate('tanggal', '>=', now()->toDateString())
                      ->orderBy('tanggal', 'asc')
                      ->orderBy('jam_mulai', 'asc');
            }])
            ->get();

        return view('konselor.index', compact('konsolors'));
    }

    public function pilihJadwal(Konselor $konselor)
    {
        abort_unless(
            $konselor->status_verifikasi === 'disetujui' &&
            $konselor->user &&
            $konselor->user->status === 'aktif',
            404
        );

        $konselor->load(['user', 'jadwalKonsultasis' => function($query) {
            $query->where('status', 'tersedia')
                  ->whereDate('tanggal', '>=', now()->toDateString())
                  ->orderBy('tanggal', 'asc')
                  ->orderBy('jam_mulai', 'asc');
        }]);

        // Perhatikan: diarahkan ke folder 'konsultasi.jadwal'
        return view('konsultasi.jadwal', compact('konselor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_konsultasis,id',
        ]);

                   $jadwal = JadwalKonsultasi::with('konselor.user')->findOrFail($request->jadwal_id);

           // Konselor nonaktif tidak boleh dibooking
           if (! $jadwal->konselor?->user || $jadwal->konselor->user->status !== 'aktif') {
               return back()->withErrors(['jadwal' => 'Konselor ini sedang tidak tersedia.']);
           }

        if ($jadwal->status !== 'tersedia') {
            return back()->withErrors(['jadwal' => 'Jadwal ini sudah tidak tersedia.']);
        }

        $pemesanan = Pemesanan::create([
            'user_id' => Auth::id(),
            'jadwal_id' => $jadwal->id,
            'status' => 'menunggu_pembayaran',
        ]);

        $jadwal->update(['status' => 'terpesan']);

        return redirect()->route('konsultasi.tagihan', $pemesanan->id)
                         ->with('success', 'Pemesanan konsultasi berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function showTagihan($id)
    {
        $pemesanan = Pemesanan::with(['jadwal.konselor.user', 'user'])->findOrFail($id);
        
        return view('pengguna.konsultasi.tagihan', compact('pemesanan'));
    }

    public function bayar(Request $request, $id)
    {
        // Validasi ketat input pembayaran sesuai form baru
        $request->validate([
            'metode_pembayaran' => 'required|string|in:Transfer Bank,E-Wallet',
            'jenis_bank' => 'required_if:metode_pembayaran,Transfer Bank|nullable|string',
            'no_rekening' => 'required_if:metode_pembayaran,Transfer Bank|nullable|string',
            'jenis_ewallet' => 'required_if:metode_pembayaran,E-Wallet|nullable|string',
            'no_ewallet' => 'required_if:metode_pembayaran,E-Wallet|nullable|string',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);

        // Menggabungkan detail metode, jenis, dan nomor agar tersimpan rapi
        $detailMetode = $request->metode_pembayaran;
        if ($request->metode_pembayaran === 'Transfer Bank') {
            $detailMetode = "Transfer Bank ({$request->jenis_bank} - No. Rek: {$request->no_rekening})";
        } elseif ($request->metode_pembayaran === 'E-Wallet') {
            $detailMetode = "E-Wallet ({$request->jenis_ewallet} - No: {$request->no_ewallet})";
        }

        $pemesanan->update([
            'status' => 'lunas',
            'status_pembayaran' => 'lunas',
            'metode_pembayaran' => $detailMetode,
        ]);

        return redirect()->route('pengguna.dashboard')
                         ->with('success', 'Pembayaran berhasil dikonfirmasi! Jadwal konsultasi Anda telah aktif.');
    }
}
