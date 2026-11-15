@extends('layouts.konselor')

@section('konselor-content')
<div class="space-y-8 max-w-7xl mx-auto py-6">

    {{-- 1. HEADER & TOMBOL KEMBALI --}}
    <div class="space-y-3">
        <a href="{{ route('konselor.dashboard') }}" 
           class="inline-flex items-center gap-2 text-xs font-semibold text-[#643B62] hover:text-[#3E293F] transition group">
            <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
            <span>Kembali ke Beranda Dashboard</span>
        </a>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F]">Riwayat Sesi Konsultasi</h1>
                <p class="text-xs sm:text-sm text-[#746B77] mt-1">Daftar seluruh sesi konsultasi yang terjadwal, sedang berlangsung, maupun telah selesai.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#EEE7F2] text-[#643B62] border border-[#DCD5DD]">
                    🛡️ Privasi Klien Terlindungi (Alias)
                </span>
            </div>
        </div>
    </div>

    {{-- 2. 4 KARTU RINGKASAN --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Card 1: Total Sesi --}}
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $ringkasan['total'] }}</span>
                <p class="text-xs text-[#746B77] mt-1">Total sesi</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-xl shadow-inner">
                📋
            </div>
        </div>

        {{-- Card 2: Akan Datang --}}
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $ringkasan['akan_datang'] }}</span>
                <p class="text-xs text-[#746B77] mt-1">Sesi akan datang</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-xl shadow-inner">
                📅
            </div>
        </div>

        {{-- Card 3: Selesai --}}
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $ringkasan['selesai'] }}</span>
                <p class="text-xs text-[#746B77] mt-1">Sesi selesai</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-xl shadow-inner">
                ✓
            </div>
        </div>

        {{-- Card 4: Total Pesan --}}
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">{{ $ringkasan['total_pesan'] }}</span>
                <p class="text-xs text-[#746B77] mt-1">Total pesan terkirim</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-xl shadow-inner">
                💬
            </div>
        </div>
    </div>

    {{-- 3. FILTER STATUS & PENCARIAN ALIAS --}}
    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#DCD5DD] shadow-sm">
        <form method="GET" action="{{ route('konselor.riwayat') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            {{-- Search Bar --}}
            <div class="relative flex-1">
                <input type="text" 
                       name="q" 
                       value="{{ $q }}" 
                       placeholder="Cari berdasarkan alias klien..."
                       class="w-full pl-10 pr-4 py-2.5 bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl text-xs text-[#3E293F] placeholder-[#746B77] focus:outline-none focus:border-[#643B62] focus:ring-1 focus:ring-[#643B62] transition">
                <div class="absolute left-3.5 top-3 text-[#746B77] pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Status Filter Tabs / Buttons --}}
            <div class="flex items-center flex-wrap gap-1.5">
                @php
                    $statusOptions = [
                        ''            => 'Semua',
                        'berlangsung' => 'Berlangsung',
                        'terjadwal'   => 'Terjadwal',
                        'selesai'     => 'Selesai',
                        'batal'       => 'Batal',
                    ];
                @endphp
                @foreach($statusOptions as $val => $label)
                    <button type="submit" 
                            name="status" 
                            value="{{ $val }}"
                            class="px-3.5 py-2 rounded-full text-xs font-semibold transition {{ ($status === $val || ($val === '' && !$status)) ? 'bg-[#643B62] text-white shadow-xs' : 'bg-[#EEE7F2]/70 text-[#746B77] hover:text-[#3E293F] hover:bg-[#EEE7F2]' }}">
                        {{ $label }}
                    </button>
                @endforeach

                @if($q || $status)
                    <a href="{{ route('konselor.riwayat') }}" 
                       class="px-3 py-2 text-xs font-semibold text-red-600 hover:text-red-700 hover:underline transition">
                        Reset Filter
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- 4. DAFTAR KARTU SESI KONSULTASI --}}
    @if($konsultasis->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-[#DCD5DD] shadow-sm space-y-4">
            <div class="w-16 h-16 rounded-3xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-2xl shadow-inner">
                📭
            </div>
            <div class="max-w-md mx-auto">
                <h3 class="text-base font-serif font-bold text-[#3E293F]">Tidak Ada Sesi Konsultasi</h3>
                <p class="text-xs text-[#746B77] mt-1">
                    @if($q || $status)
                        Tidak ditemukan sesi yang sesuai dengan filter atau kata kunci pencarian Anda.
                    @else
                        Belum ada sesi konsultasi yang terdaftar di sistem.
                    @endif
                </p>
            </div>
            @if($q || $status)
                <div>
                    <a href="{{ route('konselor.riwayat') }}" class="inline-flex items-center px-4 py-2 bg-[#643B62] text-white rounded-xl text-xs font-semibold hover:bg-[#3E293F] transition">
                        Lihat Semua Sesi
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="space-y-4">
            @foreach($konsultasis as $sesi)
                @php
                    $clientUser = $sesi->pemesanan?->user;
                    // Privasi ketat: hanya tampilkan alias, jika kosong Klien #ID
                    $clientAlias = !empty($clientUser?->alias) ? $clientUser->alias : ('Klien #' . ($clientUser?->id ?? $sesi->id));
                    $jadwal = $sesi->pemesanan?->jadwalKonsultasi;
                    $statusEfektif = $sesi->status_efektif;
                    $isConfirmed = $sesi->pemesanan?->status === 'terkonfirmasi';
                @endphp

                <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm hover:border-[#643B62]/40 transition space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#DCD5DD]/50">
                        {{-- Klien & Avatar --}}
                        <div class="flex items-start sm:items-center space-x-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-base shadow-inner flex-shrink-0">
                                {{ strtoupper(substr($clientAlias, 0, 1)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-serif font-bold text-[#3E293F]">{{ $clientAlias }}</h3>
                                    <span class="text-[10px] text-[#746B77] bg-[#FCFAF8] px-2 py-0.5 rounded-md border border-[#DCD5DD]">
                                        ID Sesi #{{ $sesi->id }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#746B77] mt-0.5">
                                    💬 Konsultasi Chat · {{ $sesi->pesans_count }} pesan percakapan
                                </p>
                            </div>
                        </div>

                        {{-- Badges: Status Efektif & Pembayaran --}}
                        <div class="flex items-center flex-wrap gap-2">
                            {{-- Status Efektif Badge --}}
                            @if($statusEfektif === 'berlangsung')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-300 animate-pulse">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                    Sedang Berlangsung
                                </span>
                            @elseif($statusEfektif === 'selesai')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    ✓ Selesai
                                </span>
                            @elseif($statusEfektif === 'batal')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                    ✕ Dibatalkan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                    ⏰ Terjadwal
                                </span>
                            @endif

                            {{-- Status Pembayaran Badge (Tanpa nominal pembayaran!) --}}
                            @if($isConfirmed || $sesi->pemesanan?->status_pembayaran === 'lunas')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Pembayaran Terkonfirmasi
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ ucfirst(str_replace('_', ' ', $sesi->pemesanan?->status ?? 'Menunggu')) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Informasi Waktu & Tombol Aksi --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-1">
                        <div class="flex items-center space-x-2 text-xs text-[#746B77]">
                            <svg class="w-4 h-4 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>
                                {{ $jadwal ? \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') : '-' }} ·
                                {{ $jadwal ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') . '–' . \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') . ' WIB' : '-' }}
                            </span>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div>
                            @if($statusEfektif === 'berlangsung' && $isConfirmed)
                                <a href="{{ route('konsultasi.chat', $sesi->id) }}" 
                                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-xs transition">
                                    <span>Masuk Chat</span>
                                    <span>&rarr;</span>
                                </a>
                            @elseif($statusEfektif === 'selesai')
                                <a href="{{ route('konsultasi.chat', $sesi->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-[#FCFAF8] hover:bg-[#EEE7F2] text-[#3E293F] border border-[#DCD5DD] rounded-2xl text-xs font-semibold transition">
                                    <span>Lihat Percakapan</span>
                                </a>
                            @elseif($statusEfektif === 'terjadwal')
                                <a href="{{ route('konsultasi.chat', $sesi->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#746B77] hover:text-[#3E293F] border border-[#DCD5DD] rounded-2xl text-xs font-semibold transition">
                                    <span>Belum dimulai</span>
                                </a>
                            @else
                                <a href="{{ route('konsultasi.chat', $sesi->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-[#FCFAF8] hover:bg-[#EEE7F2] text-[#746B77] border border-[#DCD5DD] rounded-2xl text-xs font-semibold transition">
                                    <span>Detail Sesi</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
