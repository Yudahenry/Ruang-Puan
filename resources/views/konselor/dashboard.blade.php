@extends('layouts.konselor')

@section('konselor-content')
@php
    $statusVerif = $konselor->status_verifikasi ?? (auth()->user()->konselor->status_verifikasi ?? 'menunggu');
    $infoKelengkapan = $kelengkapan ?? ($konselor ? $konselor->kelengkapanProfil() : null);
@endphp

<div class="space-y-10 max-w-7xl mx-auto py-2 pb-16">

    <!-- ================================================================= -->
    <!-- 1. HEADER / HERO SECTION BERKARAKTER (PLUM AMBIENT BANNER)       -->
    <!-- ================================================================= -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#3E293F] via-[#4F2B51] to-[#643B62] text-white p-6 sm:p-8 lg:p-10 shadow-xl border border-white/10">
        {{-- Ambient Decorative Soft Glows --}}
        <div class="absolute -top-16 -right-16 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-72 h-72 bg-[#EEE7F2]/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-white/15 backdrop-blur-md text-[#EEE7F2] border border-white/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Ruang Praktik Konselor Profesional</span>
                    </span>
                    <span class="inline-flex items-center gap-1 text-[11px] text-[#EEE7F2]/80 bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full border border-white/10 tabular-nums font-light">
                        <svg class="w-3.5 h-3.5 text-[#EEE7F2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white tracking-tight leading-tight">
                    Selamat Praktik, {{ $greetingName ?? (auth()->user()->nama ?? 'Konselor') }}.
                </h1>
                <p class="text-xs sm:text-sm text-[#EEE7F2]/85 font-light leading-relaxed">
                    Pantau agenda konsultasi hari ini, verifikasi permintaan booking baru, dan pastikan setiap sesi berjalan aman serta terstandarisasi.
                </p>
            </div>

            {{-- Status Izin Praktik Badge & Aksi Cepat --}}
            <div class="flex flex-col sm:flex-row md:flex-col items-start md:items-end gap-3 shrink-0">
                @if($statusVerif === 'disetujui')
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl text-xs font-bold bg-emerald-500/20 text-emerald-100 border border-emerald-400/40 backdrop-blur-md shadow-inner">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Izin Praktik Terverifikasi</span>
                    </div>
                @elseif($statusVerif === 'ditolak')
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl text-xs font-bold bg-rose-500/25 text-rose-100 border border-rose-400/40 backdrop-blur-md shadow-inner">
                        <svg class="w-4 h-4 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Verifikasi Berkas Ditolak</span>
                    </div>
                @else
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl text-xs font-bold bg-amber-400/20 text-amber-100 border border-amber-300/40 backdrop-blur-md shadow-inner">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                        <span>Menunggu Verifikasi Admin</span>
                    </div>
                @endif

                <a href="{{ route('konselor.jadwal') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-[#3E293F] hover:bg-[#EEE7F2] rounded-2xl text-xs font-bold transition shadow-sm hover:shadow-md group active:scale-[0.98]">
                    <svg class="w-4 h-4 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>Atur Slot Praktik</span>
                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- BANNER PERINGATAN KELENGKAPAN PROFIL & KREDENSIAL                 -->
    <!-- ================================================================= -->
    @if($infoKelengkapan && !$infoKelengkapan['is_lengkap'])
        <div class="bg-gradient-to-r from-amber-50 via-white to-amber-50/70 border-2 border-amber-300/90 rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                            <span>Profil Belum Lengkap ({{ $infoKelengkapan['persentase'] }}%)</span>
                        </span>
                        <span class="text-xs text-[#746B77] tabular-nums font-medium">
                            • {{ $infoKelengkapan['terisi'] }} dari {{ $infoKelengkapan['total'] }} data wajib terisi
                        </span>
                    </div>

                    <div>
                        <h2 class="text-lg sm:text-xl font-serif font-bold text-[#3E293F]">
                            Lengkapi Data Profil & Dokumen Legalitas Anda
                        </h2>
                        <p class="text-xs sm:text-sm text-[#746B77] mt-1 leading-relaxed max-w-2xl font-light">
                            Untuk menjaga kredibilitas dan perlindungan klien, konselor wajib melengkapi identitas, bidang spesialisasi, tarif sesi, dan nomor/dokumen STR & SIPP sebelum dapat membuka jadwal konsultasi atau disetujui admin.
                        </p>
                    </div>

                    <!-- Progress Bar Kelengkapan -->
                    <div class="max-w-md pt-1">
                        <div class="w-full bg-[#DCD5DD]/60 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-[#643B62] h-2.5 rounded-full transition-all duration-500" style="width: {{ $infoKelengkapan['persentase'] }}%"></div>
                        </div>
                    </div>

                    <!-- Rincian Field yang Masih Kosong -->
                    <div class="pt-1">
                        <span class="text-[10px] font-bold text-[#643B62] uppercase tracking-wider block mb-1.5">
                            Data yang masih perlu dilengkapi:
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(array_slice($infoKelengkapan['missing'], 0, 5) as $f => $lbl)
                                <span class="text-[10px] px-2.5 py-1 bg-white border border-amber-200 text-amber-900 rounded-lg font-medium shadow-2xs">
                                    • {{ $lbl }}
                                </span>
                            @endforeach
                            @if(count($infoKelengkapan['missing']) > 5)
                                <span class="text-[10px] px-2.5 py-1 bg-amber-100/80 border border-amber-300 text-amber-900 rounded-lg font-bold">
                                    +{{ count($infoKelengkapan['missing']) - 5 }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 shrink-0">
                    <a href="{{ route('konselor.profil.edit') }}" 
                       class="px-5 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2 group">
                        <span>Lengkapi Profil Sekarang</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- ================================================================= -->
    <!-- 2. STAT CARDS (4 KARTU BERKEDALAMAN DENGAN AKSEN INDIKATOR)       -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Sesi Hari Ini -->
        <div class="group relative overflow-hidden bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-400 to-sky-600 opacity-80"></div>
            <div>
                <span class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">{{ $stats['sesi_hari_ini'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1 font-medium">Sesi hari ini</p>
                <span class="inline-block mt-2 text-[10px] text-sky-700 bg-sky-50 px-2 py-0.5 rounded-md font-semibold border border-sky-100">Jadwal Aktif</span>
            </div>
            <div class="w-13 h-13 rounded-2xl bg-sky-50 text-sky-700 flex items-center justify-center border border-sky-100/80 shadow-2xs shrink-0 ring-4 ring-sky-500/10 group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: Booking Menunggu -->
        <div class="group relative overflow-hidden bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-600 opacity-80"></div>
            <div>
                <span class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">{{ $stats['booking_menunggu'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1 font-medium">Booking menunggu</p>
                <span class="inline-block mt-2 text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md font-semibold border border-amber-100">Perlu Konfirmasi</span>
            </div>
            <div class="w-13 h-13 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center border border-amber-100/80 shadow-2xs shrink-0 ring-4 ring-amber-500/10 group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 3: Sesi Selesai Bulan Ini -->
        <div class="group relative overflow-hidden bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-80"></div>
            <div>
                <span class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">{{ $stats['sesi_selesai_bulan_ini'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1 font-medium">Selesai bulan ini</p>
                <span class="inline-block mt-2 text-[10px] text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold border border-emerald-100">Tuntas Terlayani</span>
            </div>
            <div class="w-13 h-13 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100/80 shadow-2xs shrink-0 ring-4 ring-emerald-500/10 group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 4: Total Sesi Terlayani -->
        <div class="group relative overflow-hidden bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-xs hover:border-[#643B62]/60 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#643B62] to-[#3E293F] opacity-80"></div>
            <div>
                <span class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tabular-nums tracking-tight">{{ $stats['total_sesi'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1 font-medium">Total sesi terlayani</p>
                <span class="inline-block mt-2 text-[10px] text-[#643B62] bg-[#EEE7F2] px-2 py-0.5 rounded-md font-semibold border border-[#DCD5DD]/80">Akumulasi Praktik</span>
            </div>
            <div class="w-13 h-13 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center border border-[#DCD5DD] shadow-2xs shrink-0 ring-4 ring-[#643B62]/10 group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
        </div>
    </div>

    @include('konselor._sesi-chat')

    <!-- ================================================================= -->
    <!-- 3. MAIN GRID (SESI BERIKUTNYA, JADWAL HARI INI, & ANALISIS)        -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI (Span 2) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Sesi Berikutnya (Card dengan aksen strip kiri dan avatar klien) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-xs relative overflow-hidden">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#DCD5DD]/60">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#643B62]"></span>
                        <div>
                            <span class="text-[10px] font-bold text-[#643B62] uppercase tracking-widest block">Konseling Terdekat</span>
                            <h2 class="text-xl font-serif font-bold text-[#3E293F] mt-0.5">Sesi Berikutnya</h2>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span>{{ isset($nextSesi) ? 'Pembayaran Terkonfirmasi' : 'Belum Ada Sesi' }}</span>
                    </span>
                </div>
                
                @if(isset($nextSesi) && $nextSesi)
                    @php
                        $nextDate = \Carbon\Carbon::parse($nextSesi->jadwal->tanggal ?? now())->locale('id');
                        $namaKlien = $nextSesi->user->nama ?? $nextSesi->user->name ?? 'Klien';
                        $initialsKlien = collect(explode(' ', trim($namaKlien)))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                    @endphp
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 p-5 rounded-2xl bg-gradient-to-r from-[#EEE7F2]/40 via-white to-[#FCFAF8] border-l-4 border-l-[#643B62] border border-[#DCD5DD] shadow-2xs">
                        <div class="flex items-start sm:items-center space-x-4">
                            {{-- Tanggal Box --}}
                            <div class="w-16 h-18 rounded-2xl bg-[#EEE7F2] border border-[#DCD5DD] flex flex-col items-center justify-center text-[#643B62] font-bold shadow-inner shrink-0">
                                <span class="text-[10px] uppercase tracking-widest text-[#746B77]">{{ strtoupper($nextDate->translatedFormat('M')) }}</span>
                                <span class="text-2xl font-serif tabular-nums text-[#3E293F] leading-none my-0.5">{{ $nextDate->format('d') }}</span>
                                <span class="text-[9px] text-[#746B77] font-medium">{{ $nextDate->translatedFormat('D') }}</span>
                            </div>

                            {{-- Avatar Inisial & Identitas Klien --}}
                            <div class="space-y-1">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#3E293F] to-[#643B62] text-white flex items-center justify-center font-serif text-xs font-bold shadow-2xs">
                                        {{ $initialsKlien ?: 'KL' }}
                                    </div>
                                    <h3 class="text-base sm:text-lg font-serif font-bold text-[#3E293F]">{{ $namaKlien }}</h3>
                                </div>
                                <p class="text-xs text-[#746B77] tabular-nums font-light">
                                    {{ $nextDate->translatedFormat('l, d F Y') }} &bull; {{ substr($nextSesi->jadwal->jam_mulai ?? '', 0, 5) }}–{{ substr($nextSesi->jadwal->jam_selesai ?? '', 0, 5) }} WIB
                                </p>
                                <div class="pt-1 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 text-xs text-[#643B62] font-medium bg-white px-2.5 py-1 rounded-lg border border-[#DCD5DD]/80 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        <span class="tabular-nums">Chat Privat &bull; {{ $konselor->durasi_sesi ?? 60 }} menit</span>
                                    </span>
                                    <span class="inline-flex items-center text-xs font-mono font-medium text-[#746B77] bg-white px-2.5 py-1 rounded-lg border border-[#DCD5DD]/80 shadow-2xs tabular-nums">
                                        #RP-{{ str_pad($nextSesi->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            @if($nextSesi->konsultasi)
                                <a href="{{ route('konselor.chat.show', $nextSesi->konsultasi->id) }}" class="px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm hover:shadow-md transition flex items-center gap-1.5 group active:scale-[0.98]">
                                    <span>Masuk ke Chat</span>
                                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                                </a>
                            @else
                                <a href="{{ route('konselor.booking') }}" class="px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm hover:shadow-md transition flex items-center gap-1.5 group active:scale-[0.98]">
                                    <span>Kelola Booking</span>
                                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Empty State Berbingkai & Informatif --}}
                    <div class="py-10 px-4 text-center">
                        <div class="w-16 h-16 rounded-3xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto mb-3 ring-8 ring-[#EEE7F2]/40 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="text-sm font-serif font-bold text-[#3E293F]">Belum Ada Sesi Mendatang</h4>
                        <p class="text-xs text-[#746B77] mt-1 max-w-sm mx-auto font-light leading-relaxed">
                            Sesi baru yang telah dibayar oleh klien dan terkonfirmasi akan otomatis dijadwalkan di sini.
                        </p>
                        <div class="pt-4">
                            <a href="{{ route('konselor.jadwal') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#EEE7F2] hover:bg-[#643B62] text-[#643B62] hover:text-white rounded-xl text-xs font-semibold transition">
                                <span>+ Buka Slot Waktu Baru</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Jadwal Hari Ini (List Item dengan Border Kiri Status & Avatar) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-xs">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#DCD5DD]/60">
                    <div>
                        <span class="text-[10px] font-bold text-[#643B62] uppercase tracking-widest block">Agenda Konseling</span>
                        <h2 class="text-xl font-serif font-bold text-[#3E293F] mt-0.5">Jadwal Hari Ini</h2>
                        <p class="text-xs text-[#746B77] mt-0.5 tabular-nums">{{ now()->locale('id')->translatedFormat('l, d F Y') }} &bull; {{ isset($jadwalHariIniList) ? $jadwalHariIniList->count() : 0 }} sesi</p>
                    </div>
                    <a href="{{ route('konselor.jadwal') ?? '#' }}" class="text-xs font-bold text-[#643B62] hover:text-[#3E293F] flex items-center gap-1 transition group">
                        <span>Buka Jadwal</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($jadwalHariIniList ?? [] as $pemesanan)
                        @php
                            $namaKlien = $pemesanan->user->nama ?? $pemesanan->user->name ?? 'Klien';
                            $initialsKlien = collect(explode(' ', trim($namaKlien)))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                            $isNext = isset($nextSesi) && $nextSesi->id === $pemesanan->id;
                            $sesiSelesai = $pemesanan->status === 'selesai';
                        @endphp
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-[#FCFAF8] border-l-4 {{ $sesiSelesai ? 'border-l-stone-400' : ($isNext ? 'border-l-[#643B62]' : 'border-l-sky-500') }} border border-[#DCD5DD] hover:border-[#643B62]/50 hover:shadow-sm transition">
                            <div class="flex items-center space-x-3.5">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-[#3E293F] to-[#643B62] text-white flex items-center justify-center font-serif text-xs font-bold shadow-2xs shrink-0">
                                    {{ $initialsKlien ?: 'KL' }}
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-[#3E293F] block leading-snug">{{ $namaKlien }}</span>
                                    <span class="text-[11px] text-[#746B77] tabular-nums">
                                        {{ substr($pemesanan->jadwal->jam_mulai ?? '', 0, 5) }}–{{ substr($pemesanan->jadwal->jam_selesai ?? '', 0, 5) }} WIB &bull; Chat Privat
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="px-3.5 py-1 rounded-full text-xs font-semibold {{ $sesiSelesai ? 'bg-stone-100 text-stone-700' : ($isNext ? 'bg-[#EEE7F2] text-[#643B62]' : 'bg-sky-50 text-sky-800 border border-sky-200/90') }}">
                                    {{ $sesiSelesai ? 'Selesai' : ($isNext ? 'Berikutnya' : 'Terjadwal') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State Terarah --}}
                        <div class="py-10 px-4 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto mb-2 ring-6 ring-[#EEE7F2]/40">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h4 class="text-xs font-bold text-[#3E293F]">Tidak Ada Sesi Konsultasi Hari Ini</h4>
                            <p class="text-[11px] text-[#746B77] mt-0.5">Nikmati waktu istirahat atau tambahkan slot jadwal baru untuk klien.</p>
                            <a href="{{ route('konselor.jadwal') }}" class="text-xs text-[#643B62] font-semibold hover:text-[#3E293F] mt-3 inline-flex items-center gap-1">
                                <span>Kelola jadwal praktik</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ANALISIS: Performa Praktik Kamu -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-[#DCD5DD]/60">
                    <div>
                        <span class="text-[10px] font-bold text-[#643B62] tracking-widest uppercase block mb-0.5">Analisis Metrik</span>
                        <h2 class="text-xl font-serif font-bold text-[#3E293F]">Performa Praktik Kamu</h2>
                        <p class="text-xs text-[#746B77] mt-0.5">Pantau distribusi sesi, hari tersibuk, dan utilisasi slot praktik konseling.</p>
                    </div>
                    <span class="text-xs font-semibold text-[#746B77] bg-[#FCFAF8] px-3 py-1.5 rounded-full border border-[#DCD5DD]">6 bulan terakhir</span>
                </div>

                <!-- 3 Visual Analisis Grafik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Grafik 1: Sesi per bulan -->
                    <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD] flex flex-col justify-between">
                        @php
                            $maxSesiBulanan = max(collect($performaData['sesi_per_bulan_6'] ?? [])->pluck('jumlah')->all() ?: [0]);
                        @endphp
                        <div>
                            <h3 class="text-xs font-bold text-[#3E293F] mb-4">Sesi per bulan</h3>
                        </div>
                        <div class="h-32 flex items-end justify-between gap-2 pt-4 border-b border-[#DCD5DD]">
                            @foreach($performaData['sesi_per_bulan_6'] ?? [] as $bulan)
                                <div class="w-full flex flex-col items-center gap-1">
                                    <span class="text-[10px] tabular-nums {{ $bulan['is_active'] ? 'font-bold text-[#3E293F]' : 'text-[#746B77]' }}">{{ $bulan['jumlah'] }}</span>
                                    <div class="w-full {{ $bulan['is_active'] ? 'bg-[#3E293F]' : 'bg-[#DCD5DD]/80' }} rounded-t-lg transition-all" style="height: {{ $maxSesiBulanan > 0 ? max(6, round(($bulan['jumlah'] / $maxSesiBulanan) * 100)) : 6 }}%"></div>
                                    <span class="text-[10px] {{ $bulan['is_active'] ? 'font-bold text-[#3E293F]' : 'text-[#746B77]' }}">{{ $bulan['bulan'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-[#746B77] mt-3">Jumlah sesi selesai dan terkonfirmasi per bulan.</p>
                    </div>

                    <!-- Grafik 2: Hari tersibuk -->
                    <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD] flex flex-col justify-between">
                        @php
                            $maxSesiHarian = max(collect($performaData['hari_tersibuk'] ?? [])->pluck('jumlah')->all() ?: [0]);
                        @endphp
                        <div>
                            <h3 class="text-xs font-bold text-[#3E293F] mb-4">Hari tersibuk</h3>
                        </div>
                        <div class="h-32 flex items-end justify-between gap-1 pt-4 border-b border-[#DCD5DD]">
                            @foreach($performaData['hari_tersibuk'] ?? [] as $hari)
                                <div class="w-full flex flex-col items-center gap-1">
                                    <span class="text-[10px] tabular-nums {{ $hari['is_active'] ? 'font-bold text-[#3E293F]' : 'text-[#746B77]' }}">{{ $hari['jumlah'] }}</span>
                                    <div class="w-full {{ $hari['is_active'] ? 'bg-[#3E293F]' : 'bg-[#DCD5DD]/80' }} rounded-t-lg transition-all" style="height: {{ $maxSesiHarian > 0 ? max(6, round(($hari['jumlah'] / $maxSesiHarian) * 100)) : 6 }}%"></div>
                                    <span class="text-[10px] {{ $hari['is_active'] ? 'font-bold text-[#3E293F]' : 'text-[#746B77]' }}">{{ $hari['hari'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-[#746B77] mt-3">Distribusi sesi berdasarkan hari dalam sebulan.</p>
                    </div>

                    <!-- Grafik 3: Slot terisi -->
                    <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD] flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-[#3E293F] mb-4">Slot terisi</h3>
                        </div>
                        <div class="space-y-3.5 my-auto">
                            @forelse($performaData['slot_terisi'] ?? [] as $minggu)
                                <div>
                                    <div class="flex justify-between text-[11px] font-medium text-[#3E293F] mb-1">
                                        <span>{{ $minggu['minggu'] }}</span>
                                        <span class="tabular-nums font-semibold">{{ $minggu['persentase'] }}%</span>
                                    </div>
                                    <div class="w-full bg-[#DCD5DD]/50 h-2.5 rounded-full overflow-hidden">
                                        <div class="bg-[#3E293F] h-full rounded-full transition-all" style="width: {{ $minggu['persentase'] }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-[#746B77]">Belum ada data slot.</p>
                            @endforelse
                        </div>
                        <p class="text-[11px] text-[#746B77] mt-3">Persentase okupansi slot terjadwal.</p>
                    </div>

                </div>
            </div>

        </div>

        <!-- ============================================================= -->
        <!-- 4. SIDEBAR KANAN: BOOKING MENUNGGU (Span 1)                   -->
        <!-- ============================================================= -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#DCD5DD] shadow-xs">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-serif font-bold text-[#3E293F]">Booking Menunggu</h2>
                    <span class="w-7 h-7 rounded-full bg-[#EEE7F2] text-[#643B62] font-bold text-xs flex items-center justify-center tabular-nums">{{ count($bookingMenunggu ?? []) }}</span>
                </div>
                <p class="text-xs text-[#746B77] mb-6 font-light">Permintaan konsultasi klien yang menunggu konfirmasimu.</p>

                <div class="space-y-3.5">
                    @forelse($bookingMenunggu ?? [] as $item)
                        @php
                            $initKlien = collect(explode(' ', trim($item['klien'] ?? 'Klien')))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                        @endphp
                        <div class="p-4 rounded-2xl bg-[#FCFAF8] border-l-4 border-l-amber-500 border border-[#DCD5DD] space-y-2.5 hover:border-[#643B62]/40 hover:shadow-xs transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-[#643B62] to-[#3E293F] text-white flex items-center justify-center text-[10px] font-bold">
                                        {{ $initKlien ?: 'KL' }}
                                    </div>
                                    <span class="text-sm font-bold text-[#3E293F]">{{ $item['klien'] }}</span>
                                </div>
                                <span class="text-[10px] text-[#746B77] tabular-nums">{{ $item['diajukan'] }}</span>
                            </div>
                            <div class="text-xs text-[#746B77] space-y-1 pl-1">
                                <p class="flex items-center gap-1.5 tabular-nums">
                                    <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $item['jadwal'] }}</span>
                                </p>
                                <p class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    <span>{{ $item['layanan'] }}</span>
                                </p>
                            </div>
                            <div class="pt-2 flex items-center justify-between border-t border-[#DCD5DD]/60 text-xs">
                                <span class="font-bold text-[#643B62] tabular-nums">{{ $item['tarif'] }}</span>
                                <a href="{{ route('konselor.booking') ?? '#' }}" class="font-semibold text-[#3E293F] hover:text-[#643B62] flex items-center gap-1 transition">
                                    <span>Tinjau</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State Sidebar --}}
                        <div class="py-10 text-center text-[#746B77]">
                            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto mb-2 ring-4 ring-[#EEE7F2]/40">
                                <svg class="w-6 h-6 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-[#3E293F]">Tidak Ada Booking Menunggu</p>
                            <p class="text-[11px] text-[#746B77] mt-0.5">Semua permintaan konsultasi telah ditindaklanjuti.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 pt-4 border-t border-[#DCD5DD] text-center">
                    <a href="{{ route('konselor.booking') ?? '#' }}" class="text-xs font-bold text-[#643B62] hover:text-[#3E293F] inline-flex items-center gap-1 transition">
                        <span>Lihat Semua Permintaan Booking</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection