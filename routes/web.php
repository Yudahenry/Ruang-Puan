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

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// AUTHENTICATION & EMAIL VERIFICATION ROUTES
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profil', [ProfileController::class, 'update'])->name('profile.update');


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
// PUBLIC ROUTES
// ==========================================
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/direktori', [DirektoriController::class, 'index'])->name('direktori.index');

// ==========================================
// PENGGUNA ROUTES
// ==========================================
Route::middleware(['auth', 'role:pengguna'])->prefix('pelaporan')->name('pelaporan.')->group(function () {
    Route::get('/buat', [LaporanController::class, 'create'])->name('buat');
    Route::post('/', [LaporanController::class, 'store'])->name('store');
    Route::get('/riwayat', [LaporanController::class, 'index'])->name('riwayat');
});

Route::middleware(['auth'])->get('/pelaporan/lacak/{kode}', [LaporanController::class, 'lacak'])->name('pelaporan.lacak');

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
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
    Route::delete('/direktori/{id}', [AdminDirektoriController::class, 'destroy'])->name('direktori.destroy');

    // Admin Konselor & Verifikasi Konselor (Digabung & Dirapikan)
    Route::get('/konselor', [AdminKonselorController::class, 'index'])->name('konselor.index');
    Route::post('/konselor/{id}/verifikasi', [AdminKonselorController::class, 'verifikasi'])->name('konselor.verifikasi');
    Route::post('/konselor/{id}/tolak', [AdminKonselorController::class, 'tolak'])->name('konselor.tolak');

    // Verifikasi Konselor Controller (Halaman yang baru kamu buat)
    Route::get('/verifikasi-konselor', [VerifikasiKonselorController::class, 'index'])->name('verifikasi.index');
    Route::patch('/verifikasi-konselor/{id}', [VerifikasiKonselorController::class, 'update'])->name('konselor.update');
});

// ==========================================
// ROLE-BASED DASHBOARDS (Verified)
// ==========================================
Route::middleware(['auth', 'verified', 'role:pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Pengguna\BerandaController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:konselor'])->prefix('konselor')->name('konselor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('konselor.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// General dashboard fallback for authenticated users
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'konselor') return redirect()->route('konselor.dashboard');

    return redirect()->route('pengguna.dashboard');
})->name('dashboard');

//VerifikasiKonselorController::class

// 1. Group Rute Admin (Verifikasi Konselor)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/verifikasi-konselor', [VerifikasiKonselorController::class, 'index'])->name('konselor.index');
    Route::patch('/verifikasi-konselor/{id}', [VerifikasiKonselorController::class, 'update'])->name('konselor.update');
});

// 2. Rute Dashboard Utama (Otomatis arahkan berdasarkan Role)
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
