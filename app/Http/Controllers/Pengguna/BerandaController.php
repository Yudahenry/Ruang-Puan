<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Pemesanan;
use App\Models\MateriEdukasi;
use App\Models\LembagaBantuan;
use Carbon\Carbon;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Section 4: Laporan terbarunya user
        $laporanTerbaru = Laporan::where('user_id', $user->id)
            ->latest()
            ->first();

        // Section 4: Konsultasi mendatang (booking terdekat yang jam sesinya belum selesai)
        $sekarang = now();

        $kandidatKonsultasi = Pemesanan::with(['jadwalKonsultasi.konselor.user', 'konsultasi'])
            ->where('pemesanans.user_id', $user->id)
            ->whereNotIn('pemesanans.status', ['batal', 'ditolak', 'selesai'])
            ->whereHas('jadwalKonsultasi', function ($query) use ($sekarang) {
                $query->whereDate('tanggal', '>=', $sekarang->toDateString());
            })
            ->join('jadwal_konsultasis', 'pemesanans.jadwal_id', '=', 'jadwal_konsultasis.id')
            ->orderBy('jadwal_konsultasis.tanggal', 'asc')
            ->orderBy('jadwal_konsultasis.jam_mulai', 'asc')
            ->select('pemesanans.*')
            ->get();

        $konsultasiMendatang = $kandidatKonsultasi->first(function ($item) use ($sekarang) {
            $jadwal = $item->jadwalKonsultasi;
            if (!$jadwal || !$jadwal->tanggal) {
                return false;
            }

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

            return $sekarang->lessThan($waktuSelesai);
        });

        // Pastikan relasi konsultasi selalu tersedia bila pemesanan terkonfirmasi / lunas
        $isConfirmed = $konsultasiMendatang && (
            in_array($konsultasiMendatang->status, ['terkonfirmasi', 'lunas']) || 
            $konsultasiMendatang->status_pembayaran === 'lunas'
        );

        if ($isConfirmed) {
            if ($konsultasiMendatang->status !== 'terkonfirmasi') {
                $konsultasiMendatang->update(['status' => 'terkonfirmasi']);
                $konsultasiMendatang->status = 'terkonfirmasi';
            }

            if (!$konsultasiMendatang->konsultasi) {
                $konsultasi = \App\Models\Konsultasi::firstOrCreate(
                    ['pemesanan_id' => $konsultasiMendatang->id],
                    [
                        'tanggal_konsultasi' => $konsultasiMendatang->jadwalKonsultasi?->tanggal,
                        'jam_konsultasi'     => $konsultasiMendatang->jadwalKonsultasi?->jam_mulai,
                        'status'             => 'terjadwal',
                    ]
                );
                $konsultasiMendatang->setRelation('konsultasi', $konsultasi);
            }
        }

        // Section 5: Materi edukasi terbaru (4 items)
        $materiEdukasis = MateriEdukasi::with('kategoriEdukasi')
            ->where('status', 'publish')
            ->latest()
            ->take(4)
            ->get();

        // Section 6: Wilayah untuk dropdown filter direktori
        $wilayahList = LembagaBantuan::select('wilayah')->distinct()->pluck('wilayah');
        $layananList = LembagaBantuan::select('jenis_layanan')->distinct()->pluck('jenis_layanan');

        return view('beranda.pengguna', compact(
            'laporanTerbaru',
            'konsultasiMendatang',
            'materiEdukasis',
            'wilayahList',
            'layananList'
        ));
    }
}