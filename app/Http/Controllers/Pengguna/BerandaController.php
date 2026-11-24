<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use App\Models\Pemesanan;
use App\Models\Konsultasi;
use App\Models\JadwalKonsultasi;
use App\Models\MateriEdukasi;
use App\Models\LembagaBantuan;
use Carbon\Carbon;

class BerandaController extends Controller
{
    /**
     * Menampilkan dashboard beranda pengguna dengan data dinamis dari database MySQL.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userId = $user->id;

        // -------------------------------------------------------------
        // 1. STATISTIK / METRIK RINGKASAN PENGGUNA (Default 0)
        // -------------------------------------------------------------
        // Metrik Laporan
        $totalLaporan = Laporan::where('user_id', $userId)->count();
        $laporanAktif = Laporan::where('user_id', $userId)
            ->whereIn('status', ['diterima', 'diverifikasi', 'diproses', 'diteruskan_ke_lembaga'])
            ->count();
        $laporanSelesai = Laporan::where('user_id', $userId)
            ->whereIn('status', ['selesai', 'ditutup'])
            ->count();

        // Metrik Pemesanan & Sesi Konsultasi
        $totalKonsultasi = Pemesanan::where('pemesanans.user_id', $userId)->count();

        // Konsultasi Aktif/Akan Datang: belum batal/ditolak dan jadwal belum lewat
        $konsultasiAktif = Pemesanan::where('pemesanans.user_id', $userId)
            ->whereNotIn('pemesanans.status', ['batal', 'ditolak'])
            ->join('jadwal_konsultasis', 'pemesanans.jadwal_id', '=', 'jadwal_konsultasis.id')
            ->where(function ($query) {
                $query->where('jadwal_konsultasis.tanggal', '>', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->where('jadwal_konsultasis.tanggal', '=', now()->toDateString())
                          ->where('jadwal_konsultasis.jam_selesai', '>=', now()->toTimeString());
                    });
            })
            ->count();

        // Konsultasi Selesai: status selesai atau waktu jadwal sudah berlalu
        $konsultasiSelesai = Pemesanan::where('pemesanans.user_id', $userId)
            ->whereNotIn('pemesanans.status', ['batal', 'ditolak'])
            ->join('jadwal_konsultasis', 'pemesanans.jadwal_id', '=', 'jadwal_konsultasis.id')
            ->where(function ($query) {
                $query->where('pemesanans.status', 'selesai')
                    ->orWhere(function ($q) {
                        $q->where('jadwal_konsultasis.tanggal', '<', now()->toDateString())
                          ->orWhere(function ($q2) {
                              $q2->where('jadwal_konsultasis.tanggal', '=', now()->toDateString())
                                ->where('jadwal_konsultasis.jam_selesai', '<', now()->toTimeString());
                          });
                    });
            })
            ->count();

        // Tagihan Pembayaran
        $tagihanMenunggu = Pemesanan::where('pemesanans.user_id', $userId)
            ->where(function ($query) {
                $query->where('pemesanans.status_pembayaran', 'menunggu')
                      ->orWhere('pemesanans.status', 'menunggu_pembayaran');
            })
            ->whereNotIn('pemesanans.status', ['batal', 'ditolak'])
            ->count();

        $tagihanLunas = Pemesanan::where('pemesanans.user_id', $userId)
            ->where(function ($query) {
                $query->where('pemesanans.status_pembayaran', 'lunas')
                      ->orWhere('pemesanans.status', 'terkonfirmasi');
            })
            ->count();

        // -------------------------------------------------------------
        // 2. KONSULTASI MENDATANG / TERDEKAT
        // -------------------------------------------------------------
        // Query eksplisit dengan prefix tabel agar tidak memicu ambiguous column error
        $konsultasiMendatang = Pemesanan::with([
                'jadwalKonsultasi.konselor.user',
                'pembayaran',
                'konsultasi'
            ])
            ->where('pemesanans.user_id', $userId)
            ->whereNotIn('pemesanans.status', ['batal', 'ditolak', 'selesai'])
            ->join('jadwal_konsultasis', 'pemesanans.jadwal_id', '=', 'jadwal_konsultasis.id')
            ->where(function ($query) {
                $query->where('jadwal_konsultasis.tanggal', '>', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->where('jadwal_konsultasis.tanggal', '=', now()->toDateString())
                          ->where('jadwal_konsultasis.jam_selesai', '>=', now()->toTimeString());
                    });
            })
            ->orderBy('jadwal_konsultasis.tanggal', 'asc')
            ->orderBy('jadwal_konsultasis.jam_mulai', 'asc')
            ->select('pemesanans.*')
            ->first();

        // Sinkronisasi otomatis entri model Konsultasi jika pemesanan sudah lunas/terkonfirmasi
        if ($konsultasiMendatang && (
            in_array($konsultasiMendatang->status, ['terkonfirmasi', 'lunas']) || 
            $konsultasiMendatang->status_pembayaran === 'lunas'
        )) {
            if ($konsultasiMendatang->status !== 'terkonfirmasi') {
                $konsultasiMendatang->update(['status' => 'terkonfirmasi']);
                $konsultasiMendatang->status = 'terkonfirmasi';
            }

            if (!$konsultasiMendatang->konsultasi && $konsultasiMendatang->jadwalKonsultasi) {
                $konsultasi = Konsultasi::firstOrCreate(
                    ['pemesanan_id' => $konsultasiMendatang->id],
                    [
                        'tanggal_konsultasi' => $konsultasiMendatang->jadwalKonsultasi->tanggal,
                        'jam_konsultasi'     => $konsultasiMendatang->jadwalKonsultasi->jam_mulai,
                        'status'             => 'terjadwal',
                    ]
                );
                $konsultasiMendatang->setRelation('konsultasi', $konsultasi);
            }
        }

        // -------------------------------------------------------------
        // 3. DAFTAR PEMESANAN / SESI KONSULTASI TERBARU (5 item)
        // -------------------------------------------------------------
        $riwayatPemesanan = Pemesanan::with([
                'jadwalKonsultasi.konselor.user',
                'pembayaran',
                'konsultasi'
            ])
            ->where('pemesanans.user_id', $userId)
            ->latest('pemesanans.created_at')
            ->take(5)
            ->get();

        // -------------------------------------------------------------
        // 4. LAPORAN TERBARU & DAFTAR LAPORAN TERAKHIR
        // -------------------------------------------------------------
        $laporanTerbaru = Laporan::where('user_id', $userId)
            ->latest()
            ->first();

        $riwayatLaporan = Laporan::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // -------------------------------------------------------------
        // 5. MATERI EDUKASI & DIREKTORI BANTUAN
        // -------------------------------------------------------------
        $materiEdukasis = MateriEdukasi::with('kategoriEdukasi')
            ->whereIn('status', ['terbit', 'publish'])
            ->latest('tanggal_posting')
            ->take(4)
            ->get();

        $wilayahList = LembagaBantuan::where('status', 'aktif')
            ->whereNotNull('wilayah')
            ->distinct()
            ->orderBy('wilayah')
            ->pluck('wilayah');

        $layananList = LembagaBantuan::where('status', 'aktif')
            ->whereNotNull('jenis_layanan')
            ->distinct()
            ->orderBy('jenis_layanan')
            ->pluck('jenis_layanan');

        return view('pengguna.dashboard', compact(
            'user',
            'totalLaporan',
            'laporanAktif',
            'laporanSelesai',
            'totalKonsultasi',
            'konsultasiAktif',
            'konsultasiSelesai',
            'tagihanMenunggu',
            'tagihanLunas',
            'konsultasiMendatang',
            'riwayatPemesanan',
            'laporanTerbaru',
            'riwayatLaporan',
            'materiEdukasis',
            'wilayahList',
            'layananList'
        ));
    }
}
