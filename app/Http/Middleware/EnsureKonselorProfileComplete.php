<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKonselorProfileComplete
{
    /**
     * Memastikan konselor telah mengisi profil dan kredensial secara lengkap
     * sebelum diizinkan mengakses fitur operasional atau membuat jadwal konsultasi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Terapkan hanya pada user dengan role konselor
        if ($user && $user->role === 'konselor') {
            $konselor = $user->konselor;

            // Jika entri konselor belum ada atau profilnya belum lengkap
            if (!$konselor || !$konselor->isProfilLengkap()) {
                // Jangan blokir halaman pengisian/edit profil konselor
                if ($request->routeIs('konselor.profil.*')) {
                    return $next($request);
                }

                $kelengkapan = $konselor ? $konselor->kelengkapanProfil() : null;
                $missingLabels = $kelengkapan && !empty($kelengkapan['missing'])
                    ? implode(', ', array_slice($kelengkapan['missing'], 0, 3)) . (count($kelengkapan['missing']) > 3 ? ', dan lainnya' : '')
                    : 'data profil dan dokumen kredensial';

                return redirect()->route('konselor.profil.edit')
                    ->with('warning', 'Profil dan kredensial Anda belum lengkap (' . $missingLabels . '). Harap lengkapi seluruh data identitas, spesialisasi, tarif, dan dokumen legalitas wajib sebelum dapat membuat jadwal konsultasi atau mengakses fitur operasional.');
            }
        }

        return $next($request);
    }
}
