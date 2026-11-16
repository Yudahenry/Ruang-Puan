@extends('layouts.pengguna')

@section('pengguna-content')
@php
    $jadwal     = $pemesanan->jadwalKonsultasi;
    $konselor   = $jadwal?->konselor;
    $kUser      = $konselor?->user;
    $namaKons   = $kUser->nama ?? $kUser->name ?? 'Konselor Ruang Puan';

    $pUser      = $pemesanan->user ?? Auth::user();
    $namaUser   = $pUser->nama ?? $pUser->name ?? $pUser->email;

    $pembayaran = $pemesanan->pembayaran;
    $noInvoice  = $pembayaran?->no_invoice ?? ('INV-' . str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT));
    $statusBayar = strtolower($pembayaran?->status ?? $pemesanan->status_pembayaran ?? 'menunggu');
    $metode     = $pembayaran?->metode ?? $pemesanan->metode_pembayaran ?? 'Transfer / Virtual Account';
    $totalBiaya = $pembayaran?->jumlah ?? $pemesanan->total_biaya ?? 0;

    $isLunas    = in_array($statusBayar, ['berhasil', 'lunas', 'paid']);
@endphp

<style>
    @media print {
        nav, header, footer, .no-print { display: none !important; }
        body { background: #ffffff !important; }
        .print-card { box-shadow: none !important; border: 1px solid #DCD5DD !important; }
    }
</style>

<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Navigasi Atas & Tombol Cetak --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 no-print">
        <a href="{{ route('pengguna.riwayat-konsultasi') }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-[#746B77] hover:text-[#3E293F] transition group">
            <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
            <span>Kembali ke Riwayat Konsultasi</span>
        </a>

        <div class="flex items-center gap-2">
            @if (!$isLunas && !in_array(strtolower($pemesanan->status ?? ''), ['batal', 'ditolak']))
                <a href="{{ route('konsultasi.tagihan', $pemesanan->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-2xl text-xs font-semibold shadow-sm transition">
                    <span>Lanjutkan Pembayaran</span>
                </a>
            @endif
            <button type="button" onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition cursor-pointer">
                <span>🖨️ Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    {{-- Kartu Utama Invoice --}}
    <div class="bg-white border border-[#DCD5DD] rounded-3xl shadow-sm p-6 sm:p-10 print-card space-y-8">

        {{-- Header Invoice --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 border-b border-[#DCD5DD] pb-6">
            <div>
                <span class="inline-block px-3 py-1 rounded-full bg-[#EEE7F2] text-[#643B62] text-[11px] font-semibold mb-2">
                    INVOICE PEMESANAN
                </span>
                <h1 class="text-2xl font-bold font-serif text-[#3E293F]">Ruang Puan</h1>
                <p class="text-xs text-[#746B77] mt-0.5">Ruang untuk didengar &middot; Layanan Konsultasi</p>
            </div>

            <div class="sm:text-right">
                <p class="text-xs text-[#746B77]">Nomor Invoice</p>
                <p class="text-lg font-bold font-serif text-[#3E293F]">{{ $noInvoice }}</p>
                <p class="text-xs text-[#746B77] mt-1">
                    Tanggal Pemesanan: {{ $pemesanan->created_at?->translatedFormat('d F Y, H:i') }} WIB
                </p>
                <div class="mt-2">
                    @if ($isLunas)
                        <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-[11px] font-semibold">
                            LUNAS
                        </span>
                    @elseif ($statusBayar === 'gagal')
                        <span class="inline-flex px-3 py-1 rounded-full bg-rose-100 text-rose-800 border border-rose-200 text-[11px] font-semibold">
                            PEMBAYARAN GAGAL
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-[11px] font-semibold">
                            MENUNGGU PEMBAYARAN
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Informasi Pemesan & Konselor --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <div class="bg-[#EEE7F2]/40 border border-[#DCD5DD] rounded-2xl p-4 space-y-1">
                <p class="text-[11px] uppercase tracking-wider text-[#746B77] font-semibold">Ditagihkan Kepada</p>
                <p class="text-sm font-bold text-[#3E293F] pt-1">{{ $namaUser }}</p>
                <p class="text-[#746B77]">{{ $pUser->email }}</p>
            </div>

            <div class="bg-[#EEE7F2]/40 border border-[#DCD5DD] rounded-2xl p-4 space-y-1">
                <p class="text-[11px] uppercase tracking-wider text-[#746B77] font-semibold">Detail Konselor</p>
                <p class="text-sm font-bold text-[#3E293F] pt-1">{{ $namaKons }}</p>
                <p class="text-[#746B77]">Metode Pembayaran: <span class="font-semibold text-[#3E293F] capitalize">{{ $metode }}</span></p>
            </div>
        </div>

        {{-- Tabel Rincian Sesi --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#DCD5DD] text-[11px] uppercase tracking-wider text-[#746B77]">
                        <th class="py-3 font-semibold">Deskripsi Layanan</th>
                        <th class="py-3 font-semibold">Jadwal Konsultasi</th>
                        <th class="py-3 font-semibold text-right">Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD5DD]/60 text-xs">
                    <tr>
                        <td class="py-4 pr-4">
                            <p class="font-bold text-[#3E293F]">Sesi Konsultasi Privat</p>
                            <p class="text-[#746B77] mt-0.5">Konselor: {{ $namaKons }}</p>
                        </td>
                        <td class="py-4 pr-4 text-[#3E293F]">
                            @if ($jadwal)
                                <p class="font-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</p>
                                <p class="text-[#746B77] mt-0.5">
                                    Pukul {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} &ndash; {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                </p>
                            @else
                                <span class="text-[#746B77]">Jadwal menyesuaikan</span>
                            @endif
                        </td>
                        <td class="py-4 text-right font-bold text-[#3E293F]">
                            Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Ringkasan Total --}}
        <div class="border-t border-[#DCD5DD] pt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-xs text-[#746B77]">
                Status Pemesanan:
                <span class="font-semibold text-[#3E293F] capitalize">{{ str_replace('_', ' ', $pemesanan->status ?? '-') }}</span>
            </p>
            <div class="sm:text-right">
                <p class="text-xs text-[#746B77]">Total Pembayaran</p>
                <p class="text-2xl font-bold font-serif text-[#643B62]">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div>
</section>
@endsection