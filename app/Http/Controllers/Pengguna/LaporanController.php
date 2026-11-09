<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanRequest;
use App\Models\Laporan;
use App\Models\BuktiLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = $user->laporans()->latest();

        $status = $request->query('status');
        if ($status && in_array($status, Laporan::STATUS_LIST, true)) {
            $query->where('status', $status);
        }

        $q = strtoupper(trim((string) $request->query('q', '')));
        if ($q !== '') {
            $query->where('kode_pelacakan', 'like', '%' . $q . '%');
        }

        $laporans = $query->paginate(10)->withQueryString();

        $ringkasan = [
            'total'   => $user->laporans()->count(),
            'aktif'   => $user->laporans()->whereIn('status', ['diterima', 'diverifikasi', 'diproses', 'diteruskan_ke_lembaga'])->count(),
            'selesai' => $user->laporans()->whereIn('status', ['selesai', 'ditutup'])->count(),
        ];

        return view('pelaporan.riwayat', compact('laporans', 'ringkasan', 'status', 'q'));
    }

    public function create()
    {
        return view('pelaporan.buat');
    }

    public function store(StoreLaporanRequest $request)
    {
        $validated = $request->validated();

        $waktuKejadian = null;
        if (!empty($validated['tanggal_kejadian'])) {
            $waktuStr = !empty($validated['waktu_kejadian']) ? trim($validated['waktu_kejadian']) : null;
            if ($waktuStr) {
                try {
                    $waktuKejadian = \Carbon\Carbon::parse($validated['tanggal_kejadian'] . ' ' . $waktuStr);
                } catch (\Exception $e) {
                    try {
                        $waktuKejadian = \Carbon\Carbon::parse($validated['tanggal_kejadian']);
                    } catch (\Exception $e2) {
                        $waktuKejadian = null;
                    }
                }
            } else {
                try {
                    $waktuKejadian = \Carbon\Carbon::parse($validated['tanggal_kejadian']);
                } catch (\Exception $e) {
                    $waktuKejadian = null;
                }
            }
        }

        $kodePelacakan = 'RP-' . strtoupper(Str::random(8));

        $laporan = Laporan::create([
            'user_id' => auth()->id(),
            'kode_pelacakan' => $kodePelacakan,
            'jenis_kasus' => $validated['jenis_kasus'],
            'kronologi' => $validated['kronologi'],
            'waktu_kejadian' => $waktuKejadian,
            'lokasi_kejadian' => $validated['lokasi_kejadian'],
            'anonim' => $request->boolean('anonim', true),
            'status' => 'diterima',
        ]);

        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                // Disk 'local' = private (storage/app), tidak bisa dibuka lewat URL langsung
                $path = $file->store('bukti_laporan', 'local');

                BuktiLaporan::create([
                    'laporan_id' => $laporan->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'tipe_file' => $file->getMimeType(),
                    'ukuran_file' => $file->getSize(),
                    'lokasi_file' => $path,
                ]);
            }
        }

        return redirect()->route('pelaporan.lacak', $kodePelacakan)
                         ->with('success', 'Laporan berhasil dibuat dengan kode pelacakan ' . $kodePelacakan . '. Simpan kode ini untuk memantau status laporan Anda.');
    }

    // Halaman Cek Status: pelapor memasukkan kode miliknya sendiri
    public function cek(Request $request)
    {
        $kode = strtoupper(trim((string) $request->query('kode', '')));

        if ($kode === '') {
            return view('pelaporan.cek', ['kode' => '', 'tidakDitemukan' => false]);
        }

        $laporan = auth()->user()->laporans()->where('kode_pelacakan', $kode)->first();

        if ($laporan) {
            return redirect()->route('pelaporan.lacak', $laporan->kode_pelacakan);
        }

        return view('pelaporan.cek', ['kode' => $kode, 'tidakDitemukan' => true]);
    }

    public function lacak($kode)
    {
        $laporan = Laporan::with([
            'buktiLaporans',
            'tanggapanLaporans' => fn ($q) => $q->orderBy('id'),
        ])->where('kode_pelacakan', $kode)->firstOrFail();

        // Hanya pemilik laporan yang boleh melihat
        abort_unless($laporan->user_id === auth()->id(), 403, 'Anda tidak memiliki akses ke laporan ini.');

        return view('pelaporan.lacak', compact('laporan'));
    }

    // Unduh bukti: hanya pemilik laporan
    public function unduhBukti($id)
    {
        $laporan = auth()->user()->laporans()
            ->whereHas('buktiLaporans', fn ($q) => $q->where('id', $id))
            ->firstOrFail();

        $bukti = $laporan->buktiLaporans()->findOrFail($id);

        // File lama mungkin masih di disk 'public', file baru di 'local'
        $disk = Storage::disk('local')->exists($bukti->lokasi_file) ? 'local' : 'public';

        abort_unless(Storage::disk($disk)->exists($bukti->lokasi_file), 404, 'File bukti tidak ditemukan.');

        return Storage::disk($disk)->download($bukti->lokasi_file, $bukti->nama_file);
    }
}
