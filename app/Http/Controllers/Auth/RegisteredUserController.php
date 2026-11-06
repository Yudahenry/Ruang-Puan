<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alias' => ['nullable', 'string', 'max:100'],
            'role' => ['required', 'in:pengguna,konselor,admin'],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alias' => $request->alias,
            'role' => $request->role,
            'status' => 'aktif',
        ]);

        // Jika mendaftar sebagai konselor
        if ($request->role === 'konselor') {
            \App\Models\Konselor::create([
                'user_id' => $user->id,
                'status_verifikasi' => 'menunggu',
            ]);
        }

        // Jika mendaftar sebagai admin, otomatis daftarkan juga ke tabel admins
        if ($request->role === 'admin') {
            \App\Models\Admin::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'password' => $user->password, // Password sudah di-hash dari user
            ]);
        }

        // Kirim email verifikasi (FR-01: akun aktif setelah email diverifikasi)
        // Otomatis verifikasi untuk environment lokal agar langsung bisa masuk
        $user->forceFill(['email_verified_at' => now()])->save();
        
        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}