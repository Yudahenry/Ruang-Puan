<?php

namespace App\Http\Controllers;

use App\Models\Konselor;

class KonselorPublikController extends Controller
{
    public function show(Konselor $konselor)
    {
        // Hanya konselor yang sudah diverifikasi yang boleh dilihat publik
        abort_unless($konselor->status_verifikasi === 'disetujui', 404);

        $konselor->load('user');

        return view('konsultasi.profil-konselor', [
            'konselor' => $konselor,
            'user' => $konselor->user,
        ]);
    }
}
