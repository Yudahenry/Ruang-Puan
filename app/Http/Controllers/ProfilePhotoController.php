<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'foto_profil' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'foto_profil.required' => 'Pilih foto terlebih dahulu.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format foto harus JPG atau PNG.',
            'foto_profil.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $user = $request->user();

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->foto_profil = $request->file('foto_profil')->store('foto_profil', 'public');
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->foto_profil = null;
        $user->save();

        return back()->with('success', 'Foto profil dihapus.');
    }
}
