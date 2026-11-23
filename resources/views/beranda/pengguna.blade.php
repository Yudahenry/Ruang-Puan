@extends('layouts.pengguna')

@section('pengguna-content')
@php
$userName = $user->nama ?? auth()->user()->nama ?? 'Pengguna';
$firstWordName = explode(' ', trim($userName))[0];

// Pemetaan warna badge status pemesanan yang harmonis & kontras nyaman
$warnaStatusPemesanan = [
'menunggu_pembayaran' => 'bg-amber-50 text-amber-800 border-amber-200/90 ring-1 ring-amber-500/10',
'menunggu_konfirmasi' => 'bg-amber-50 text-amber-800 border-amber-200/90 ring-1 ring-amber-500/10',
'pending' => 'bg-amber-50 text-amber-800 border-amber-200/90 ring-1 ring-amber-500/10',
'terkonfirmasi' => 'bg-sky-50 text-sky-800 border-sky-200/90 ring-1 ring-sky-500/10',
'terjadwal' => 'bg-sky-50 text-sky-800 border-sky-200/90 ring-1 ring-sky-500/10',
'berlangsung' => 'bg-emerald-50 text-emerald-800 border-emerald-200/90 ring-1 ring-emerald-500/10',
'selesai' => 'bg-[#EEE7F2] text-[#3E293F] border-[#DCD5DD] ring-1 ring-[#3E293F]/5',
'batal' => 'bg-rose-50 text-rose-800 border-rose-200/90 ring-1 ring-rose-500/10',
'ditolak' => 'bg-rose-50 text-rose-800 border-rose-200/90 ring-1 ring-rose-500/10',
];

// Pemetaan warna badge status laporan
$warnaStatusLaporan = [
'diterima' => 'bg-sky-50 text-sky-800 border-sky-200/90 ring-1 ring-sky-500/10',
'diverifikasi' => 'bg-indigo-50 text-indigo-800 border-indigo-200/90 ring-1 ring-indigo-500/10',
'diproses' => 'bg-amber-50 text-amber-800 border-amber-200/90 ring-1 ring-amber-500/10',
'diteruskan_ke_lembaga' => 'bg-purple-50 text-purple-800 border-purple-200/90 ring-1 ring-purple-500/10',
'selesai' => 'bg-emerald-50 text-emerald-800 border-emerald-200/90 ring-1 ring-emerald-500/10',
'ditutup' => 'bg-stone-100 text-stone-700 border-stone-200/90 ring-1 ring-stone-400/10',
];
@endphp

