@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Sambutan -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
        <p class="text-sm text-gray-600">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}. Pantau statistik dan operasional layanan Ruang Puan di sini.</p>
    </div>

    <!-- Kotak Statistik (Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1: Total Laporan -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Laporan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Laporan::count() }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
        </div>

        <!-- Card 2: Pengguna Terdaftar -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Pengguna</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\User::where('role', 'pengguna')->count() }}</h3>
            </div>
            <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>

        <!-- Card 3: Konselor Aktif -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Konselor</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\User::where('role', 'konselor')->count() }}</h3>
            </div>
            <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <!-- Card 4: Sesi Konsultasi & Transaksi (Opsional aman jika modelnya ada) -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Konsultasi / Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">
                    {{ class_exists('\App\Models\Konsultasi') ? \App\Models\Konsultasi::count() : '0' }}
                </h3>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Pintasan / Menu Cepat -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <h3 class="text-md font-semibold text-gray-800 mb-4">Akses Cepat Pengelolaan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.laporan.index') }}" class="p-4 border rounded-lg hover:bg-gray-50 transition flex items-center space-x-3">
                <span class="p-2 bg-indigo-100 text-indigo-700 rounded-md font-bold">📋</span>
                <div>
                    <h4 class="text-sm font-semibold text-gray-800">Kelola Laporan</h4>
                    <p class="text-xs text-gray-500">Periksa dan ubah status laporan masuk</p>
                </div>
            </a>
            <a href="{{ route('admin.konselor.index') }}" class="p-4 border rounded-lg hover:bg-gray-50 transition flex items-center space-x-3">
                <span class="p-2 bg-purple-100 text-purple-700 rounded-md font-bold">👩‍⚕️</span>
                <div>
                    <h4 class="text-sm font-semibold text-gray-800">Verifikasi Konselor</h4>
                    <p class="text-xs text-gray-500">Kelola persetujuan akun konselor</p>
                </div>
            </a>
            <a href="{{ route('admin.edukasi.index') }}" class="p-4 border rounded-lg hover:bg-gray-50 transition flex items-center space-x-3">
                <span class="p-2 bg-blue-100 text-blue-700 rounded-md font-bold">📚</span>
                <div>
                    <h4 class="text-sm font-semibold text-gray-800">Kelola Edukasi</h4>
                    <p class="text-xs text-gray-500">Tambah materi atau artikel edukasi</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
