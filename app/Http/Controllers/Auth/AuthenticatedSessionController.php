<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:pengguna,konselor,admin'], // Validasi pilihan role dari form login
        ]);

        // Ambil data role yang dipilih user dari form
        $selectedRole = $request->input('role');
        
        // Pisahkan kredensial login (email & password) untuk proses Auth::attempt
        $authCredentials = $request->only('email', 'password');

        if (! Auth::attempt($authCredentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Validasi tambahan: Pastikan role akun di database sesuai dengan role yang dipilih saat login
        if ($user->role !== $selectedRole) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Peran (role) akun yang Anda pilih tidak sesuai dengan data pengguna.',
            ])->onlyInput('email');
        }

        // Jika login sebagai admin, otorisasi juga guard 'admin' jika diperlukan
        if ($user->role === 'admin') {
            // Jika Anda menggunakan guard admin terpisah, bisa di-attempt manual atau langsung dialihkan
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'konselor') {
            return redirect()->intended(route('konselor.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout(); // Logout guard admin juga untuk keamanan

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}