<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kasus' => ['required', 'in:kekerasan_fisik,kekerasan_psikis,kekerasan_seksual,kdrt,kekerasan_online,lainnya'],
            'kronologi' => ['required', 'string'],
            'waktu_kejadian' => ['nullable', 'date'],
            'lokasi_kejadian' => ['nullable', 'string', 'max:255'],
            'anonim' => ['boolean'],
            'bukti.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,mp4,mov', 'max:10240'],
        ]);

        $kodePelacakan = 'RP-' . strtoupper(Str::random(8));

        $laporan = Laporan::create([
            'user_id' => auth()->id(),
            'kode_pelacakan' => $kodePelacakan,
            'jenis_kasus' => $request->jenis_kasus,
            'kronologi' => $request->kronologi,
            'waktu_kejadian' => $request->waktu_kejadian,
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'anonim' => $request->boolean('anonim'),
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
                         ->with('success', 'Laporan berhasil dibuat. Simpan kode pelacakan Anda.');
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
