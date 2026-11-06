<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalKonsultasi;

class JadwalKonsultasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->konselor) {
            abort(403, 'Akses ditolak. Anda belum terdaftar sebagai konselor.');
        }

        $konselor = $user->konselor;

        // Ambil daftar jadwal milik konselor yang sedang login
        $jadwals = JadwalKonsultasi::where('konselor_id', $konselor->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Kirim variabel $konselor dan $jadwals ke view konselor.jadwal
        return view('konselor.jadwal', compact('konselor', 'jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $user = auth()->user();

        JadwalKonsultasi::create([
            'konselor_id' => $user->konselor->id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'tersedia',
        ]);

        return redirect()->route('konselor.jadwal')->with('success', 'Jadwal praktik berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKonsultasi::findOrFail($id);
        
        if ($jadwal->konselor_id === auth()->user()->konselor->id) {
            $jadwal->delete();
            return back()->with('success', 'Jadwal berhasil dihapus.');
        }

        abort(403);
    }
}