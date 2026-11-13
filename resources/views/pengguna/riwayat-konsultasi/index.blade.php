@extends('layouts.pengguna')

@section('pengguna-content')
@php
    $daftar = $konsultasis ?? collect();

    $warnaStatus = [
        'terjadwal'   => 'bg-sky-100 text-sky-800 border-sky-200',
        'berlangsung' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'selesai'     => 'bg-[#EEE7F2] text-[#3E293F] border-[#DCD5DD]',
        'batal'       => 'bg-rose-100 text-rose-800 border-rose-200',
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
            <p class="text-2xl font-bold font-serif text-[#3E293F] mt-1">{{ $daftar->count() }}</p>
        </div>
        <div class="bg-[#EEE7F2]/50 border border-[#DCD5DD] rounded-2xl p-5 shadow-2xs">
            <p class="text-xs text-[#746B77]">Akan Datang</p>
            <p class="text-2xl font-bold font-serif text-[#3E293F] mt-1">
                {{ $daftar->filter(fn ($k) => in_array($k->status_efektif, ['terjadwal', 'berlangsung']))->count() }}
            </p>
        </div>
        <div class="bg-[#EEE7F2]/50 border border-[#DCD5DD] rounded-2xl p-5 shadow-2xs">
            <p class="text-xs text-[#746B77]">Selesai</p>
            <p class="text-2xl font-bold font-serif text-[#3E293F] mt-1">
                {{ $daftar->filter(fn ($k) => $k->status_efektif === 'selesai')->count() }}
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
            @foreach ($daftar as $k)
                @php
                    $status   = $k->status_efektif;
                    $badge    = $warnaStatus[$status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                    $jadwal   = $k->pemesanan?->jadwalKonsultasi;
                    $kUser    = $jadwal?->konselor?->user;
                    $nama     = $kUser->nama ?? $kUser->name ?? 'Konselor';
                    $bayar    = $k->pemesanan?->pembayaran?->status;
                    $bisaChat = $status !== 'batal' && $k->pemesanan?->status === 'terkonfirmasi';
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
                                    <span class="font-semibold text-[#3E293F]">{{ $bayar ? ($labelBayar[$bayar] ?? ucfirst($bayar)) : 'Belum dibayar' }}</span>
                                    @if ($k->pemesanan?->pembayaran)
                                        &middot; {{ $k->pemesanan->pembayaran->no_invoice }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-3">
                            <span class="inline-flex px-3 py-1 rounded-full border text-[11px] font-semibold {{ $badge }}">
                                {{ ucfirst($status) }}
                            </span>

                            @if ($bisaChat)
                                <a href="{{ route('konsultasi.chat', $k->id) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition group">
                                    <span>💬 {{ $status === 'selesai' ? 'Lihat Percakapan' : 'Buka Chat' }}</span>
                                    <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</section>
@endsection