<div class="space-y-12 pb-16">

    <!-- ================================================================= -->
    <!-- 1. HERO BANNER: ELEGAN, BERKEDALAMAN & KONTEMPLATIF               -->
    <!-- ================================================================= -->
    <section class="relative w-full rounded-3xl overflow-hidden shadow-xl min-h-[360px] flex items-end bg-[#3E293F] border border-[#DCD5DD]/30">
        {{-- Background Image & Multi-layer Gradient Plum --}}
        <div class="absolute inset-0 z-0">
            @if(file_exists(public_path('images/hero_beranda.jpg')))
            <img src="{{ asset('images/hero_beranda.jpg') }}" alt="Ruang Puan" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full bg-gradient-to-br from-[#3E293F] via-[#51294F] to-[#251325]"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#3E293F] via-[#3E293F]/85 to-transparent"></div>
            <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(62,41,63,0.94) 0%, rgba(100,59,98,0.76) 55%, rgba(62,41,63,0.88) 100%);"></div>
        </div>

        {{-- Subtle Ambient Glows --}}
        <div class="absolute -top-12 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-[#EEE7F2]/10 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Hero Content --}}
        <div class="relative z-10 w-full px-6 sm:px-10 lg:px-14 py-10 pb-20">
            <div class="max-w-2xl text-white space-y-4">
                <div class="inline-flex items-center space-x-2.5 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 text-[#EEE7F2] text-[11px] font-semibold tracking-wider uppercase">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Ruang Pribadi Aman &bull; {{ strtoupper($firstWordName) }}</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight font-serif leading-[1.15]">
                    Ada ruang untukmu.<br>
                    <span class="text-[#EEE7F2] font-normal italic">Di setiap langkah pemulihan.</span>
                </h1>

                <p class="text-xs sm:text-sm text-[#EEE7F2]/90 font-light leading-relaxed max-w-xl">
                    Akses pendampingan konselor profesional, pantau pelaporan kasus secara terenkripsi, atau temukan bantuan lembaga rujukan terpercaya di sekitarmu.
                </p>

                <div class="pt-2 flex items-center space-x-2.5 text-xs text-[#EEE7F2]/80 font-light">
                    <svg class="w-4 h-4 text-[#EEE7F2]/90 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="tabular-nums">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    <span class="opacity-50">&bull;</span>
                    <span>Semua interaksi & berkasmu dijamin kerahasiaannya.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 2. QUICK ACTIONS (3 KARTU AKSI CEPAT DENGAN HIERARKI TEGAS)       -->
    <!-- ================================================================= -->
    <div class="-mt-16 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Aksi 1: Buat Laporan (Kartu Utama Menonjol) --}}
            <a href="{{ route('pelaporan.buat') }}"
                class="group relative overflow-hidden bg-gradient-to-br from-[#3E293F] to-[#51294F] hover:to-[#643B62] text-white rounded-3xl p-6 sm:p-7 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between border border-white/20">
                <div class="flex items-center space-x-4">
                    <div class="w-13 h-13 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-white shrink-0 shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#EEE7F2]/70 block">Layanan Aduan</span>
                        <h3 class="text-base sm:text-lg font-bold font-serif leading-snug">Buat Laporan Baru</h3>
                        <p class="text-xs text-[#EEE7F2]/80 font-light mt-0.5">Pengaduan aman terbuka atau anonim</p>
                    </div>
                </div>
                <span class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white group-hover:bg-white group-hover:text-[#3E293F] transition-all duration-300 shrink-0 ml-2">
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </span>
            </a>

            {{-- Aksi 2: Jadwalkan Konsultasi --}}
            <a href="{{ route('konsultasi.index') }}"
                class="group bg-white hover:bg-[#FCFAF8] text-[#3E293F] rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between border border-[#DCD5DD]">
                <div class="flex items-center space-x-4">
                    <div class="w-13 h-13 rounded-2xl bg-[#EEE7F2] flex items-center justify-center text-[#643B62] shrink-0 shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#746B77] block">Konseling Privat</span>
                        <h3 class="text-base sm:text-lg font-bold font-serif text-[#3E293F] leading-snug">Jadwalkan Konsultasi</h3>
                        <p class="text-xs text-[#746B77] font-light mt-0.5">Pilih psikolog & atur waktu sesi</p>
                    </div>
                </div>
                <span class="w-9 h-9 rounded-full bg-[#EEE7F2] flex items-center justify-center text-[#643B62] group-hover:bg-[#3E293F] group-hover:text-white transition-all duration-300 shrink-0 ml-2">
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </span>
            </a>

            {{-- Aksi 3: Jelajahi Edukasi --}}
            <a href="{{ route('edukasi.index') }}"
                class="group bg-white hover:bg-[#FCFAF8] text-[#3E293F] rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between border border-[#DCD5DD]">
                <div class="flex items-center space-x-4">
                    <div class="w-13 h-13 rounded-2xl bg-[#EEE7F2] flex items-center justify-center text-[#643B62] shrink-0 shadow-inner group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#746B77] block">Pemberdayaan</span>
                        <h3 class="text-base sm:text-lg font-bold font-serif text-[#3E293F] leading-snug">Jelajahi Edukasi</h3>
                        <p class="text-xs text-[#746B77] font-light mt-0.5">Kenali hak & panduan perlindungan</p>
                    </div>
                </div>
                <span class="w-9 h-9 rounded-full bg-[#EEE7F2] flex items-center justify-center text-[#643B62] group-hover:bg-[#3E293F] group-hover:text-white transition-all duration-300 shrink-0 ml-2">
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 3. METRIK STATISTIK: KONSISTEN DENGAN IKON OUTLINE & TABULAR-NUMS  -->
    <!-- ================================================================= -->
    <section>
        <div class="flex items-center justify-between mb-5">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-[#643B62] tracking-widest uppercase">Ikhtisar Akun</span>
                <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#3E293F]">Ringkasan Aktivitasmu</h2>
            </div>
            <div class="flex items-center space-x-1.5 text-xs text-[#746B77] bg-white px-3.5 py-1.5 rounded-full border border-[#DCD5DD] shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="font-medium text-[11px]">Tersinkronisasi Realtime</span>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            {{-- Metrik 1: Sesi Aktif --}}
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#746B77]">Konsultasi Aktif</span>
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">
                        {{ $konsultasiAktif ?? 0 }}
                    </div>
                    <div class="text-[11px] text-[#746B77] mt-1.5 pt-2 border-t border-[#DCD5DD]/50 flex items-center justify-between">
                        <span>Total dipesan:</span>
                        <span class="font-semibold text-[#3E293F] tabular-nums">{{ $totalKonsultasi ?? 0 }} sesi</span>
                    </div>
                </div>
            </div>

            {{-- Metrik 2: Laporan Diproses --}}
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#746B77]">Laporan Diproses</span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">
                        {{ $laporanAktif ?? 0 }}
                    </div>
                    <div class="text-[11px] text-[#746B77] mt-1.5 pt-2 border-t border-[#DCD5DD]/50 flex items-center justify-between">
                        <span>Total diajukan:</span>
                        <span class="font-semibold text-[#3E293F] tabular-nums">{{ $totalLaporan ?? 0 }} kasus</span>
                    </div>
                </div>
            </div>

            {{-- Metrik 3: Laporan Selesai --}}
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#746B77]">Laporan Selesai</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">
                        {{ $laporanSelesai ?? 0 }}
                    </div>
                    <div class="text-[11px] text-[#746B77] mt-1.5 pt-2 border-t border-[#DCD5DD]/50 flex items-center justify-between">
                        <span>Penanganan tuntas:</span>
                        <span class="font-semibold text-emerald-700">Terselesaikan</span>
                    </div>
                </div>
            </div>

            {{-- Metrik 4: Tagihan Menunggu --}}
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#746B77]">Tagihan Menunggu</span>
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 text-[#643B62] flex items-center justify-center shrink-0 border border-purple-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">
                        {{ $tagihanMenunggu ?? 0 }}
                    </div>
                    <div class="text-[11px] text-[#746B77] mt-1.5 pt-2 border-t border-[#DCD5DD]/50 flex items-center justify-between">
                        <span>Lunas terverifikasi:</span>
                        <span class="font-semibold text-[#643B62] tabular-nums">{{ $tagihanLunas ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 4. LANGKAHMU SEJAUH INI (2 KOLOM DINAMIS DENGAN KEDALAMAN TINGGI) -->
    <!-- ================================================================= -->
    <section>
        <div class="flex items-end justify-between mb-6">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-[#643B62] tracking-widest uppercase">Perjalananmu</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] mt-0.5">Langkahmu Sejauh Ini</h2>
            </div>
            <div class="flex items-center space-x-3 text-xs">
                <a href="{{ route('pelaporan.riwayat') }}" class="font-semibold text-[#643B62] hover:text-[#3E293F] transition flex items-center space-x-1 group">
                    <span>Semua Laporan</span>
                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                </a>
                <span class="text-[#DCD5DD]">&bull;</span>
                <a href="{{ route('pengguna.riwayat-konsultasi') }}" class="font-semibold text-[#643B62] hover:text-[#3E293F] transition flex items-center space-x-1 group">
                    <span>Semua Konsultasi</span>
                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- ------------------------------------------------------------- -->
            <!-- KOLOM KIRI: LAPORAN TERBARUMU                                 -->
            <!-- ------------------------------------------------------------- -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-[#DCD5DD] flex flex-col justify-between hover:shadow-md transition-shadow duration-200">
                <div>
                    {{-- Header Kartu --}}
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-[#DCD5DD]/60">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#643B62]"></span>
                            <span class="text-xs font-bold text-[#3E293F] uppercase tracking-wider">Laporan Terbarumu</span>
                        </div>
                        @if($laporanTerbaru)
                        @php
                        $badgeClass = $warnaStatusLaporan[$laporanTerbaru->status] ?? 'bg-amber-50 text-amber-800 border-amber-200/90 ring-1 ring-amber-500/10';
                        @endphp
                        <span class="text-[11px] px-3 py-1 rounded-full font-semibold border {{ $badgeClass }}">
                            {{ $laporanTerbaru->statusLabel() ?? ucfirst($laporanTerbaru->status) }}
                        </span>
                        @endif
                    </div>

                    @if($laporanTerbaru)
                    <div class="space-y-5">
                        {{-- Kode Pelacakan --}}
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-[10px] text-[#746B77] uppercase font-bold tracking-widest block">Kode Pelacakan</span>
                                <h3 class="text-xl sm:text-2xl font-serif font-bold text-[#3E293F] tracking-tight tabular-nums mt-0.5">
                                    {{ $laporanTerbaru->kode_pelacakan }}
                                </h3>
                            </div>
                            <a href="{{ route('pelaporan.lacak', $laporanTerbaru->kode_pelacakan) }}"
                                class="px-3.5 py-1.5 bg-[#EEE7F2] hover:bg-[#643B62] text-[#643B62] hover:text-white rounded-xl text-xs font-semibold transition-all duration-200 flex items-center space-x-1.5 group shadow-2xs"
                                title="Buka rincian pelacakan laporan">
                                <span>Lacak</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                        {{-- Informasi Kasus & Sifat Laporan --}}
                        <div class="bg-[#FCFAF8] p-4 rounded-2xl border border-[#DCD5DD]/80 text-xs space-y-2">
                            <div class="flex items-center justify-between text-[#746B77]">
                                <span>Kategori Kasus:</span>
                                <span class="font-semibold text-[#3E293F]">{{ $laporanTerbaru->jenisKasusLabel() ?? ucfirst($laporanTerbaru->jenis_kasus) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[#746B77]">
                                <span>Sifat Laporan:</span>
                                <span class="font-semibold text-[#3E293F] inline-flex items-center gap-1.5">
                                    @if($laporanTerbaru->anonim)
                                    <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span>Anonim Terlindungi</span>
                                    @else
                                    <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Laporan Terbuka</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-[#746B77]">
                                <span>Tanggal Diajukan:</span>
                                <span class="font-semibold text-[#3E293F] tabular-nums">{{ $laporanTerbaru->created_at?->translatedFormat('d F Y, H:i') ?? '-' }} WIB</span>
                            </div>
                        </div>

                        {{-- Stepper Progress Alur Penanganan Kasus --}}
                        <div class="pt-2">
                            <span class="text-[10px] font-bold text-[#746B77] uppercase tracking-wider block mb-3">Progres Penanganan:</span>
                            @php
                            $currentStatus = $laporanTerbaru->status;
                            $stepDiterima = true;
                            $stepVerif = in_array($currentStatus, ['diverifikasi', 'diproses', 'diteruskan_ke_lembaga', 'selesai']);
                            $stepProses = in_array($currentStatus, ['diproses', 'diteruskan_ke_lembaga', 'selesai']);
                            $stepSelesai = ($currentStatus === 'selesai');
                            @endphp

                            <div class="grid grid-cols-4 gap-2 text-center text-[10px]">
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full bg-[#643B62] text-white flex items-center justify-center font-bold shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-[#3E293F] mt-1.5">Diterima</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full {{ $stepVerif ? 'bg-[#643B62] text-white shadow-xs' : 'bg-[#DCD5DD] text-[#746B77]' }} flex items-center justify-center font-bold">
                                        @if($stepVerif)\n <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        @else
                                        <span class="tabular-nums">2</span>
                                        @endif
                                    </div>
                                    <span class="{{ $stepVerif ? 'font-semibold text-[#3E293F]' : 'text-[#746B77]' }} mt-1.5">Verifikasi</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full {{ $stepProses ? 'bg-[#643B62] text-white shadow-xs' : 'bg-[#DCD5DD] text-[#746B77]' }} flex items-center justify-center font-bold">
                                        @if($stepProses)\n <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        @else
                                        <span class="tabular-nums">3</span>
                                        @endif
                                    </div>
                                    <span class="{{ $stepProses ? 'font-semibold text-[#3E293F]' : 'text-[#746B77]' }} mt-1.5">Proses</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full {{ $stepSelesai ? 'bg-emerald-600 text-white shadow-xs' : 'bg-[#DCD5DD] text-[#746B77]' }} flex items-center justify-center font-bold">
                                        @if($stepSelesai)\n <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        @else
                                        <span class="tabular-nums">4</span>
                                        @endif
                                    </div>
                                    <span class="{{ $stepSelesai ? 'font-semibold text-emerald-700' : 'text-[#746B77]' }} mt-1.5">Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- Empty State: Laporan Bersih & Informatif --}}
                    <div class="text-center py-10 px-4 space-y-3">
                        <div class="w-16 h-16 rounded-3xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="font-serif font-bold text-base text-[#3E293F]">Belum Ada Laporan Kasus</h4>
                        <p class="text-xs text-[#746B77] max-w-sm mx-auto leading-relaxed">
                            Jika kamu atau orang terdekat mengalami kekerasan atau membutuhkan bantuan hukum, kamu dapat mengirimkan laporan secara aman dan terenkripsi.
                        </p>
                        <div class="pt-3">
                            <a href="{{ route('pelaporan.buat') }}"
                                class="inline-flex items-center space-x-2 px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                                <span>+ Buat Laporan Pertama</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                @if($laporanTerbaru)
                <div class="pt-4 mt-5 border-t border-[#DCD5DD]/60 flex items-center justify-between text-xs text-[#746B77]">
                    <span class="truncate max-w-[220px]">Ringkasan: {{ Str::limit($laporanTerbaru->kronologi, 35) }}</span>
                    <a href="{{ route('pelaporan.lacak', $laporanTerbaru->kode_pelacakan) }}" class="font-semibold text-[#643B62] hover:text-[#3E293F] flex items-center space-x-1 transition shrink-0">
                        <span>Detail Status</span>
                        <span>&rarr;</span>
                    </a>
                </div>
                @endif
            </div>

            <!-- ------------------------------------------------------------- -->
            <!-- KOLOM KANAN: KONSULTASI MENDATANG / TERDEKAT                  -->
            <!-- ------------------------------------------------------------- -->
            <div class="bg-[#EEE7F2]/50 rounded-3xl p-6 sm:p-8 shadow-xs border border-[#DCD5DD] flex flex-col justify-between hover:shadow-md transition-shadow duration-200">
                <div>
                    {{-- Header Kartu --}}
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-[#DCD5DD]/60">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#643B62]"></span>
                            <span class="text-xs font-bold text-[#3E293F] uppercase tracking-wider">Konsultasi Terdekat</span>
                        </div>
                        @if($konsultasiMendatang)
                        @php
                        $statusBayar = $konsultasiMendatang->status_pembayaran;
                        $isLunas = in_array($konsultasiMendatang->status, ['terkonfirmasi', 'lunas']) || $statusBayar === 'lunas';
                        @endphp
                        <span class="text-[11px] px-3 py-1 rounded-full font-semibold border {{ $isLunas ? 'bg-emerald-50 text-emerald-800 border-emerald-200/90 ring-1 ring-emerald-500/10' : 'bg-amber-50 text-amber-800 border-amber-200/90 ring-1 ring-amber-500/10' }}">
                            {{ $isLunas ? 'Terkonfirmasi & Lunas' : 'Menunggu Pembayaran' }}
                        </span>
                        @endif
                    </div>

                    @if($konsultasiMendatang && $konsultasiMendatang->jadwalKonsultasi)
                    @php
                    $jadwal = $konsultasiMendatang->jadwalKonsultasi;
                    $konselorUser = $jadwal->konselor?->user;
                    $tglCarbon = \Carbon\Carbon::parse($jadwal->tanggal);
                    $isConfirmed = in_array($konsultasiMendatang->status, ['terkonfirmasi', 'lunas']) || $konsultasiMendatang->status_pembayaran === 'lunas';
                    $sesiKonsultasi = $konsultasiMendatang->konsultasi;
                    @endphp

                    <div class="space-y-4">
                        {{-- Detail Konselor & Badge Tanggal Presisi --}}
                        <div class="flex items-start space-x-4">
                            <div class="shrink-0 w-16 h-18 bg-white rounded-2xl border border-[#DCD5DD] flex flex-col items-center justify-center shadow-xs">
                                <span class="text-[10px] font-bold text-[#746B77] uppercase tracking-widest">{{ strtoupper($tglCarbon->translatedFormat('M')) }}</span>
                                <span class="text-2xl font-serif font-bold text-[#3E293F] tabular-nums leading-none my-0.5">{{ $tglCarbon->format('d') }}</span>
                                <span class="text-[9px] text-[#746B77] font-medium">{{ $tglCarbon->translatedFormat('D') }}</span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-serif font-bold text-[#3E293F] truncate">
                                    {{ $konselorUser->nama ?? 'Psikolog Ruang Puan' }}
                                </h4>
                                <p class="text-xs text-[#746B77] mt-0.5 truncate">
                                    {{ $jadwal->konselor?->gelar ?? 'Psikolog Klinis Terverifikasi' }}
                                </p>
                                <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white rounded-xl border border-[#DCD5DD] font-medium text-[#3E293F] shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="tabular-nums">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB</span>
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 bg-white rounded-xl border border-[#DCD5DD] font-semibold text-[#643B62] shadow-2xs tabular-nums">
                                        Rp {{ number_format($konsultasiMendatang->total_biaya ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Petunjuk Sesi & ID Transaksi --}}
                        <div class="bg-white/80 p-4 rounded-2xl border border-[#DCD5DD] text-xs space-y-1.5 shadow-2xs">
                            <div class="flex items-center justify-between text-[#746B77]">
                                <span>Metode Konsultasi:</span>
                                <span class="font-semibold text-[#3E293F] inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span>Chat Privat Interaktif</span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-[#746B77]">
                                <span>No. Booking:</span>
                                <span class="font-semibold text-[#3E293F] tabular-nums font-mono text-[11px]">#RP-{{ str_pad($konsultasiMendatang->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- Empty State: Jadwal Kosong --}}
                    <div class="text-center py-10 px-4 space-y-3">
                        <div class="w-16 h-16 rounded-3xl bg-white text-[#643B62] flex items-center justify-center mx-auto shadow-sm border border-[#DCD5DD]">
                            <svg class="w-8 h-8 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="font-serif font-bold text-base text-[#3E293F]">Belum Ada Jadwal Mendatang</h4>
                        <p class="text-xs text-[#746B77] max-w-sm mx-auto leading-relaxed">
                            Butuh ruang untuk bercerita atau berkonsultasi dengan profesional? Jadwalkan sesi bersama psikolog klinis yang siap mendengarkanmu.
                        </p>
                        <div class="pt-3">
                            <a href="{{ route('konsultasi.index') }}"
                                class="inline-flex items-center space-x-2 px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                                <span>+ Jadwalkan Sesi Konsultasi</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                @if($konsultasiMendatang)
                <div class="pt-4 mt-5 border-t border-[#DCD5DD]/60 flex items-center justify-between">
                    <a href="{{ route('pengguna.riwayat-konsultasi.invoice', $konsultasiMendatang->id) }}"
                        class="text-xs font-semibold text-[#746B77] hover:text-[#3E293F] transition inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#746B77]\" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Unduh Bukti/Invoice</span>
                    </a>

                    @if($isConfirmed && $sesiKonsultasi)
                    <a href="{{ route('konsultasi.chat', $sesiKonsultasi->id) }}"
                        class="inline-flex items-center space-x-2 px-5 py-2.5 bg-[#3E293F] hover:bg-[#643B62] text-white rounded-2xl text-xs font-semibold shadow-sm hover:shadow-md transition-all duration-200 group">
                        <span>Masuk ke Ruang Chat</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                    @elseif(!$isConfirmed)
                    <a href="{{ route('konsultasi.tagihan', $konsultasiMendatang->id) }}"
                        class="inline-flex items-center space-x-2 px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-2xl text-xs font-semibold shadow-sm hover:shadow-md transition-all duration-200 group">
                        <span>Bayar Sekarang</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                    @endif
                </div>
                @endif
            </div>

        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 5. DAFTAR RIWAYAT KONSULTASI / BOOKING TERBARU                    -->
    <!-- ================================================================= -->
    <section class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-[#DCD5DD]/60">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-[#643B62] tracking-widest uppercase">Catatan Aktivitas</span>
                <h3 class="text-xl sm:text-2xl font-serif font-bold text-[#3E293F]">Riwayat Sesi Terakhir</h3>
                <p class="text-xs text-[#746B77] mt-0.5">Daftar pemesanan dan jadwal sesi yang pernah kamu buat.</p>
            </div>
            <a href="{{ route('pengguna.riwayat-konsultasi') }}"
                class="inline-flex items-center space-x-2 px-4 py-2 bg-[#EEE7F2] hover:bg-[#643B62] text-[#643B62] hover:text-white rounded-xl text-xs font-semibold transition-all duration-200 self-start sm:self-auto group">
                <span>Lihat Seluruh Riwayat</span>
                <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#DCD5DD] text-[#746B77] uppercase text-[10px] tracking-wider bg-[#FCFAF8]">
                        <th class="py-3.5 px-4 font-semibold rounded-l-2xl">ID & Tanggal</th>
                        <th class="py-3.5 px-4 font-semibold">Konselor & Jam</th>
                        <th class="py-3.5 px-4 font-semibold">Total Tarif</th>
                        <th class="py-3.5 px-4 font-semibold">Status Sesi</th>
                        <th class="py-3.5 px-4 font-semibold">Pembayaran</th>
                        <th class="py-3.5 px-4 font-semibold text-right rounded-r-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD5DD]/50">
                    @forelse($riwayatPemesanan as $pemesanan)
                    @php
                    $jadwal = $pemesanan->jadwalKonsultasi;
                    $namaKonselor = $jadwal?->konselor?->user?->nama ?? 'Konselor Ruang Puan';
                    $badgeBooking = $warnaStatusPemesanan[$pemesanan->status] ?? 'bg-stone-50 text-stone-700 border-stone-200';
                    $isLunas = ($pemesanan->status_pembayaran === 'lunas' || in_array($pemesanan->status, ['terkonfirmasi', 'lunas']));
                    @endphp
                    <tr class="hover:bg-[#FCFAF8] transition-colors duration-150">
                        {{-- ID & Tanggal --}}
                        <td class="py-4 px-4 font-medium text-[#3E293F]">
                            <div class="font-bold tabular-nums font-mono">#RP-{{ str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-[11px] text-[#746B77] tabular-nums mt-0.5">
                                {{ $jadwal?->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') : $pemesanan->created_at?->format('d/m/Y') }}
                            </div>
                        </td>

                        {{-- Konselor & Jam --}}
                        <td class="py-4 px-4">
                            <div class="font-semibold text-[#3E293F]">{{ $namaKonselor }}</div>
                            <div class="text-[11px] text-[#746B77] tabular-nums mt-0.5">
                                {{ $jadwal ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') . ' WIB' : '-' }}
                            </div>
                        </td>

                        {{-- Biaya --}}
                        <td class="py-4 px-4 font-semibold text-[#3E293F] tabular-nums">
                            Rp {{ number_format($pemesanan->total_biaya ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- Status Sesi --}}
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold border {{ $badgeBooking }}">
                                {{ ucfirst(str_replace('_', ' ', $pemesanan->status)) }}
                            </span>
                        </td>

                        {{-- Status Pembayaran --}}
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold border {{ $isLunas ? 'bg-emerald-50 text-emerald-800 border-emerald-200/90 ring-1 ring-emerald-500/10' : 'bg-amber-50 text-amber-800 border-amber-200/90 ring-1 ring-amber-500/10' }}">
                                {{ $isLunas ? 'Lunas' : 'Menunggu' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-4 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('pengguna.riwayat-konsultasi.invoice', $pemesanan->id) }}"
                                class="px-3 py-1.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-semibold transition inline-block">
                                Invoice
                            </a>

                            @if($isLunas && $pemesanan->konsultasi)
                            <a href="{{ route('konsultasi.chat', $pemesanan->konsultasi->id) }}"
                                class="px-3 py-1.5 bg-[#3E293F] hover:bg-[#643B62] text-white rounded-xl text-xs font-semibold transition inline-block">
                                Chat
                            </a>
                            @elseif(!$isLunas && !in_array($pemesanan->status, ['batal', 'ditolak']))
                            <a href="{{ route('konsultasi.tagihan', $pemesanan->id) }}"
                                class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold transition inline-block">
                                Bayar
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-[#746B77]">
                            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="text-sm font-semibold text-[#3E293F]">Belum Ada Riwayat Konsultasi</div>
                            <p class="text-xs text-[#746B77] mt-0.5">Booking konsultasi pertamamu dengan jadwal yang fleksibel.</p>
                            <a href="{{ route('konsultasi.index') }}" class="text-xs text-[#643B62] font-semibold hover:text-[#3E293F] mt-2 inline-flex items-center gap-1">
                                <span>Pilih jadwal konselor</span>
                                <span>&rarr;</span>
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 6. EDUKASI TERBARU: GRID VISUAL DENGAN RASIO PRESISI              -->
    <!-- ================================================================= -->
    <section>
        <div class="flex items-end justify-between mb-6">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-[#643B62] tracking-widest uppercase">Bekal Bertumbuh</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] mt-0.5">Sedikit Belajar, Lebih Berdaya</h2>
            </div>
            <a href="{{ route('edukasi.index') }}" class="text-xs font-semibold text-[#643B62] hover:text-[#3E293F] flex items-center space-x-1 transition group">
                <span>Jelajahi Semua Materi</span>
                <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($materiEdukasis as $index => $materi)
            <a href="{{ route('edukasi.show', $materi->id) }}"
                class="group bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 border border-[#DCD5DD] flex flex-col justify-between transform hover:-translate-y-1">
                <div>
                    {{-- Thumbnail Container --}}
                    <div class="h-44 bg-[#EEE7F2] relative overflow-hidden">
                        @if(!empty($materi->file_url))
                        <img src="{{ $materi->file_url }}" alt="{{ $materi->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#EEE7F2] to-[#DCD5DD] text-[#643B62]">
                            <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="text-[9px] font-bold text-[#643B62] bg-white/95 backdrop-blur-md px-3 py-1 rounded-full uppercase tracking-wider shadow-xs border border-white/40">
                                {{ $materi->kategoriEdukasi?->nama_kategori ?? 'Edukasi' }}
                            </span>
                        </div>
                    </div>

                    {{-- Konten Artikel --}}
                    <div class="p-5">
                        <h3 class="font-bold text-[#3E293F] text-sm font-serif line-clamp-2 group-hover:text-[#643B62] transition-colors duration-200 leading-snug">
                            {{ $materi->judul }}
                        </h3>
                        <p class="text-[11px] text-[#746B77] mt-2 line-clamp-2 font-light leading-relaxed">
                            {{ Str::limit(strip_tags($materi->isi), 80) }}
                        </p>
                    </div>
                </div>

                {{-- Footer Kartu --}}
                <div class="px-5 pb-5 pt-2 flex items-center justify-between text-xs text-[#746B77] border-t border-[#DCD5DD]/50">
                    <span class="text-[11px] tabular-nums">{{ $materi->created_at?->diffForHumans() ?? 'Baru' }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#EEE7F2] text-[#643B62] flex items-center justify-center group-hover:bg-[#3E293F] group-hover:text-white transition-all duration-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full bg-white rounded-3xl p-10 border border-[#DCD5DD] text-center text-[#746B77]">
                <p class="text-xs">Belum ada materi edukasi yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 7. DIREKTORI BANTUAN & PUSAT PENDAMPINGAN HUKUM/SOSIAL            -->
    <!-- ================================================================= -->
    <section>
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- Banner Kiri: Temukan Bantuan di Sekitarmu (3/5) --}}
            <div class="lg:col-span-3 bg-[#3E293F] rounded-3xl p-7 lg:p-9 text-white shadow-sm flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-[#643B62]/40 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white shrink-0 shadow-inner backdrop-blur-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-serif font-bold">Temukan Lembaga Pendampingan</h3>
                        <p class="text-xs text-[#EEE7F2]/85 font-light leading-relaxed max-w-md mt-1">
                            Cari pos penanganan terdekat, UPTD PPA daerah, LBH bantuan hukum, atau shelter rumah aman yang terdaftar resmi.
                        </p>
                    </div>

                    {{-- Form Filter Direktori Dinamis --}}
                    <form action="{{ route('direktori.index') }}" method="GET" class="pt-2">
                        <div class="flex flex-col sm:flex-row items-stretch gap-3">
                            <div class="flex-1">
                                <select name="wilayah" class="w-full bg-[#643B62]/90 border border-white/20 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-white/40">
                                    <option value="" class="text-[#3E293F]">Semua Wilayah</option>
                                    @foreach($wilayahList ?? [] as $wilayah)
                                    <option value="{{ $wilayah }}" class="text-[#3E293F]">{{ $wilayah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1">
                                <select name="jenis" class="w-full bg-[#643B62]/90 border border-white/20 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-white/40">
                                    <option value="" class="text-[#3E293F]">Jenis Layanan</option>
                                    @foreach($layananList ?? [] as $layanan)
                                    <option value="{{ $layanan }}" class="text-[#3E293F]">{{ ucfirst(str_replace('_', ' ', $layanan)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="px-5 py-2.5 bg-white hover:bg-[#EEE7F2] text-[#643B62] rounded-xl text-xs font-semibold shadow-sm transition flex items-center justify-center space-x-1.5 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span>Cari</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Banner Kanan: Jejak Langkah & Riwayat Lengkap (2/5) --}}
            <div class="lg:col-span-2 bg-white rounded-3xl p-7 lg:p-9 shadow-xs flex flex-col justify-between border border-[#DCD5DD] relative overflow-hidden">
                <div class="space-y-3 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] flex items-center justify-center text-[#643B62] shrink-0 shadow-inner">
                        <svg class="w-6 h-6 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-serif font-bold text-[#3E293F]">Jejak Langkahmu</h3>
                        <p class="text-xs text-[#746B77] font-light leading-relaxed mt-1">
                            Tinjau riwayat laporan pengaduan, dokumen berkas, sesi chat bersama psikolog, dan tagihan invoice dalam satu akun aman.
                        </p>
                    </div>
                </div>

                <div class="pt-6 relative z-10 flex flex-wrap gap-2.5">
                    <a href="{{ route('pelaporan.riwayat') }}"
                        class="inline-flex items-center space-x-2 px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition group">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Riwayat Laporan</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                    <a href="{{ route('pengguna.riwayat-konsultasi') }}"
                        class="inline-flex items-center space-x-2 px-4 py-2.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-semibold transition group">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Riwayat Konsultasi</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 8. CATATAN PENTING & PRIVASI: AMAN, TENANG, PROFESIONAL           -->
    <!-- ================================================================= -->
    <div class="bg-gradient-to-r from-[#EEE7F2]/80 via-white to-[#EEE7F2]/80 border border-[#DCD5DD] rounded-3xl p-6 sm:p-7 flex items-start space-x-4 shadow-2xs">
        <div class="w-10 h-10 rounded-2xl bg-[#643B62]/10 text-[#643B62] flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div class="leading-relaxed font-light text-xs space-y-1.5 flex-1">
            <p class="text-[#3E293F]">
                <strong class="font-bold">Kerahasiaan & Keamanan Data Pengguna:</strong> Seluruh identitas sensitif (nomor telepon, kontak darurat, serta dokumen bukti yang kamu unggah) disimpan secara terenkripsi di dalam basis data untuk melindungi privasi Anda sepenuhnya.
            </p>
            <p class="text-[#746B77]">
                Layanan konsultasi melalui chat merupakan pendampingan awal psikologis dan edukasi hukum. Jika kamu menghadapi situasi ancaman bahaya fisik langsung atau darurat medis, segera hubungi pihak kepolisian (110) atau layanan SAPA 129 Kementerian PPPA.
            </p>
        </div>
    </div>

</div>
@endsection