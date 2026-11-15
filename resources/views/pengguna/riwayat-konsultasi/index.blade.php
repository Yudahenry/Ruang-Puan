@extends('layouts.pengguna')

@section('pengguna-content')
@php
    // Menggunakan $pemesanans agar semua booking yang sudah dibuat langsung tampil
    $daftar = $pemesanans ?? collect();

    $warnaStatus = [
        'menunggu_pembayaran' => 'bg-amber-100 text-amber-800 border-amber-200',
        'menunggu_konfirmasi' => 'bg-amber-100 text-amber-800 border-amber-200',
        'pending'             => 'bg-amber-100 text-amber-800 border-amber-200',
        'terkonfirmasi'       => 'bg-sky-100 text-sky-800 border-sky-200',
        'terjadwal'           => 'bg-sky-100 text-sky-800 border-sky-200',
        'berlangsung'         => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'selesai'             => 'bg-[#EEE7F2] text-[#3E293F] border-[#DCD5DD]',
        'batal'               => 'bg-rose-100 text-rose-800 border-rose-200',
        'ditolak'             => 'bg-rose-100 text-rose-800 border-rose-200',
    ];
    $labelBayar = ['menunggu' => 'Menunggu', 'berhasil' => 'Berhasil', 'gagal' => 'Gagal'];
@endphp

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <a href="{{ route('pengguna.dashboard') }}"
       class="inline-flex items-center gap-2 text-xs font-semibold text-[#746B77] hover:text-[#3E293F] transition group">
        <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
        <span>Kembali ke Dashboard</span>
    </a>

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold font-serif text-[#3E293F]">Riwayat Konsultasi</h1>
            <p class="text-xs sm:text-sm text-[#746B77] font-light mt-1">Daftar pemesanan dan sesi konsultasi Anda.</p>
        </div>
        <a href="{{ route('konsultasi.index') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition group">
            <span>+ Jadwalkan Konsultasi</span>
            <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-[#EEE7F2]/50 border border-[#DCD5DD] rounded-2xl p-5 shadow-2xs">
            <p class="text-xs text-[#746B77]">Total Konsultasi</p>
            <p class="text-2xl font-bold font-serif text-[#3E293F] mt-1">{{ $totalKonsultasi ?? $daftar->count() }}</p>
        </div>
        <div class="bg-[#EEE7F2]/50 border border-[#DCD5DD] rounded-2xl p-5 shadow-2xs">
            <p class="text-xs text-[#746B77]">Akan Datang</p>
            <p class="text-2xl font-bold font-serif text-[#3E293F] mt-1">
                {{ $akanDatang ?? 0 }}
            </p>
        </div>
        <div class="bg-[#EEE7F2]/50 border border-[#DCD5DD] rounded-2xl p-5 shadow-2xs">
            <p class="text-xs text-[#746B77]">Selesai</p>
            <p class="text-2xl font-bold font-serif text-[#3E293F] mt-1">
                {{ $selesai ?? 0 }}
            </p>
        </div>
    </div>

    @if ($daftar->isEmpty())
        <div class="bg-white border border-[#DCD5DD] rounded-3xl shadow-sm px-6 py-14 text-center">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center text-2xl mb-4 shadow-inner">📅</div>
            <h3 class="text-lg font-bold font-serif text-[#3E293F]">Belum ada riwayat konsultasi</h3>
            <p class="text-xs text-[#746B77] font-light mt-2 max-w-sm mx-auto leading-relaxed">
                Pemesanan konsultasi Anda akan muncul di halaman ini. Mulai dengan memilih konselor dan jadwal yang sesuai.
            </p>
            <a href="{{ route('konsultasi.index') }}"
               class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition group">
                <span>Pilih konselor</span>
                <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($daftar as $p)
                @php
                    $jadwal     = $p->jadwalKonsultasi;
                    
                    // Tentukan apakah waktu konsultasi sudah lewat atau belum
                    $waktuSelesai = $jadwal ? \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_selesai) : null;
                    $sudahLewat   = $waktuSelesai ? $waktuSelesai->isPast() : false;

                    $statusRaw  = strtolower($p->konsultasi?->status_efektif ?? $p->status ?? 'menunggu');

                    // Jika jadwal sudah lewat dan belum dibatalkan, otomatis jadikan status badge 'selesai'
                    if ($sudahLewat && !in_array($statusRaw, ['batal', 'ditolak'])) {
                        $statusRaw = 'selesai';
                    }

                    $badge      = $warnaStatus[$statusRaw] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                    $labelSts   = ucwords(str_replace('_', ' ', $statusRaw));

                    $kUser      = $jadwal?->konselor?->user;
                    $nama       = $kUser->nama ?? $kUser->name ?? 'Konselor';

                    $bayar      = $p->pembayaran?->status ?? $p->status_pembayaran;
                    $noInvoice  = $p->pembayaran?->no_invoice ?? ('INV-' . str_pad($p->id, 5, '0', STR_PAD_LEFT));
                    $bisaChat   = $p->konsultasi && !in_array($statusRaw, ['batal', 'ditolak']) && $p->status === 'terkonfirmasi';
                    $belumBayar = in_array(strtolower($bayar ?? ''), ['menunggu', 'belum_bayar', 'pending', '']);
                @endphp

                <div class="bg-white border border-[#DCD5DD] rounded-3xl shadow-sm hover:shadow-md transition p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-lg flex-shrink-0 shadow-inner">
                                {{ strtoupper(mb_substr($nama, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold font-serif text-[#3E293F] text-base">{{ $nama }}</h3>
                                <p class="text-xs text-[#746B77] mt-1">
                                    @if ($jadwal)
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                                        &middot; {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                        &ndash; {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    @else
                                        Jadwal belum tersedia
                                    @endif
                                </p>
                                <p class="text-xs text-[#746B77] mt-1">
                                    Pembayaran:
                                    <span class="font-semibold text-[#3E293F]">{{ $bayar ? ($labelBayar[strtolower($bayar)] ?? ucfirst($bayar)) : 'Belum dibayar' }}</span>
                                    &middot; <span class="font-medium text-[#643B62]">{{ $noInvoice }}</span>
                                    @if ($p->total_biaya)
                                        &middot; <span class="font-semibold text-[#3E293F]">Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-3">
                            <span class="inline-flex px-3 py-1 rounded-full border text-[11px] font-semibold {{ $badge }}">
                                {{ $labelSts }}
                            </span>

                            <div class="flex flex-wrap items-center justify-end gap-2">
                                {{-- Menu / Tombol Invoice di dalam setiap booking --}}
                                <a href="{{ route('pengguna.riwayat-konsultasi.invoice', $p->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] border border-[#DCD5DD] rounded-2xl text-xs font-semibold transition">
                                    <span>🧾 Invoice</span>
                                </a>

                                {{-- Tombol Bayar jika masih menunggu pembayaran --}}
                                @if ($belumBayar && !in_array($statusRaw, ['batal', 'ditolak']))
                                    <a href="{{ route('konsultasi.tagihan', $p->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-2xl text-xs font-semibold shadow-sm transition">
                                        <span>Bayar</span>
                                    </a>
                                @endif

                                {{-- Tombol Chat bawaan jika sesi sudah terkonfirmasi --}}
                                @if ($bisaChat)
                                    <a href="{{ route('konsultasi.chat', $p->konsultasi->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition group">
                                        <span>💬 {{ $statusRaw === 'selesai' ? 'Lihat Percakapan' : 'Buka Chat' }}</span>
                                        <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</section>
@endsection