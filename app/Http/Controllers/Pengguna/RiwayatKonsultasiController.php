<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatKonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $pemesanans = Pemesanan::with([
                'jadwalKonsultasi.konselor.user',
                'jadwal.konselor.user',
                'konsultasi',
                'pembayaran',
            ])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $sekarang = now();
        $akanDatang = 0;
        $selesai = 0;

        foreach ($pemesanans as $item) {
            $jadwal = $item->jadwalKonsultasi ?? $item->jadwal;
            $statusRaw = strtolower((string) ($item->konsultasi?->status_efektif ?? $item->status ?? 'menunggu'));

            if (in_array($statusRaw, ['batal', 'ditolak'])) {
                continue;
            }

            $sudahLewat = false;
            if ($jadwal && $jadwal->tanggal) {
                $tanggalSaja = Carbon::parse($jadwal->tanggal)->format('Y-m-d');
                $jamSelesaiStr = $jadwal->jam_selesai ?: ($jadwal->jam_mulai ?: '23:59:59');
                if (strlen($jamSelesaiStr) === 5) {
                    $jamSelesaiStr .= ':00';
                }
                $waktuSelesai = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $tanggalSaja . ' ' . $jamSelesaiStr,
                    config('app.timezone')
                );
                $sudahLewat = $sekarang->greaterThanOrEqualTo($waktuSelesai);
            }

            if ($sudahLewat || $statusRaw === 'selesai') {
                $selesai++;
            } else {
                $akanDatang++;
            }
        }

        $totalKonsultasi = $pemesanans->count();

        return view('pengguna.riwayat-konsultasi.index', compact(
            'pemesanans',
            'totalKonsultasi',
            'akanDatang',
            'selesai'
        ));
    }

    public function invoice($id)
    {
        $pemesanan = Pemesanan::with([
                'jadwalKonsultasi.konselor.user',
                'jadwal.konselor.user',
                'konsultasi',
                'pembayaran',
                'user',
            ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if (view()->exists('pengguna.riwayat-konsultasi.invoice')) {
            return view('pengguna.riwayat-konsultasi.invoice', compact('pemesanan'));
        }

        return view('pengguna.konsultasi.tagihan', compact('pemesanan'));
    }
}