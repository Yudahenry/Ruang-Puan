@extends('layouts.konselor')

@section('konselor-content')
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
            <p class="text-xs text-[#746B77] mt-1">Daftar pemesanan dan jadwal sesi konsultasi dari klien Anda.</p>
        </div>
    </div>

    <!-- Statistik Ringkasan (Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-[#DCD5DD] shadow-2xs">
            <span class="text-xs font-medium text-[#746B77] block mb-1">Total Booking</span>
            <span class="text-2xl font-serif font-bold text-[#3E293F]">{{ $totalBooking ?? 0 }}</span>
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

    <!-- Daftar List Booking -->
    @if(isset($pemesanans) && $pemesanans->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-[#DCD5DD] p-6 max-w-lg mx-auto">
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-xl mb-3 shadow-inner">
                📅
            </div>
            <h3 class="text-sm font-bold text-[#3E293F] mb-1">Belum Ada Booking Masuk</h3>
            <p class="text-xs text-[#746B77]">Belum ada klien yang memesan jadwal konsultasi pada praktik Anda saat ini.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pemesanans as $item)
                <div class="bg-white rounded-3xl border border-[#DCD5DD] p-6 shadow-2xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition hover:border-[#643B62]/50">
                    
                    <!-- Kiri: Avatar Inisial, Nama Klien, Jadwal & Detail -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-serif font-bold text-lg flex-shrink-0 shadow-inner">
                            {{ substr($item->user->nama ?? 'K', 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h3 class="font-serif font-bold text-[#3E293F] text-base">
                                    {{ $item->user->nama ?? 'Klien Anonim' }}
                                </h3>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold 
                                    {{ ($item->status_pembayaran ?? $item->status) === 'lunas' ? 'bg-success-100 text-success-600' : 'bg-warning-100 text-warning-600' }}">
                                    {{ ucfirst($item->status_pembayaran ?? $item->status) }}
                                </span>
                            </div>
                            
                            <p class="text-xs text-[#746B77] mt-1">
                                @if($item->jadwal)
                                    {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->translatedFormat('l, d M Y') }} · 
                                    {{ \Carbon\Carbon::parse($item->jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jadwal->jam_selesai)->format('H:i') }} WIB
                                @else
                                    Jadwal tidak tersedia
                                @endif
                            </p>

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
    @endif

</div>
@endsection