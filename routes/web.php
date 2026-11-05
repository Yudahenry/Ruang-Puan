<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Pengguna\LaporanController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\DirektoriController;
use App\Http\Controllers\Admin\AdminEdukasiController;
use App\Http\Controllers\Admin\AdminDirektoriController;
use App\Http\Controllers\Admin\AdminKonselorController;
use App\Http\Controllers\Admin\VerifikasiKonselorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// 1. AUTHENTICATION KHUSUS ADMIN
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin (Belum Login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Protected Admin (Sudah Login via Guard Admin)
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

// ==========================================
// 2. AUTHENTICATION & EMAIL VERIFICATION ROUTES (PENGGUNA/KONSELOR)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::match(['get', 'post'], 'logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profil/password', [\App\Http\Controllers\ProfilePasswordController::class, 'update'])->name('profile.password');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// ==========================================
// 3. PUBLIC ROUTES
// ==========================================
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/direktori', [DirektoriController::class, 'index'])->name('direktori.index');

// ==========================================
// 4. PENGGUNA ROUTES
// ==========================================
Route::middleware(['auth', 'role:pengguna'])->prefix('pelaporan')->name('pelaporan.')->group(function () {
    Route::get('/buat', [LaporanController::class, 'create'])->name('buat');
    Route::post('/', [LaporanController::class, 'store'])->name('store');
    Route::get('/riwayat', [LaporanController::class, 'index'])->name('riwayat');
});

Route::middleware(['auth'])->get('/pelaporan/lacak/{kode}', [LaporanController::class, 'lacak'])->name('pelaporan.lacak');

// ==========================================
// 5. ADMIN ROUTES (MANAJEMEN KONTEN & LAPORAN)
// ==========================================
Route::middleware(['auth:web,admin', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminLaporanController::class, 'show'])->name('show');
        Route::patch('/{id}', [AdminLaporanController::class, 'updateStatus'])->name('update');
    });

    // Admin Edukasi & Direktori
    Route::get('/edukasi', [AdminEdukasiController::class, 'index'])->name('edukasi.index');
    Route::get('/edukasi/create', [AdminEdukasiController::class, 'createMateri'])->name('edukasi.create');
    Route::post('/edukasi', [AdminEdukasiController::class, 'storeMateri'])->name('edukasi.store');
    Route::post('/edukasi/kategori', [AdminEdukasiController::class, 'storeKategori'])->name('edukasi.kategori.store');
    Route::delete('/edukasi/{id}', [AdminEdukasiController::class, 'destroyMateri'])->name('edukasi.destroy');

    Route::get('/direktori', [AdminDirektoriController::class, 'index'])->name('direktori.index');
    Route::get('/direktori/create', [AdminDirektoriController::class, 'create'])->name('direktori.create');
    Route::post('/direktori', [AdminDirektoriController::class, 'store'])->name('direktori.store');
    Route::get('/direktori/{id}/edit', [AdminDirektoriController::class, 'edit'])->name('direktori.edit');
    Route::put('/direktori/{id}', [AdminDirektoriController::class, 'update'])->name('direktori.update');
    Route::patch('/direktori/{id}/toggle-status', [AdminDirektoriController::class, 'toggleStatus'])->name('direktori.toggle-status');
    Route::delete('/direktori/{id}', [AdminDirektoriController::class, 'destroy'])->name('direktori.destroy');

    // Admin Konselor & Verifikasi Konselor
    Route::get('/konselor', [AdminKonselorController::class, 'index'])->name('konselor.index');
    Route::post('/konselor/{id}/verifikasi', [AdminKonselorController::class, 'verifikasi'])->name('konselor.verifikasi');
    Route::post('/konselor/{id}/tolak', [AdminKonselorController::class, 'tolak'])->name('konselor.tolak');
    Route::get('/verifikasi-konselor', [AdminKonselorController::class, 'index'])->name('verifikasi.index');
});

// Redirect jika user mengetik /verifikasi-konselor langsung
Route::redirect('/verifikasi-konselor', '/admin/konselor');

// ==========================================
// 6. ROLE-BASED DASHBOARDS & REDIRECT
// ==========================================
Route::middleware(['auth', 'verified', 'role:pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Pengguna\BerandaController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:konselor'])->prefix('konselor')->name('konselor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('konselor.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:web,admin', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// General Dashboard Fallback (Otomatis arahkan berdasarkan Role)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($user->role === 'konselor') {
        return redirect()->route('konselor.dashboard');
    }

    return redirect()->route('pengguna.dashboard');
})->name('dashboard');

Route::middleware(['auth', 'verified'])->get('/beranda', function () {
    return redirect()->route('pengguna.dashboard');
})->name('beranda');