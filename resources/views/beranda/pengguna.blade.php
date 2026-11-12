@extends('layouts.pengguna')

@section('pengguna-content')
<div class="bg-[#FCFAF8] min-h-screen text-[#3E293F] pb-20">
    <!-- 1. NAVBAR -->
    <x-beranda.navbar />

    <!-- 2. HERO SECTION -->
    <x-beranda.hero />

    <!-- 3. QUICK ACTION CARDS -->
    <x-beranda.quick-actions />

    <!-- 4. DISCLAIMER KECIL (CONTOH DATA) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <p class="text-xs text-[#746B77] italic">Contoh aktivitas untuk ilustrasi tampilan. Nama, nomor laporan, dan jadwal bukan data pengguna sebenarnya.</p>
    </div>

    <!-- 5. "LANGKAHMU SEJAUH INI" -->
    <x-beranda.aktivitas :laporanTerbaru="$laporanTerbaru" :konsultasiMendatang="$konsultasiMendatang" />

    <!-- 6. "SEDIKIT BELAJAR, LEBIH BERDAYA" -->
    <x-beranda.edukasi-grid :materiEdukasis="$materiEdukasis" />

    <!-- 7. BANNER BAWAH 2 KOLOM -->
    <x-beranda.bantuan-banner :wilayahList="$wilayahList" :layananList="$layananList" />

    <!-- 8. DISCLAIMER KECIL -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-[#EEE7F2]/70 border border-[#DCD5DD] rounded-2xl p-5 flex items-start space-x-3 text-xs text-[#643B62]">
            <span class="text-base flex-shrink-0">ℹ️</span>
            <p class="leading-relaxed font-light">
                <strong class="font-semibold text-[#3E293F]">Catatan Penting:</strong> Konsultasi di Ruang Puan adalah pendampingan awal melalui chat, bukan pengganti layanan medis profesional. Jika kamu berada dalam bahaya langsung, hubungi layanan darurat atau lembaga bantuan setempat.
            </p>
        </div>
    </div>

    <!-- 9. FOOTER KHUSUS BERANDA / GLOBAL -->
    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-[#DCD5DD] flex flex-col md:flex-row items-center justify-between text-xs text-[#746B77] space-y-4 md:space-y-0 pb-8">
        <div class="flex items-center space-x-2">
            <div class="flex items-center space-x-2">
                <div class="w-7 h-7 rounded-xl bg-[#643B62] flex items-center justify-center shadow-inner">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="font-bold text-[#3E293F] font-serif text-sm">Ruang Puan</span>
            </div>
        </div>
        <div class="italic text-[#746B77]">
            "Ruang untuk didengar. Bekal untuk melangkah."
        </div>
        <div class="flex items-center space-x-6">
            <a href="#" class="hover:text-[#3E293F] transition">Kebijakan privasi</a>
            <span>&middot;</span>
            <a href="#" class="hover:text-[#3E293F] transition">Pusat bantuan</a>
        </div>
    </footer>
</div>
@endsection