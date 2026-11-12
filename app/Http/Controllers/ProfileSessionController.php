<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileSessionController extends Controller
{
    public function destroyOthers(Request $request)
    {
        $request->validate([
            'password_sesi' => ['required', 'current_password'],
        ], [
            'password_sesi.required' => 'Masukkan kata sandi untuk melanjutkan.',
            'password_sesi.current_password' => 'Kata sandi yang Anda masukkan salah.',
        ]);

        DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        return back()->with('success', 'Anda telah keluar dari semua perangkat lain.');
    }
}
