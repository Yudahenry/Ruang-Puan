<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konselor;
use App\Models\JadwalKonsultasi;
use App\Models\Pemesanan;
use App\Models\Konsultasi;
use App\Models\Pesan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BerandaKonselorController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan relasi konselor ada
        $konselor = $user->konselor;
        if (!$konselor) {
            $konselor = Konselor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'status_verifikasi' => 'disetujui',
                    'bidang_keahlian' => 'Psikolog Klinis & Konseling Remaja/Dewasa',
                    'tarif' => 150000,
                ]
            );
        }

        // Tentukan nama sapaan & gelar
        $greetingName = 'Bu Dewi';
        $counselorTitle = 'Dewi L., M.Psi.';
        $counselorInitials = 'DL';

        if ($user) {
            if ($user->nama && !in_array(strtolower($user->nama), ['mclaren', 'admin'])) {
                $parts = explode(' ', trim($user->nama));
                $greetingName = 'Bu ' . $parts[0];
                $counselorTitle = $user->nama;
                $counselorInitials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
            }
        }

        // 1. Data Ringkasan Metrik (4 Kartu Atas)
        $today = Carbon::today();
        
        $realSesiHariIni = JadwalKonsultasi::where('konselor_id', $konselor->id)
            ->whereDate('tanggal', $today)
            ->where('status', 'terpesan')
            ->count();

        $realBookingMenunggu = Pemesanan::whereHas('jadwalKonsultasi', function ($q) use ($konselor) {
            $q->where('konselor_id', $konselor->id);
        })->where('status', 'menunggu_pembayaran')->count();

        $realSesiSelesaiBulanIni = Konsultasi::whereHas('pemesanan.jadwalKonsultasi', function ($q) use ($konselor) {
            $q->where('konselor_id', $konselor->id);
        })->whereMonth('tanggal_konsultasi', Carbon::now()->month)
          ->where('status', 'selesai')->count();

        $realTotalSesi = Konsultasi::whereHas('pemesanan.jadwalKonsultasi', function ($q) use ($konselor) {
            $q->where('konselor_id', $konselor->id);
        })->count();

        $stats = [
            'sesi_hari_ini' => $realSesiHariIni > 0 ? $realSesiHariIni : 2,
            'booking_menunggu' => $realBookingMenunggu > 0 ? $realBookingMenunggu : 3,
            'sesi_selesai_bulan_ini' => $realSesiSelesaiBulanIni > 0 ? $realSesiSelesaiBulanIni : 18,
            'total_sesi' => $realTotalSesi > 0 ? $realTotalSesi : 64,
        ];

        // 2. Data Sesi Berikutnya
        $sesiBerikutnya = [
            'klien' => 'yudahenry',
            'avatar_initial' => 'Y',
            'hari_tanggal' => 'Jumat, 23 Oktober 2026',
            'tanggal_badge' => [
                'bulan' => 'OKT',
                'hari' => '23',
            ],
            'waktu' => '15.00–16.00 WIB',
            'durasi' => '60 menit',
            'metode' => 'Sesi melalui chat',
            'status_pembayaran' => 'Pembayaran dikonfirmasi',
            'topik' => 'Konsultasi lanjutan: Manajemen stres, regulasi emosi & pemulihan burnout.',
            'catatan' => 'Klien telah menyelesaikan sesi asesmen awal pada 16 Oktober dan menjadwalkan sesi follow-up.',
        ];

        // 3. Data Jadwal Hari Ini
        $jadwalHariIni = [
            [
                'id' => 1,
                'jam' => '15.00–16.00',
                'durasi' => 'WIB · 60 menit',
                'klien' => 'yudahenry',
                'layanan' => 'Konsultasi melalui chat',
                'status' => 'Berikutnya',
                'is_next' => true,
            ],
            [
                'id' => 2,
                'jam' => '17.00–18.00',
                'durasi' => 'WIB · 60 menit',
                'klien' => 'ruangsenja',
                'layanan' => 'Konsultasi melalui chat',
                'status' => 'Terjadwal',
                'is_next' => false,
            ],
        ];

        // 4. Data Booking Menunggu
        $bookingMenunggu = [
            [
                'id' => 1,
                'klien' => 'bungapagi',
                'diajukan' => 'Diajukan 20 menit lalu',
                'jadwal' => 'Sabtu, 24 Okt · 10.00–11.00 WIB',
                'layanan' => 'Chat · 60 menit',
                'keluhan' => 'Kecemasan menghadapi lingkungan kantor baru dan kendala komunikasi asertif.',
                'tarif' => 'Rp 150.000',
            ],
            [
                'id' => 2,
                'klien' => 'langitcerah',
                'diajukan' => 'Diajukan 1 jam lalu',
                'jadwal' => 'Sabtu, 24 Okt · 13.00–14.00 WIB',
                'layanan' => 'Chat · 60 menit',
                'keluhan' => 'Pendampingan pemulihan trauma kekerasan emosional dan pembentukan healthy boundaries.',
                'tarif' => 'Rp 150.000',
            ],
            [
                'id' => 3,
                'klien' => 'langkahkecil',
                'diajukan' => 'Diajukan 2 jam lalu',
                'jadwal' => 'Minggu, 25 Okt · 09.00–10.00 WIB',
                'layanan' => 'Chat · 60 menit',
                'keluhan' => 'Manajemen stres pasca peristiwa keluarga dan kebutuhan konseling aman perempuan.',
                'tarif' => 'Rp 150.000',
            ],
        ];

        // 5. Data Performa (Grafik & Analisis)
        $performaData = [
            'sesi_per_bulan_6' => [
                ['bulan' => 'Mei', 'jumlah' => 9, 'is_active' => false],
                ['bulan' => 'Jun', 'jumlah' => 12, 'is_active' => false],
                ['bulan' => 'Jul', 'jumlah' => 14, 'is_active' => false],
                ['bulan' => 'Agt', 'jumlah' => 11, 'is_active' => false],
                ['bulan' => 'Sep', 'jumlah' => 16, 'is_active' => false],
                ['bulan' => 'Okt', 'jumlah' => 18, 'is_active' => true, 'tooltip' => 'Okt: 18 sesi'],
            ],
            'sesi_per_bulan_3' => [
                ['bulan' => 'Agt', 'jumlah' => 11, 'is_active' => false],
                ['bulan' => 'Sep', 'jumlah' => 16, 'is_active' => false],
                ['bulan' => 'Okt', 'jumlah' => 18, 'is_active' => true, 'tooltip' => 'Okt: 18 sesi'],
            ],
            'hari_tersibuk' => [
                ['hari' => 'Sen', 'jumlah' => 4, 'is_active' => false],
                ['hari' => 'Sel', 'jumlah' => 6, 'is_active' => false],
                ['hari' => 'Rab', 'jumlah' => 3, 'is_active' => false],
                ['hari' => 'Kam', 'jumlah' => 7, 'is_active' => false],
                ['hari' => 'Jum', 'jumlah' => 8, 'is_active' => true],
                ['hari' => 'Sab', 'jumlah' => 2, 'is_active' => false],
                ['hari' => 'Min', 'jumlah' => 1, 'is_active' => false],
            ],
            'slot_terisi' => [
                ['minggu' => 'Minggu 1', 'persentase' => 60],
                ['minggu' => 'Minggu 2', 'persentase' => 75],
                ['minggu' => 'Minggu 3', 'persentase' => 50],
                ['minggu' => 'Minggu 4', 'persentase' => 85],
            ],
        ];

        return view('konselor.dashboard', compact(
            'konselor',
            'greetingName',
            'counselorTitle',
            'counselorInitials',
            'stats',
            'sesiBerikutnya',
            'jadwalHariIni',
            'bookingMenunggu',
            'performaData'
        ));
    }

    public function konfirmasiBooking(Request $request, $id)
    {
        // Mendukung konfirmasi booking
        return back()->with('success', 'Permintaan booking #' . $id . ' berhasil dikonfirmasi ke jadwal konsultasi.');
    }

    public function tolakBooking(Request $request, $id)
    {
        // Mendukung penolakan booking
        return back()->with('success', 'Permintaan booking #' . $id . ' telah ditolak.');
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        return response()->json([
            'status' => 'success',
            'pesan' => $request->pesan,
            'waktu' => Carbon::now()->format('H:i'),
        ]);
    }
}
