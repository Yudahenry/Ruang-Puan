<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Pengguna\LaporanController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\DirektoriController;
use App\Http\Controllers\Admin\AdminEdukasiController;
use App\Http\Controllers\Admin\AdminDirektoriController;
use App\Http\Controllers\Admin\AdminKonselorController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

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
});

// Public / Guest accessible Edukasi & Direktori
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/direktori', [DirektoriController::class, 'index'])->name('direktori.index');

// Pelaporan Routes (Pengguna)
Route::middleware(['auth', 'role:pengguna'])->prefix('pelaporan')->name('pelaporan.')->group(function () {
    Route::get('/buat', [LaporanController::class, 'create'])->name('buat');
    Route::post('/', [LaporanController::class, 'store'])->name('store');
    Route::get('/riwayat', [LaporanController::class, 'index'])->name('riwayat');
});

// Lacak Laporan Route (Accessible by Owner or Admin)
Route::middleware(['auth'])->get('/pelaporan/lacak/{kode}', [LaporanController::class, 'lacak'])->name('pelaporan.lacak');

// Admin Laporan Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin/laporan')->name('admin.laporan.')->group(function () {
    Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
    Route::get('/{id}', [AdminLaporanController::class, 'show'])->name('show');
    Route::patch('/{id}', [AdminLaporanController::class, 'updateStatus'])->name('update');
});

// Admin Edukasi & Direktori Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/edukasi', [AdminEdukasiController::class, 'index'])->name('edukasi.index');
    Route::get('/edukasi/create', [AdminEdukasiController::class, 'createMateri'])->name('edukasi.create');
    Route::post('/edukasi', [AdminEdukasiController::class, 'storeMateri'])->name('edukasi.store');
    Route::post('/edukasi/kategori', [AdminEdukasiController::class, 'storeKategori'])->name('edukasi.kategori.store');
    Route::delete('/edukasi/{id}', [AdminEdukasiController::class, 'destroyMateri'])->name('edukasi.destroy');

    Route::get('/direktori', [AdminDirektoriController::class, 'index'])->name('direktori.index');
    Route::get('/direktori/create', [AdminDirektoriController::class, 'create'])->name('direktori.create');
    Route::post('/direktori', [AdminDirektoriController::class, 'store'])->name('direktori.store');
    Route::delete('/direktori/{id}', [AdminDirektoriController::class, 'destroy'])->name('direktori.destroy');

    Route::get('/konselor', [AdminKonselorController::class, 'index'])->name('konselor.index');
    Route::post('/konselor/{id}/verifikasi', [AdminKonselorController::class, 'verifikasi'])->name('konselor.verifikasi');
    Route::post('/konselor/{id}/tolak', [AdminKonselorController::class, 'tolak'])->name('konselor.tolak');
});

// Role-based protected dashboards
Route::middleware(['auth', 'role:pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pengguna.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:konselor'])->prefix('konselor')->name('konselor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('konselor.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// General dashboard fallback for authenticated users
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'konselor') return redirect()->route('konselor.dashboard');
    return view('pengguna.dashboard');
})->name('dashboard');
