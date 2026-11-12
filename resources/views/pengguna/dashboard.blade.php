@extends('layouts.pengguna')

@section('pengguna-content')
<div class="space-y-6">

    <!-- Card Utama Dashboard -->
    <div class="bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-6 sm:p-10 transition-shadow duration-200 hover:shadow-md">

        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] tracking-tight">
                Dashboard Pengguna
            </h1>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1.5">
                Selamat datang kembali,
                <span class="font-semibold text-[#643B62]">{{ auth()->user()->nama ?? 'Yuda' }}</span>.
                Pantau laporan dan temukan pendampingan di sini.
            </p>
        </div>

        <!-- Grid Menu Dashboard (5 Kartu Menu Utama) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

            <!-- Card 1: Buat Laporan Baru -->
            <div class="bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl p-6 flex flex-col justify-between transition-all duration-200 hover:shadow-md hover:border-[#643B62]">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold mb-4 text-lg shadow-inner">
                        📝
                    </div>
                    <h3 class="font-serif font-bold text-[#3E293F] text-base mb-2">Buat Laporan Baru</h3>
                    <p class="text-xs text-[#746B77] mb-6 leading-relaxed">
                        Laporkan kasus kekerasan secara aman, baik bernama maupun anonim dengan kode pelacakan resmi.
                    </p>
                </div>
                <a href="{{ route('pelaporan.buat') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Buat Laporan &rarr;
                </a>
            </div>

            <!-- Card 2: Riwayat Laporan -->
            <div class="bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl p-6 flex flex-col justify-between transition-all duration-200 hover:shadow-md hover:border-[#643B62]">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold mb-4 text-lg shadow-inner">
                        📋
                    </div>
                    <h3 class="font-serif font-bold text-[#3E293F] text-base mb-2">Riwayat Laporan</h3>
                    <p class="text-xs text-[#746B77] mb-6 leading-relaxed">
                        Pantau perkembangan tindak lanjut laporan dan respons resmi dari pihak penanganan.
                    </p>
                </div>
                <a href="{{ route('pelaporan.riwayat') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 border border-[#643B62]/40 text-[#643B62] hover:bg-[#EEE7F2] rounded-xl text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                    Lihat Riwayat &rarr;
                </a>
            </div>

            <!-- Card 3: Direktori Lembaga -->
            <div class="bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl p-6 flex flex-col justify-between transition-all duration-200 hover:shadow-md hover:border-[#643B62]">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold mb-4 text-lg shadow-inner">
                        🏛️
                    </div>
                    <h3 class="font-serif font-bold text-[#3E293F] text-base mb-2">Direktori Lembaga</h3>
                    <p class="text-xs text-[#746B77] mb-6 leading-relaxed">
                        Dapatkan informasi nomor darurat, kantor UPTD PPA, dan LBH terdekat di daerah Anda.
                    </p>
                </div>
                <a href="{{ route('direktori.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 border border-[#643B62]/40 text-[#643B62] hover:bg-[#EEE7F2] rounded-xl text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                    Cari Lembaga &rarr;
                </a>
            </div>

            <!-- Card 4: Jadwalkan Konsultasi -->
            <div class="bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl p-6 flex flex-col justify-between transition-all duration-200 hover:shadow-md hover:border-[#643B62]">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold mb-4 text-lg shadow-inner">
                        💬
                    </div>
                    <h3 class="font-serif font-bold text-[#3E293F] text-base mb-2">Jadwalkan Konsultasi</h3>
                    <p class="text-xs text-[#746B77] mb-6 leading-relaxed">
                        Pilih sesi konsultasi dengan konselor profesional secara aman dan terpercaya.
                    </p>
                </div>
                <a href="{{ route('konsultasi.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Pilih Jadwal &rarr;
                </a>
            </div>

            <!-- Card 5: Riwayat Konsultasi -->
            <div class="bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl p-6 flex flex-col justify-between transition-all duration-200 hover:shadow-md hover:border-[#643B62]">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold mb-4 text-lg shadow-inner">
                        📅
                    </div>
                    <h3 class="font-serif font-bold text-[#3E293F] text-base mb-2">Riwayat Konsultasi</h3>
                    <p class="text-xs text-[#746B77] mb-6 leading-relaxed">
                        Lihat daftar pemesanan, jadwal konsultasi, status sesi, dan akses percakapan dengan konselor.
                    </p>
                </div>
                <a href="{{ route('pengguna.riwayat-konsultasi') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Lihat Riwayat &rarr;
                </a>
            </div>

        </div>
    </div>

    <!-- Card Bagian Bawah: Konsultasi Mendatang -->
    <div class="bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-6 sm:p-10">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h3 class="font-serif font-bold text-[#3E293F] text-lg">
                Konsultasi Mendatang
            </h3>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Tombol Riwayat Laporan -->
                <a href="{{ route('pelaporan.riwayat') }}"
                   class="text-xs font-semibold text-[#643B62] hover:underline">
                    Buka Riwayat Saya &rarr;
                </a>

                <!-- Tombol Riwayat Konsultasi -->
                <a href="{{ route('pengguna.riwayat-konsultasi') }}"
                   class="inline-flex items-center px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold transition-all duration-200 shadow-sm">
                    📅 Riwayat Konsultasi &rarr;
                </a>
            </div>
        </div>

        <div class="text-center py-12 bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl flex flex-col items-center justify-center">
            <div class="w-14 h-14 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold mb-4 text-xl shadow-inner">
                💬
            </div>

            <p class="text-xs text-[#746B77] mb-6">
                Belum ada jadwal konsultasi mendatang.
            </p>

            <a href="{{ route('konsultasi.index') }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                Jadwalkan konsultasi &rarr;
            </a>
        </div>

    </div>
</div>
@endsection