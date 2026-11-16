<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use App\Models\JadwalKonsultasi;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $collection = Konselor::where('status_verifikasi', 'disetujui')
            ->whereHas('user', fn ($q) => $q->where('status', 'aktif'))
            ->with(['user', 'jadwalKonsultasis' => function ($query) {
                $query->where('status', 'tersedia')
                      ->whereDate('tanggal', '>=', now()->toDateString())
                      ->orderBy('tanggal', 'asc')
                      ->orderBy('jam_mulai', 'asc');
            }])
            ->get();

        // 1. Filter Pencarian (Nama atau Keahlian)
        if ($request->filled('search')) {
            $search = mb_strtolower($request->search);
            $collection = $collection->filter(function ($k) use ($search) {
                $nama = mb_strtolower($k->user->nama ?? $k->user->name ?? $k->nama ?? '');
                $keahlian = mb_strtolower(is_array($k->spesialisasi) ? implode(' ', $k->spesialisasi) : ($k->spesialisasi ?? $k->bidang_keahlian ?? ''));
                return str_contains($nama, $search) || str_contains($keahlian, $search);
            });
        }

        // 2. Filter Bidang Keahlian
        if ($request->filled('keahlian')) {
            $keahlian = mb_strtolower($request->keahlian);
            $collection = $collection->filter(function ($k) use ($keahlian) {
                $raw = mb_strtolower(is_array($k->spesialisasi) ? implode(' ', $k->spesialisasi) : ($k->spesialisasi ?? $k->bidang_keahlian ?? ''));
                return str_contains($raw, $keahlian);
            });
        }

        // 3. Filter Rentang Tarif
        if ($request->filled('tarif')) {
            $collection = $collection->filter(function ($k) use ($request) {
                $tarif = (int) ($k->tarif ?? $k->biaya_konsultasi ?? $k->harga ?? 150000);
                return match ($request->tarif) {
                    'under_150' => $tarif < 150000,
                    '150_200'   => $tarif >= 150000 && $tarif <= 200000,
                    'above_200' => $tarif > 200000,
                    default     => true,
                };
            });
        }

        // 4. Filter Ketersediaan Jadwal
        if ($request->filled('ketersediaan')) {
            $collection = $collection->filter(function ($k) use ($request) {
                if ($request->ketersediaan === 'tersedia') {
                    return $k->jadwalKonsultasis->isNotEmpty();
                }
                if ($request->ketersediaan === 'hari_ini') {
                    return $k->jadwalKonsultasis->contains(fn ($j) => $j->tanggal == now()->toDateString());
                }
                return true;
            });
        }

        // 5. Pengurutan (Sorting)
        $sort = $request->get('sort', 'jadwal_terdekat');
        if ($sort === 'tarif_terendah') {
            $collection = $collection->sortBy(fn ($k) => (int) ($k->tarif ?? $k->biaya_konsultasi ?? $k->harga ?? 150000));
        } elseif ($sort === 'tarif_tertinggi') {
            $collection = $collection->sortByDesc(fn ($k) => (int) ($k->tarif ?? $k->biaya_konsultasi ?? $k->harga ?? 150000));
        } else {
            // Urutkan berdasarkan jadwal terdekat yang tersedia
            $collection = $collection->sortBy(function ($k) {
                $first = $k->jadwalKonsultasis->first();
                return $first ? ($first->tanggal . ' ' . $first->jam_mulai) : '9999-12-31 23:59:59';
            });
        }

        // Paginasi 6 konselor per halaman (mempertahankan nama variabel $konsolors)
        $perPage = 6;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $konsolors = new LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage)->values(),
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

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

        $konselor->load(['user', 'jadwalKonsultasis' => function ($query) {
            $query->where('status', 'tersedia')
                  ->whereDate('tanggal', '>=', now()->toDateString())
                  ->orderBy('tanggal', 'asc')
                  ->orderBy('jam_mulai', 'asc');
        }]);

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

        // Mengambil tarif asli dari konselor (mendukung berbagai nama kolom database)
        $tarifKonselor = $jadwal->konselor->tarif ?? $jadwal->konselor->harga ?? 150000;

        $pemesanan = Pemesanan::create([
            'user_id' => Auth::id(),
            'jadwal_id' => $jadwal->id,
            'status' => 'menunggu_pembayaran',
            'total_biaya' => $tarifKonselor, // Menyimpan tarif dinamis secara akurat ke database
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
            'status' => 'terkonfirmasi',
            'status_pembayaran' => 'lunas',
            'metode_pembayaran' => $detailMetode,
        ]);

        \App\Models\Konsultasi::firstOrCreate(
            ['pemesanan_id' => $pemesanan->id],
            [
                'tanggal_konsultasi' => $pemesanan->jadwalKonsultasi?->tanggal ?? $pemesanan->jadwal?->tanggal,
                'jam_konsultasi'     => $pemesanan->jadwalKonsultasi?->jam_mulai ?? $pemesanan->jadwal?->jam_mulai,
                'status'             => 'terjadwal',
            ]
        );

        return redirect()->route('pengguna.dashboard')
                         ->with('success', 'Pembayaran berhasil dikonfirmasi! Jadwal konsultasi Anda telah aktif.');
    }
}