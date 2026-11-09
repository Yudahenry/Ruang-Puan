<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Pemesanan;
use App\Models\MateriEdukasi;
use App\Models\LembagaBantuan;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Section 4: Laporan terbarunya user
        $laporanTerbaru = Laporan::where('user_id', $user->id)
            ->latest()
            ->first();

        // Section 4: Konsultasi mendatang (booking terdekat)
        $konsultasiMendatang = Pemesanan::with(['jadwalKonsultasi.konselor.user', 'konsultasi'])
            ->where('user_id', $user->id)
            ->whereHas('jadwalKonsultasi', function ($query) {
                $query->where('tanggal', '>=', now()->toDateString());
            })
            ->join('jadwal_konsultasis', 'pemesanans.jadwal_id', '=', 'jadwal_konsultasis.id')
            ->orderBy('jadwal_konsultasis.tanggal', 'asc')
            ->orderBy('jadwal_konsultasis.jam_mulai', 'asc')
            ->select('pemesanans.*')
            ->first();

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