<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

                   $sesi = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($s) use ($request) {
                $ua = $s->user_agent ?? '';
                $browser = str_contains($ua, 'Edg') ? 'Edge'
                    : (str_contains($ua, 'Chrome') ? 'Chrome'
                    : (str_contains($ua, 'Firefox') ? 'Firefox'
                    : (str_contains($ua, 'Safari') ? 'Safari' : 'Browser lain')));
                $os = str_contains($ua, 'Windows') ? 'Windows'
                    : (str_contains($ua, 'Android') ? 'Android'
                    : ((str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) ? 'iOS'
                    : (str_contains($ua, 'Mac') ? 'macOS'
                    : (str_contains($ua, 'Linux') ? 'Linux' : 'perangkat lain'))));

                return (object) [
                    'perangkat' => $browser . ' di ' . $os,
                    'ip' => $s->ip_address,
                    'terakhir' => \Carbon\Carbon::createFromTimestamp($s->last_activity)->locale('id')->diffForHumans(),
                    'saat_ini' => $s->id === $request->session()->getId(),
                ];
            });

        return view('profile.edit', ['user' => $user, 'sesi' => $sesi]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email,'.$user->id],
            'alias' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'kota' => ['nullable', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kontak_darurat_nama' => ['nullable', 'string', 'max:100'],
            'kontak_darurat_nomor' => ['nullable', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'mode_lapor_default' => ['nullable', 'in:anonim,identitas'],
            'notif_status_laporan' => ['nullable', 'boolean'],
            'notif_pengingat_konsultasi' => ['nullable', 'boolean'],
            'notif_pembayaran' => ['nullable', 'boolean'],
            'no_str' => ['nullable', 'string', 'max:50'],
            'no_sipp' => ['nullable', 'string', 'max:50'],
            'bidang_keahlian' => ['nullable', 'string', 'max:150'],
            'tarif' => ['nullable', 'numeric', 'min:0'],
            'dokumen_verifikasi' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ], [
            'no_hp.regex' => 'Nomor HP tidak valid (8-20 karakter, hanya angka, +, - dan spasi).',
            'kontak_darurat_nomor.regex' => 'Nomor kontak darurat tidak valid (8-20 karakter, hanya angka, +, - dan spasi).',
        ]);

        $emailBerubah = $request->email !== $user->email;

        // Data dasar (selalu dikirim dari tab Informasi Pribadi)
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'alias' => $request->alias,
        ];

        // Field opsional: hanya diubah kalau memang dikirim dari form
        foreach (['no_hp', 'kota', 'provinsi', 'kontak_darurat_nama', 'kontak_darurat_nomor'] as $field) {
            if ($request->exists($field)) {
                $data[$field] = $request->input($field);
            }
        }

        // Tab Privasi & Notifikasi (hanya ada untuk pengguna)
        if ($request->exists('mode_lapor_default')) {
            $data['mode_lapor_default'] = $request->mode_lapor_default;

            foreach (['notif_status_laporan', 'notif_pengingat_konsultasi', 'notif_pembayaran'] as $field) {
                $data[$field] = $request->boolean($field);
            }
        }

        $user->update($data);

        if ($user->role === 'konselor') {
            $konselorData = [
                'no_str' => $request->no_str,
                'no_sipp' => $request->no_sipp,
                'bidang_keahlian' => $request->bidang_keahlian,
                'tarif' => $request->tarif ?? 0,
            ];

            if ($request->hasFile('dokumen_verifikasi')) {
                $path = $request->file('dokumen_verifikasi')->store('dokumen_konselor', 'public');
                $konselorData['dokumen_verifikasi'] = $path;
                $konselorData['status_verifikasi'] = 'menunggu'; // Reset status if new document uploaded
            }

            $user->konselor()->updateOrCreate(
                ['user_id' => $user->id],
                $konselorData
            );
        }

        // Email diganti: wajib verifikasi ulang ke alamat baru
        if ($emailBerubah) {
            $user->forceFill(['email_verified_at' => null])->save();
            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.notice')
                ->with('success', 'Email diubah. Silakan verifikasi alamat email baru Anda.');
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
