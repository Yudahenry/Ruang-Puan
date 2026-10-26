<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email,'.$user->id],
            'alias' => ['nullable', 'string', 'max:100'],
            'no_str' => ['nullable', 'string', 'max:50'],
            'no_sipp' => ['nullable', 'string', 'max:50'],
            'bidang_keahlian' => ['nullable', 'string', 'max:150'],
            'tarif' => ['nullable', 'numeric', 'min:0'],
            'dokumen_verifikasi' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'alias' => $request->alias,
        ]);

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

        return back()->with('success', 'Profil dan dokumen berhasil diperbarui.');
    }
}
