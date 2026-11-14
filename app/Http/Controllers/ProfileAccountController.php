<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileAccountController extends Controller
{
    public function deactivate(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Admin tidak boleh menonaktifkan dirinya sendiri (agar tidak terkunci)
        abort_if($user->role === 'admin', 403);

        $request->validate([
            'password_nonaktif' => ['required', 'current_password'],
        ], [
            'password_nonaktif.required' => 'Masukkan kata sandi untuk menonaktifkan akun.',
            'password_nonaktif.current_password' => 'Kata sandi yang kamu masukkan salah.',
        ]);

        $user->forceFill(['status' => 'nonaktif'])->save();
        LogAktivitas::catat('akun_dinonaktifkan_sendiri', 'Pengguna menonaktifkan akunnya sendiri', $user->id);
        DB::table('sessions')->where('user_id', $user->id)->delete();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Akun kamu sudah dinonaktifkan. Hubungi admin jika ingin mengaktifkannya kembali.');
    }
}
