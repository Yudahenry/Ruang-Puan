<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konselor;
use App\Models\JadwalKonsultasi;
use App\Models\Pemesanan;
use App\Models\Konsultasi;
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
                    'status_verifikasi' => 'menunggu',
                ]
            );
        }

        // Hitung kelengkapan profil & kredensial konselor
        $kelengkapan = $konselor->kelengkapanProfil();
        $isProfilLengkap = $konselor->isProfilLengkap();

        // Tentukan nama sapaan & gelar secara dinamis dari user login
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

        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // ==========================================
        // 1. DATA STATISTIK KARTU (100% DARI DATABASE)
        // ==========================================
        $sesiHariIniCount = Pemesanan::whereHas('jadwal', function ($q) use ($konselor, $today) {
                $q->where('konselor_id', $konselor->id)->whereDate('tanggal', $today);
            })
            ->whereIn('pemesanans.status', ['lunas', 'terkonfirmasi', 'selesai'])
            ->count();

        $bookingMenungguCount = Pemesanan::whereHas('jadwal', function ($q) use ($konselor) {
                $q->where('konselor_id', $konselor->id);
            })
            ->whereIn('pemesanans.status', ['pending', 'menunggu_pembayaran'])
            ->count();

        $sesiSelesaiBulanIni = Pemesanan::whereHas('jadwal', function ($q) use ($konselor) {
                $q->where('konselor_id', $konselor->id);
            })
            ->whereMonth('pemesanans.created_at', $currentMonth)
            ->whereYear('pemesanans.created_at', $currentYear)
            ->where('pemesanans.status', 'selesai')
            ->count();

        $totalSesi = Pemesanan::whereHas('jadwal', function ($q) use ($konselor) {
                $q->where('konselor_id', $konselor->id);
            })
            ->whereIn('pemesanans.status', ['selesai', 'terkonfirmasi', 'lunas'])
            ->count();

        $stats = [
            'sesi_hari_ini' => $sesiHariIniCount,
            'booking_menunggu' => $bookingMenungguCount,
            'sesi_selesai_bulan_ini' => $sesiSelesaiBulanIni,
            'total_sesi' => $totalSesi,
        ];

        // ==========================================
        // 2. DATA SESI BERIKUTNYA (NEXT SESSION)
        // ==========================================
        $nextSesi = Pemesanan::with(['user', 'jadwal', 'konsultasi'])
            ->whereHas('jadwal', function ($q) use ($konselor, $today) {
                $q->where('konselor_id', $konselor->id)->whereDate('tanggal', '>=', $today);
            })
            ->whereIn('pemesanans.status', ['lunas', 'terkonfirmasi'])
            ->join('jadwal_konsultasis', 'pemesanans.jadwal_id', '=', 'jadwal_konsultasis.id')
            ->orderBy('jadwal_konsultasis.tanggal', 'asc')
            ->orderBy('jadwal_konsultasis.jam_mulai', 'asc')
            ->select('pemesanans.*')
            ->first();

        // ==========================================
        // 3. DATA JADWAL HARI INI
        // ==========================================
        $jadwalHariIniList = Pemesanan::with(['user', 'jadwal', 'konsultasi'])
            ->whereHas('jadwal', function ($q) use ($konselor, $today) {
                $q->where('konselor_id', $konselor->id)->whereDate('tanggal', $today);
            })
            ->whereIn('pemesanans.status', ['lunas', 'terkonfirmasi', 'selesai'])
            ->join('jadwal_konsultasis', 'pemesanans.jadwal_id', '=', 'jadwal_konsultasis.id')
            ->orderBy('jadwal_konsultasis.jam_mulai', 'asc')
            ->select('pemesanans.*')
            ->get();

        // ==========================================
        // 4. DATA BOOKING MENUNGGU (SIDEBAR)
        // ==========================================
        $bookingMenungguList = Pemesanan::with(['user', 'jadwal'])
            ->whereHas('jadwal', function ($q) use ($konselor) {
                $q->where('konselor_id', $konselor->id);
            })
            ->whereIn('pemesanans.status', ['pending', 'menunggu_pembayaran'])
            ->latest()
            ->take(3)
            ->get();

        $bookingMenunggu = $bookingMenungguList->map(function ($item) {
            $tgl = $item->jadwal ? Carbon::parse($item->jadwal->tanggal)->translatedFormat('l, d M') : '-';
            $jamMulai = $item->jadwal ? substr($item->jadwal->jam_mulai, 0, 5) : '';
            $jamSelesai = $item->jadwal ? substr($item->jadwal->jam_selesai, 0, 5) : '';
            
            return [
                'id' => $item->id,
                'klien' => $item->user->nama ?? $item->user->name ?? 'Klien',
                'diajukan' => $item->created_at ? $item->created_at->diffForHumans() : '-',
                'jadwal' => $tgl . ' · ' . $jamMulai . '–' . $jamSelesai . ' WIB',
                'layanan' => 'Chat · 60 menit',
                'keluhan' => 'Permintaan sesi konsultasi baru.',
                'tarif' => 'Rp ' . number_format($item->total_biaya ?? 150000, 0, ',', '.'),
            ];
        })->toArray();

        // ==========================================
        // 5. DATA PERFORMA DINAMIS (GRAFIK 6 BULAN & HARI)
        // ==========================================
        $performaData = [
            'sesi_per_bulan_6' => [],
            'hari_tersibuk' => [
                ['hari' => 'Sen', 'jumlah' => 0, 'is_active' => false],
                ['hari' => 'Sel', 'jumlah' => 0, 'is_active' => false],
                ['hari' => 'Rab', 'jumlah' => 0, 'is_active' => false],
                ['hari' => 'Kam', 'jumlah' => 0, 'is_active' => false],
                ['hari' => 'Jum', 'jumlah' => 0, 'is_active' => false],
                ['hari' => 'Sab', 'jumlah' => 0, 'is_active' => false],
                ['hari' => 'Min', 'jumlah' => 0, 'is_active' => false],
            ],
            'slot_terisi' => [
                ['minggu' => 'Minggu 1', 'persentase' => 0],
                ['minggu' => 'Minggu 2', 'persentase' => 0],
                ['minggu' => 'Minggu 3', 'persentase' => 0],
                ['minggu' => 'Minggu 4', 'persentase' => 0],
            ],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $mCount = Pemesanan::whereHas('jadwal', function ($q) use ($konselor) {
                    $q->where('konselor_id', $konselor->id);
                })
                ->whereMonth('pemesanans.created_at', $monthDate->month)
                ->whereYear('pemesanans.created_at', $monthDate->year)
                ->whereIn('pemesanans.status', ['lunas', 'terkonfirmasi', 'selesai'])
                ->count();

            $performaData['sesi_per_bulan_6'][] = [
                'bulan' => $monthDate->translatedFormat('M'),
                'jumlah' => $mCount,
                'is_active' => ($i === 0),
                'tooltip' => $monthDate->translatedFormat('M') . ': ' . $mCount . ' sesi'
            ];
        }

        // Hitung statistik hari tersibuk bulan ini dari database
        $pemesananBulanIni = Pemesanan::with('jadwal')
            ->whereHas('jadwal', function ($q) use ($konselor) {
                $q->where('konselor_id', $konselor->id);
            })
            ->whereMonth('pemesanans.created_at', $currentMonth)
            ->whereYear('pemesanans.created_at', $currentYear)
            ->whereIn('pemesanans.status', ['lunas', 'terkonfirmasi', 'selesai'])
            ->get();

        $mappingHari = ['Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab', 'Sun' => 'Min'];
        $counterHari = ['Sen' => 0, 'Sel' => 0, 'Rab' => 0, 'Kam' => 0, 'Jum' => 0, 'Sab' => 0, 'Min' => 0];

        foreach ($pemesananBulanIni as $p) {
            if ($p->jadwal && $p->jadwal->tanggal) {
                $dayEnglish = Carbon::parse($p->jadwal->tanggal)->format('D');
                if (isset($mappingHari[$dayEnglish])) {
                    $counterHari[$mappingHari[$dayEnglish]]++;
                }
            }
        }

        $maxHariVal = max($counterHari) ?: 1;
        foreach ($performaData['hari_tersibuk'] as &$h) {
            $h['jumlah'] = $counterHari[$h['hari']];
            $h['is_active'] = ($h['jumlah'] === max($counterHari) && $h['jumlah'] > 0);
        }
        unset($h);

        return view('konselor.dashboard', compact(
            'konselor',
            'kelengkapan',
            'isProfilLengkap',
            'greetingName',
            'counselorTitle',
            'counselorInitials',
            'stats',
            'nextSesi',
            'jadwalHariIniList',
            'bookingMenunggu',
            'performaData'
        ));
    }

    public function bookingMasuk()
    {
        $user = Auth::user();
        $konselor = $user->konselor;

        if (!$konselor) {
            return redirect()->route('konselor.dashboard')->with('error', 'Profil konselor belum diatur.');
        }

        $pemesanans = Pemesanan::with(['user', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($konselor) {
                $query->where('konselor_id', $konselor->id);
            })
            ->latest()
            ->get();

        $totalBooking = $pemesanans->count();
        $lunas = $pemesanans->where('status_pembayaran', 'lunas')->count();
        $pending = $pemesanans->where('status_pembayaran', 'pending')->count();

        return view('konselor.booking-masuk', compact('pemesanans', 'totalBooking', 'lunas', 'pending'));
    }

    public function konfirmasiBooking(Request $request, $id)
    {
        return back()->with('success', 'Permintaan booking #' . $id . ' berhasil dikonfirmasi ke jadwal konsultasi.');
    }

    public function tolakBooking(Request $request, $id)
    {
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