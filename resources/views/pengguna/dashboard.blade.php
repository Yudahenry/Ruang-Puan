@extends('layouts.pengguna')

@section('pengguna-content')
<div class="space-y-6">

    <!-- Card Utama Dashboard -->
    <div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 transition-shadow duration-200 hover:shadow-md">

        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-berry-900 tracking-tight">
                Dashboard Pengguna
            </h1>
            <p class="text-sm text-ink-600 mt-1">
                Selamat datang kembali,
                <span class="font-semibold text-berry-700">{{ auth()->user()->nama }}</span>.
                Pantau laporan dan temukan pendampingan di sini.
            </p>
        </div>

        <!-- Grid Menu Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

            <!-- Card 1: Buat Laporan Baru -->
            <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-berry-100 text-berry-700 flex items-center justify-center font-bold mb-4">
                        📝
                    </div>
                    <h3 class="font-bold text-berry-900 text-lg mb-2">Buat Laporan Baru</h3>
                    <p class="text-xs text-ink-600 mb-6 leading-relaxed">
                        Laporkan kasus kekerasan secara aman, baik bernama maupun anonim dengan kode pelacakan resmi.
                    </p>
                </div>
                <a href="{{ route('pelaporan.buat') }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Buat Laporan &rarr;
                </a>
            </div>

            <!-- Card 2: Riwayat Laporan -->
            <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-rose-200 text-rose-600 flex items-center justify-center font-bold mb-4">
                        📋
                    </div>
                    <h3 class="font-bold text-berry-900 text-lg mb-2">Riwayat Laporan</h3>
                    <p class="text-xs text-ink-600 mb-6 leading-relaxed">
                        Pantau perkembangan tindak lanjut laporan dan respons resmi dari pihak penanganan.
                    </p>
                </div>
                <a href="{{ route('pelaporan.riwayat') }}"
                   class="inline-flex items-center justify-center px-4 py-2 border border-rose-600/40 text-rose-600 hover:bg-rose-200/50 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                    Lihat Riwayat &rarr;
                </a>
            </div>

            <!-- Card 3: Direktori Lembaga -->
            <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-lavender-200 text-lavender-600 flex items-center justify-center font-bold mb-4">
                        🏛️
                    </div>
                    <h3 class="font-bold text-berry-900 text-lg mb-2">Direktori Lembaga</h3>
                    <p class="text-xs text-ink-600 mb-6 leading-relaxed">
                        Dapatkan informasi nomor darurat, kantor UPTD PPA, dan LBH terdekat di daerah Anda.
                    </p>
                </div>
                <a href="{{ route('direktori.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 border border-lavender-600/40 text-lavender-600 hover:bg-lavender-200/50 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                    Cari Lembaga &rarr;
                </a>
            </div>

            <!-- Card 4: Jadwalkan Konsultasi -->
            <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold mb-4">
                        💬
                    </div>
                    <h3 class="font-bold text-berry-900 text-lg mb-2">Jadwalkan Konsultasi</h3>
                    <p class="text-xs text-ink-600 mb-6 leading-relaxed">
                        Pilih sesi konsultasi dengan konselor profesional secara aman dan terpercaya.
                    </p>
                </div>
                <a href="{{ route('konsultasi.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-emerald-700 hover:bg-emerald-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Pilih Jadwal &rarr;
                </a>
            </div>

            <!-- Card 5: Riwayat Konsultasi -->
            <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold mb-4">
                        📅
                    </div>
                    <h3 class="font-bold text-berry-900 text-lg mb-2">Riwayat Konsultasi</h3>
                    <p class="text-xs text-ink-600 mb-6 leading-relaxed">
                        Lihat daftar pemesanan, jadwal konsultasi, status sesi, dan akses percakapan dengan konselor.
                    </p>
                </div>
                <a href="{{ route('pengguna.riwayat-konsultasi') }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-emerald-700 hover:bg-emerald-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Lihat Riwayat &rarr;
                </a>
            </div>

        </div>
    </div>

    <!-- Card Bagian Bawah: Konsultasi Mendatang -->
    <div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8">

        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-berry-900 text-base">
                Konsultasi Mendatang
            </h3>

            <div class="flex flex-wrap items-center gap-3">

                <!-- Tombol Riwayat Laporan -->
                <a href="{{ route('pelaporan.riwayat') }}"
                   class="text-xs font-semibold text-berry-700 hover:underline">
                    Buka Riwayat Saya &rarr;
                </a>

                <!-- Tombol Riwayat Konsultasi -->
                <a href="{{ route('pengguna.riwayat-konsultasi') }}"
                   class="inline-flex items-center px-3 py-2 bg-emerald-700 hover:bg-emerald-900 text-white rounded-lg text-xs font-semibold transition-all duration-200">
                    📅 Riwayat Konsultasi &rarr;
                </a>

            </div>
        </div>

        <div class="text-center py-10 bg-cream-50/70 border border-cream-200 rounded-xl flex flex-col items-center justify-center">
            <div class="w-12 h-12 rounded-full bg-lavender-200 text-lavender-600 flex items-center justify-center font-bold mb-3">
                💬
            </div>

            <p class="text-xs text-ink-600 mb-4">
                Belum ada jadwal konsultasi mendatang.
            </p>

            <a href="{{ route('konsultasi.index') }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-berry-800 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                Jadwalkan konsultasi &rarr;
            </a>
        </div>

    </div>
</div>
@endsection