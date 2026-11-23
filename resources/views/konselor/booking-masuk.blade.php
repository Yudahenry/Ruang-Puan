@extends('layouts.konselor')

@section('konselor-content')
@php
    $daftarBooking = isset($pemesanans) ? collect($pemesanans) : collect();

    $kelompokSesi = $daftarBooking->groupBy(function ($item) {
        $jadwal = $item->jadwal ?? $item->jadwalKonsultasi ?? null;
        if (!$jadwal) {
            return 'tanpa-jadwal';
        }

        $tgl = \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d');
        $mulai = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
        $selesai = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');

        return $tgl . '|' . $mulai . '|' . $selesai;
    })->sortBy(function ($items, $key) {
        if ($key === 'tanpa-jadwal') {
            return '9999-12-31|99:99|99:99';
        }
        return $key;
    });
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header Halaman -->
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('konselor.dashboard') }}" class="text-xs font-semibold text-[#643B62] hover:underline mb-1 inline-block">
                &larr; Kembali ke Dashboard
            </a>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] tracking-tight">
                Booking Masuk
            </h1>
            <p class="text-xs text-[#746B77] mt-1">Daftar pemesanan dan jadwal sesi konsultasi dari klien Anda, dikelompokkan per slot waktu.</p>
        </div>
    </div>

    <!-- Statistik Ringkasan (Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-[#DCD5DD] shadow-2xs">
            <span class="text-xs font-medium text-[#746B77] block mb-1">Total Booking</span>
            <span class="text-2xl font-serif font-bold text-[#3E293F]">{{ $totalBooking ?? $daftarBooking->count() }}</span>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#DCD5DD] shadow-2xs">
            <span class="text-xs font-medium text-[#746B77] block mb-1">Pembayaran Lunas</span>
            <span class="text-2xl font-serif font-bold text-success-600">{{ $lunas ?? 0 }}</span>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#DCD5DD] shadow-2xs">
            <span class="text-xs font-medium text-[#746B77] block mb-1">Menunggu Pembayaran</span>
            <span class="text-2xl font-serif font-bold text-warning-600">{{ $pending ?? 0 }}</span>
        </div>
    </div>

    <!-- Daftar Booking Dikelompokkan Per Tanggal & Jam Sesi -->
    @if($daftarBooking->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-[#DCD5DD] p-6 max-w-lg mx-auto">
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-xl mb-3 shadow-inner">
                📅
            </div>
            <h3 class="text-sm font-bold text-[#3E293F] mb-1">Belum Ada Booking Masuk</h3>
            <p class="text-xs text-[#746B77]">Belum ada klien yang memesan jadwal konsultasi pada praktik Anda saat ini.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($kelompokSesi as $kunciSesi => $itemsSesi)
                @php
                    $jadwalPertama = $itemsSesi->first()->jadwal ?? $itemsSesi->first()->jadwalKonsultasi ?? null;
                    $labelSesi = $jadwalPertama
                        ? \Carbon\Carbon::parse($jadwalPertama->tanggal)->translatedFormat('l, d M Y') . ' · ' .
                          \Carbon\Carbon::parse($jadwalPertama->jam_mulai)->format('H:i') . ' - ' .
                          \Carbon\Carbon::parse($jadwalPertama->jam_selesai)->format('H:i') . ' WIB'
                        : 'Jadwal tidak tersedia';
                @endphp

                <div class="bg-white rounded-3xl border border-[#DCD5DD] shadow-2xs overflow-hidden">
                    <!-- Header Slot Tanggal & Jam Sesi -->
                    <div class="px-6 py-4 bg-[#EEE7F2]/60 border-b border-[#DCD5DD] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#643B62]"></span>
                            <h2 class="font-serif font-bold text-[#3E293F] text-sm sm:text-base">
                                {{ $labelSesi }}
                            </h2>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-[#DCD5DD] text-[11px] font-semibold text-[#643B62] w-fit">
                            {{ $itemsSesi->count() }} pemesan di sesi ini
                        </span>
                    </div>

                    <!-- Daftar Klien yang Booking pada Slot Sesi Ini -->
                    <div class="divide-y divide-[#DCD5DD]/60">
                        @foreach($itemsSesi as $item)
                            @php
                                $namaKlien = $item->user->nama ?? $item->user->name ?? $item->user->email ?? 'Klien Anonim';
                                $statusBayar = strtolower((string) ($item->status_pembayaran ?? $item->status ?? 'pending'));
                                $isLunas = $statusBayar === 'lunas';
                            @endphp

                            <div class="p-5 sm:p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition hover:bg-[#FCFAF8]">
                                <!-- Kiri: Avatar Inisial, Nama/Email Klien & Detail Pembayaran -->
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-serif font-bold text-base flex-shrink-0 shadow-inner">
                                        {{ strtoupper(mb_substr($namaKlien, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2.5 flex-wrap">
                                            <h3 class="font-serif font-bold text-[#3E293F] text-sm sm:text-base">
                                                {{ $namaKlien }}
                                            </h3>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $isLunas ? 'bg-success-100 text-success-600' : 'bg-warning-100 text-warning-600' }}">
                                                {{ ucfirst($item->status_pembayaran ?? $item->status) }}
                                            </span>
                                        </div>

                                        <p class="text-[11px] text-[#746B77] mt-1">
                                            Pembayaran: <span class="font-semibold text-[#3E293F]">{{ ucfirst($item->status_pembayaran ?? 'Pending') }}</span>
                                            · INV-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                            · <strong class="text-[#643B62]">Rp {{ number_format($item->total_biaya ?? 0, 0, ',', '.') }}</strong>
                                        </p>
                                    </div>
                                </div>

                                <!-- Kanan: Tombol Cek Invoice -->
                                <div class="flex items-center gap-2 w-full md:w-auto justify-end pt-3 md:pt-0 border-t md:border-t-0 border-[#DCD5DD]/50">
                                    <a href="{{ route('konsultasi.tagihan', $item->id) }}"
                                       class="px-4 py-2 bg-[#EEE7F2]/60 hover:bg-[#EEE7F2] text-[#643B62] rounded-xl text-xs font-semibold transition inline-flex items-center gap-1.5 shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Cek Invoice
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection