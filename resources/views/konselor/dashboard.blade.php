@extends('layouts.konselor')

@section('konselor-content')
<div class="space-y-8 max-w-7xl mx-auto py-6">

    <!-- 1. GREETING & VERIFICATION BADGE -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#746B77] block mb-1">Selamat Datang Kembali</span>
            <h1 class="text-3xl font-serif font-bold text-[#3E293F]">Halo, {{ $greetingName ?? (auth()->user()->nama ?? 'Bu Dewi') }}.</h1>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1">Ini ringkasan sesi dan permintaan hari ini.</p>
        </div>
        <div>
            @php
                $statusVerif = $konselor->status_verifikasi ?? (auth()->user()->konselor->status_verifikasi ?? 'menunggu');
            @endphp

            @if($statusVerif === 'disetujui')
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Terverifikasi
                </span>
            @elseif($statusVerif === 'ditolak')
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Verifikasi Ditolak
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    Menunggu Verifikasi Admin
                </span>
            @endif
        </div>
    </div>

    <!-- 2. STAT CARDS (4 KARTU RINGKASAN DARI DATABASE) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $stats['sesi_hari_ini'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1">Sesi hari ini</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                📅
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $stats['booking_menunggu'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1">Booking menunggu</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                ⏰
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $stats['sesi_selesai_bulan_ini'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1">Sesi selesai bulan ini</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                ✓
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $stats['total_sesi'] ?? 0 }}</span>
                <p class="text-xs text-[#746B77] mt-1">Total sesi</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                💬
            </div>
        </div>
    </div>

    @include('konselor._sesi-chat')

    <!-- 3. MAIN GRID (KOLOM UTAMA & SIDEBAR BOOKING) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI (Span 2) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Sesi Berikutnya -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-serif font-bold text-[#3E293F]">Sesi berikutnya</h2>
                    <span class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        {{ isset($nextSesi) ? 'Pembayaran dikonfirmasi' : 'Belum ada sesi' }}
                    </span>
                </div>
                
                @if(isset($nextSesi) && $nextSesi)
                    @php
                        $nextDate = \Carbon\Carbon::parse($nextSesi->jadwal->tanggal ?? now())->locale('id');
                        $namaKlien = $nextSesi->user->nama ?? $nextSesi->user->name ?? 'Klien';
                    @endphp
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-[#DCD5DD]/60">
                        <div class="flex items-start sm:items-center space-x-4">
                            <div class="w-16 h-16 rounded-2xl bg-[#EEE7F2] border border-[#DCD5DD] flex flex-col items-center justify-center text-[#643B62] font-bold shadow-inner flex-shrink-0">
                                <span class="text-[10px] uppercase tracking-widest text-[#746B77]">{{ strtoupper($nextDate->translatedFormat('M')) }}</span>
                                <span class="text-xl font-serif">{{ $nextDate->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-serif font-bold text-[#3E293F]">{{ $namaKlien }}</h3>
                                <p class="text-xs text-[#746B77] mt-1">{{ $nextDate->translatedFormat('l, d F Y') }} • {{ substr($nextSesi->jadwal->jam_mulai ?? '', 0, 5) }}–{{ substr($nextSesi->jadwal->jam_selesai ?? '', 0, 5) }} WIB</p>
                                <p class="text-xs text-[#643B62] font-medium mt-1">💬 Sesi melalui chat • {{ $konselor->durasi_sesi ?? 60 }} menit</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-6">
                        @if($nextSesi->konsultasi)
                            <a href="{{ route('konselor.chat.show', $nextSesi->konsultasi->id) }}" class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs sm:text-sm font-semibold shadow-sm transition">
                                Masuk ke chat &rarr;
                            </a>
                        @else
                            <a href="{{ route('konselor.booking') }}" class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs sm:text-sm font-semibold shadow-sm transition">
                                Kelola booking &rarr;
                            </a>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-[#746B77] py-4">Belum ada sesi konsultasi terkonfirmasi yang akan datang.</p>
                @endif
            </div>

            <!-- Jadwal Hari Ini -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-serif font-bold text-[#3E293F]">Jadwal hari ini</h2>
                        <p class="text-xs text-[#746B77] mt-0.5">{{ now()->locale('id')->translatedFormat('l, d F Y') }} • {{ isset($jadwalHariIniList) ? $jadwalHariIniList->count() : 0 }} sesi</p>
                    </div>
                    <a href="{{ route('konselor.jadwal') ?? '#' }}" class="text-xs font-bold text-[#643B62] hover:underline flex items-center gap-1">
                        Lihat jadwal &nearr;
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($jadwalHariIniList ?? [] as $pemesanan)
                        @php
                            $namaKlien = $pemesanan->user->nama ?? $pemesanan->user->name ?? 'Klien';
                            $isNext = isset($nextSesi) && $nextSesi->id === $pemesanan->id;
                            $sesiSelesai = $pemesanan->status === 'selesai';
                        @endphp
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD]">
                            <div>
                                <span class="text-xs font-bold text-[#3E293F] block">{{ substr($pemesanan->jadwal->jam_mulai ?? '', 0, 5) }}–{{ substr($pemesanan->jadwal->jam_selesai ?? '', 0, 5) }}</span>
                                <span class="text-[11px] text-[#746B77]">WIB • {{ $konselor->durasi_sesi ?? 60 }} menit</span>
                            </div>
                            <div class="flex-1 px-6">
                                <span class="text-sm font-semibold text-[#3E293F] block">{{ $namaKlien }}</span>
                                <span class="text-[11px] text-[#746B77]">Konsultasi melalui chat</span>
                            </div>
                            <span class="px-3.5 py-1 rounded-full text-xs font-semibold {{ $sesiSelesai ? 'bg-gray-100 text-gray-700' : ($isNext ? 'bg-[#EEE7F2] text-[#643B62]' : 'bg-gray-100 text-gray-700') }}">
                                {{ $sesiSelesai ? 'Selesai' : ($isNext ? 'Berikutnya' : 'Terjadwal') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-[#746B77] py-4">Belum ada jadwal sesi untuk hari ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- ANALISIS: Performa Kamu -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-[#DCD5DD]/60">
                    <div>
                        <span class="text-[10px] font-bold text-[#746B77] uppercase tracking-widest block mb-1">ANALISIS</span>
                        <h2 class="text-xl font-serif font-bold text-[#3E293F]">Performa kamu</h2>
                        <p class="text-xs text-[#746B77] mt-0.5">Pantau pola sesi, hari tersibuk, dan penggunaan slot untuk meningkatkan kualitas pendampingan.</p>
                    </div>
                    <span class="text-xs font-semibold text-[#746B77]">6 bulan terakhir</span>
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
                                    <span class="text-[10px] {{ $bulan['is_active'] ? 'font-bold text-[#3E293F]' : 'text-[#746B77]' }}">{{ $bulan['jumlah'] }}</span>
                                    <div class="w-full {{ $bulan['is_active'] ? 'bg-[#3E293F]' : 'bg-[#DCD5DD]/70' }} rounded-t-lg" style="height: {{ $maxSesiBulanan > 0 ? max(4, round(($bulan['jumlah'] / $maxSesiBulanan) * 100)) : 4 }}%"></div>
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
                                    <span class="text-[10px] {{ $hari['is_active'] ? 'font-bold text-[#3E293F]' : 'text-[#746B77]' }}">{{ $hari['jumlah'] }}</span>
                                    <div class="w-full {{ $hari['is_active'] ? 'bg-[#3E293F]' : 'bg-[#DCD5DD]/70' }} rounded-t-lg" style="height: {{ $maxSesiHarian > 0 ? max(4, round(($hari['jumlah'] / $maxSesiHarian) * 100)) : 4 }}%"></div>
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
                                        <span>{{ $minggu['persentase'] }}%</span>
                                    </div>
                                    <div class="w-full bg-[#DCD5DD]/50 h-2.5 rounded-full overflow-hidden">
                                        <div class="bg-[#3E293F] h-full rounded-full" style="width: {{ $minggu['persentase'] }}%"></div>
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

        <!-- 4. SIDEBAR KANAN: BOOKING MENUNGGU (Span 1) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-serif font-bold text-[#3E293F]">Booking menunggu</h2>
                    <span class="w-7 h-7 rounded-full bg-[#EEE7F2] text-[#643B62] font-bold text-xs flex items-center justify-center">{{ count($bookingMenunggu ?? []) }}</span>
                </div>
                <p class="text-xs text-[#746B77] mb-6">Ada yang menantikan pendampinganmu.</p>

                <div class="space-y-4">
                    @forelse($bookingMenunggu ?? [] as $item)
                        <div class="p-4 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD] space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-[#3E293F]">{{ $item['klien'] }}</span>
                                <span class="text-[10px] text-[#746B77]">{{ $item['diajukan'] }}</span>
                            </div>
                            <div class="text-xs text-[#746B77] space-y-1">
                                <p class="flex items-center gap-1.5">📅 {{ $item['jadwal'] }}</p>
                                <p class="flex items-center gap-1.5">💬 {{ $item['layanan'] }}</p>
                            </div>
                            <div class="pt-2 flex justify-end">
                                <a href="{{ route('konselor.booking') ?? '#' }}" class="text-xs font-bold text-[#643B62] hover:underline flex items-center gap-1">
                                    Tinjau &nearr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#746B77] py-4">Belum ada booking yang menunggu.</p>
                    @endforelse
                </div>

                <div class="mt-6 pt-4 border-t border-[#DCD5DD] text-center">
                    <a href="{{ route('konselor.booking') ?? '#' }}" class="text-xs font-bold text-[#643B62] hover:underline inline-flex items-center gap-1">
                        Lihat semua booking &nearr;
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection