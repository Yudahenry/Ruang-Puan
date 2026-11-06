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
        $laporans = auth()->user()->laporans()->latest()->paginate(10);
        return view('pelaporan.riwayat', compact('laporans'));
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
                $path = $file->store('bukti_laporan', 'public');
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

    public function lacak($kode)
    {
        $laporan = Laporan::with(['buktiLaporans', 'tanggapanLaporans'])->where('kode_pelacakan', $kode)->firstOrFail();
        
        if (auth()->user()->role === 'pengguna' && $laporan->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pelaporan.lacak', compact('laporan'));
    }
}
