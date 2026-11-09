<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatKonsultasiController extends Controller
{
    // Mengembalikan 'pengguna' / 'konselor', atau abort 403 kalau bukan peserta sesi
    private function peran(Konsultasi $konsultasi): string
    {
        $uid = Auth::id();
        $konsultasi->loadMissing('pemesanan.jadwalKonsultasi.konselor.user');

        if ($konsultasi->pemesanan->user_id === $uid) {
            return 'pengguna';
        }
        if ($konsultasi->pemesanan->jadwalKonsultasi->konselor->user_id === $uid) {
            return 'konselor';
        }
        abort(403, 'Anda tidak memiliki akses ke percakapan ini.');
    }

    private function namaUser($user, bool $pakaiAlias = false): string
    {
        if ($pakaiAlias && !empty($user->alias)) {
            return $user->alias;
        }
        return $user->nama ?? $user->name ?? 'Pengguna';
    }

    public function show(Konsultasi $konsultasi)
    {
        $peran = $this->peran($konsultasi);
        $pemesanan = $konsultasi->pemesanan;
        $konselorUser = $pemesanan->jadwalKonsultasi->konselor->user;

        // Konselor melihat alias pengguna demi privasi (FR-03)
        $namaLawan = $peran === 'pengguna'
            ? $this->namaUser($konselorUser)
            : $this->namaUser($pemesanan->user, true);

        return view('konsultasi.chat', [
            'konsultasi' => $konsultasi,
            'peran'      => $peran,
            'namaLawan'  => $namaLawan,
            'aktif'      => $konsultasi->sesiAktif(),
            'berakhir'   => $konsultasi->sesiBerakhir(),
        ]);
    }

    // Dipanggil JavaScript tiap 3 detik (polling)
    public function pesan(Request $request, Konsultasi $konsultasi)
    {
        $peran = $this->peran($konsultasi);
        $after = (int) $request->query('after', 0);

        $pesans = $konsultasi->pesans()
            ->with('pengirim')
            ->where('id', '>', $after)
            ->orderBy('id')
            ->get()
            ->map(function ($p) use ($peran) {
                $mine = $p->pengirim_id === Auth::id();
                $nama = $mine
                    ? 'Kamu'
                    : $this->namaUser($p->pengirim, $peran === 'konselor');

                return [
                    'id'    => $p->id,
                    'isi'   => $p->isi_pesan,
                    'mine'  => $mine,
                    'nama'  => $nama,
                    'waktu' => $p->waktu_kirim->format('H:i'),
                ];
            });

        return response()->json([
            'pesan'  => $pesans,
            'aktif'  => $konsultasi->sesiAktif(),
        ]);
    }

    public function kirim(Request $request, Konsultasi $konsultasi)
    {
        $this->peran($konsultasi);

        if (!$konsultasi->sesiAktif()) {
            return response()->json(['message' => 'Sesi konsultasi tidak sedang berlangsung.'], 403);
        }

        $data = $request->validate([
            'isi_pesan' => ['required', 'string', 'max:1000'],
        ]);

        Pesan::create([
            'konsultasi_id' => $konsultasi->id,
            'pengirim_id'   => Auth::id(),
            'isi_pesan'     => trim($data['isi_pesan']),
            'waktu_kirim'   => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
