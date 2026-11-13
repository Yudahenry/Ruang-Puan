@extends('layouts.pengguna')

@section('pengguna-content')
<div class="bg-[#FCFAF8] min-h-screen text-[#3E293F] pb-10">
    <!-- 1. HERO SECTION -->
    <x-beranda.hero />

    <!-- 2. QUICK ACTION CARDS -->
    <x-beranda.quick-actions />

    <!-- 3. DISCLAIMER KECIL (CONTOH DATA) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <p class="text-xs text-[#746B77] italic">Contoh aktivitas untuk ilustrasi tampilan. Nama, nomor laporan, dan jadwal bukan data pengguna sebenarnya.</p>
    </div>

    <!-- 4. "LANGKAHMU SEJAUH INI" -->
    <x-beranda.aktivitas :laporanTerbaru="$laporanTerbaru" :konsultasiMendatang="$konsultasiMendatang" />

    <!-- 5. "SEDIKIT BELAJAR, LEBIH BERDAYA" -->
    <x-beranda.edukasi-grid :materiEdukasis="$materiEdukasis" />

    <!-- 6. BANNER BAWAH 2 KOLOM -->
    <x-beranda.bantuan-banner :wilayahList="$wilayahList" :layananList="$layananList" />

    <!-- 7. DISCLAIMER KECIL -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-[#EEE7F2]/70 border border-[#DCD5DD] rounded-2xl p-5 flex items-start space-x-3 text-xs text-[#643B62]">
            <span class="text-base flex-shrink-0">ℹ️</span>
            <p class="leading-relaxed font-light">
                <strong class="font-semibold text-[#3E293F]">Catatan Penting:</strong> Konsultasi di Ruang Puan adalah pendampingan awal melalui chat, bukan pengganti layanan medis profesional. Jika kamu berada dalam bahaya langsung, hubungi layanan darurat atau lembaga bantuan setempat.
            </p>
        </div>
    </div>
</div>
@endsection