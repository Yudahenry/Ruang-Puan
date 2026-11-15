<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatSesiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Ambil seluruh data Konsultasi milik konselor yang sedang login
        $allKonsultasis = Konsultasi::whereHas('pemesanan.jadwalKonsultasi.konselor', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with([
                'pemesanan.user',
                'pemesanan.jadwalKonsultasi',
                'pemesanan.pembayaran',
            ])
            ->withCount('pesans')
            ->get();

        // 2. Hitung 4 kartu ringkasan
        $ringkasan = [
            'total'       => $allKonsultasis->count(),
            'akan_datang' => $allKonsultasis->filter(fn ($k) => $k->status_efektif === 'terjadwal')->count(),
            'selesai'     => $allKonsultasis->filter(fn ($k) => $k->status_efektif === 'selesai')->count(),
            'total_pesan' => (int) $allKonsultasis->sum('pesans_count'),
        ];

        // 3. Urutkan terbaru dulu berdasarkan waktuMulai()
        $konsultasis = $allKonsultasis->sortByDesc(function ($k) {
            return $k->waktuMulai()?->timestamp ?? 0;
        });

        // 4. Filter status memakai accessor status_efektif (?status=)
        $status = $request->query('status');
        if ($status && in_array($status, ['terjadwal', 'berlangsung', 'selesai', 'batal'])) {
            $konsultasis = $konsultasis->filter(fn ($k) => $k->status_efektif === $status);
        }

        // 5. Pencarian alias klien lewat query string ?q=
        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $konsultasis = $konsultasis->filter(function ($k) use ($q) {
                $clientUser = $k->pemesanan?->user;
                $alias = !empty($clientUser?->alias) ? $clientUser->alias : ('Klien #' . ($clientUser?->id ?? $k->id));
                return str_contains(strtolower($alias), strtolower($q));
            });
        }

        return view('konselor.riwayat.index', compact('konsultasis', 'ringkasan', 'status', 'q'));
    }
}
