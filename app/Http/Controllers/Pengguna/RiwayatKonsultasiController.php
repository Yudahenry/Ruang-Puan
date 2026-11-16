<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class RiwayatKonsultasiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil seluruh riwayat pemesanan/booking milik pengguna
        $pemesanans = Pemesanan::with([
            'jadwalKonsultasi.konselor.user',
            'pembayaran',
            'konsultasi',
        ])
        ->where('user_id', $userId)
        ->latest()
        ->get();

        // 2. Tetap pertahankan query $konsultasis lama agar view eksisting tidak rusak
        $konsultasis = Konsultasi::with([
            'pemesanan.jadwalKonsultasi.konselor.user',
            'pemesanan.pembayaran',
        ])
        ->whereHas('pemesanan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest()
        ->get();

        // 3. Hitung statistik otomatis berdasarkan waktu (Tanggal & Jam Selesai Jadwal)
        $totalKonsultasi = $pemesanans->count();

        $akanDatang = $pemesanans->filter(function ($item) {
            $jadwal = $item->jadwalKonsultasi;
            $statusRaw = strtolower($item->konsultasi?->status_efektif ?? $item->status ?? '');
            
            // Jika sudah batal atau ditolak, jangan masuk "Akan Datang"
            if (in_array($statusRaw, ['batal', 'ditolak'])) {
                return false;
            }

            // Jika ada jadwal, periksa apakah waktu selesainya masih di masa depan
            if ($jadwal) {
                $waktuSelesai = \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_selesai);
                return $waktuSelesai->isFuture();
            }

            // Fallback jika belum ada jadwal
            return in_array($statusRaw, ['pending', 'menunggu_pembayaran', 'menunggu_konfirmasi', 'terkonfirmasi', 'terjadwal', 'berlangsung', 'aktif']);
        })->count();

        $selesai = $pemesanans->filter(function ($item) {
            $jadwal = $item->jadwalKonsultasi;
            $statusRaw = strtolower($item->konsultasi?->status_efektif ?? $item->status ?? '');

            // Jika waktu jadwal sudah lewat, otomatis dihitung selesai
            if ($jadwal) {
                $waktuSelesai = \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_selesai);
                if ($waktuSelesai->isPast() && !in_array($statusRaw, ['batal', 'ditolak'])) {
                    return true;
                }
            }

            // Atau jika status di database memang sudah selesai / completed
            return in_array($statusRaw, ['selesai', 'completed']);
        })->count();

        return view('pengguna.riwayat-konsultasi.index', compact(
            'konsultasis',
            'pemesanans',
            'totalKonsultasi',
            'akanDatang',
            'selesai'
        ));
    }

    public function invoice($id)
    {
        // Cari data pemesanan berdasarkan ID dan pastikan milik pengguna yang sedang login
        $pemesanan = Pemesanan::with([
            'user',
            'jadwalKonsultasi.konselor.user',
            'pembayaran',
            'konsultasi',
        ])
        ->where('user_id', Auth::id())
        ->findOrFail($id);

        return view('pengguna.riwayat-konsultasi.invoice', compact('pemesanan'));
    }
}