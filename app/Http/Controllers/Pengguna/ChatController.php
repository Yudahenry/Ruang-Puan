<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private function ambilKonsultasi($id)
    {
        return Konsultasi::with([
            'pemesanan.jadwalKonsultasi.konselor.user',
            'pemesanan.user',
            'pesans.pengirim'
        ])
        ->whereHas('pemesanan', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'terkonfirmasi');
        })
        ->findOrFail($id);
    }

    public function show($id)
    {
        $konsultasi = $this->ambilKonsultasi($id);

        return view('pengguna.chat.show', compact('konsultasi'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:5000',
        ]);

        $konsultasi = $this->ambilKonsultasi($id);

        if (in_array($konsultasi->status, ['selesai', 'batal'])) {
            return back()->with('error', 'Konsultasi ini sudah berakhir.');
        }

        Pesan::create([
            'konsultasi_id' => $konsultasi->id,
            'pengirim_id' => Auth::id(),
            'isi_pesan' => $request->isi_pesan,
            'waktu_kirim' => now(),
        ]);

        return redirect()
            ->route('pengguna.chat.show', $konsultasi->id);
    }
}
