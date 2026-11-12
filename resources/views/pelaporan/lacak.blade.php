@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-6 sm:p-10 my-8">
    
    {{-- Notifikasi Sukses Pembuatan Laporan --}}
    @if(session('success'))
        <div class="mb-8 bg-[#EEE7F2]/80 border border-[#643B62]/30 text-[#3E293F] p-6 rounded-2xl">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-[#643B62] text-white flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-serif font-bold text-[#3E293F]">Laporan Berhasil Terkirim</h2>
                    <p class="text-xs text-[#746B77] mt-1 leading-relaxed">Kode pelacakan unik telah dibuat. Simpan atau catat kode ini untuk memantau status laporan Anda:</p>
                    <div class="mt-3 inline-flex items-center gap-2 bg-white px-4 py-2 rounded-2xl border border-[#DCD5DD] font-mono text-base font-bold text-[#3E293F] shadow-2xs">
                        <span>{{ $laporan->kode_pelacakan }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Header Judul & Status --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-6 border-b border-[#DCD5DD]">
        <div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F]">Pelacakan Laporan</h1>
            <p class="text-xs sm:text-sm font-mono text-[#643B62] mt-1">Kode: {{ $laporan->kode_pelacakan }}</p>
        </div>
        <div>
            <span class="px-4 py-2 rounded-full text-xs font-bold tracking-wide shadow-2xs inline-block
                @if($laporan->status === 'selesai') bg-emerald-100 text-emerald-800
                @elseif($laporan->status === 'ditolak' || $laporan->status === 'ditutup') bg-rose-100 text-rose-800
                @else bg-amber-100 text-amber-800 @endif">
                Status: {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
            </span>
        </div>
    </div>

    {{-- Detail Informasi Grid (4 Kartu) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8 text-xs sm:text-sm">
        <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD]">
            <span class="text-[11px] font-bold text-[#746B77] uppercase tracking-widest block mb-1">Jenis Kasus</span>
            <p class="font-semibold text-[#3E293F] capitalize">{{ str_replace('_', ' ', $laporan->jenis_kasus) }}</p>
        </div>
        <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD]">
            <span class="text-[11px] font-bold text-[#746B77] uppercase tracking-widest block mb-1">Mode Laporan</span>
            <p class="font-semibold text-[#3E293F]">
                @if($laporan->anonim)
                    <span class="text-rose-600 font-semibold">🔒 Anonim (Identitas disembunyikan)</span>
                @else
                    <span class="text-emerald-700 font-semibold">👤 Bernama ({{ $laporan->user->nama ?? 'Pengguna' }})</span>
                @endif
            </p>
        </div>
        <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD]">
            <span class="text-[11px] font-bold text-[#746B77] uppercase tracking-widest block mb-1">Waktu Kejadian</span>
            <p class="font-semibold text-[#3E293F]">{{ $laporan->waktu_kejadian ? \Carbon\Carbon::parse($laporan->waktu_kejadian)->format('d M Y H:i') : 'Tidak dicatat' }}</p>
        </div>
        <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD]">
            <span class="text-[11px] font-bold text-[#746B77] uppercase tracking-widest block mb-1">Lokasi Kejadian</span>
            <p class="font-semibold text-[#3E293F]">{{ $laporan->lokasi_kejadian ?? 'Tidak dicatat' }}</p>
        </div>
    </div>

    {{-- Kronologi Kejadian --}}
    <div class="mb-8">
        <h3 class="text-xs font-bold text-[#746B77] uppercase tracking-widest mb-3">Kronologi Kejadian</h3>
        <div class="bg-[#FCFAF8] p-6 rounded-2xl border border-[#DCD5DD] text-sm text-[#3E293F] leading-relaxed whitespace-pre-line shadow-2xs">
            {{ $laporan->kronologi }}
        </div>
    </div>

    {{-- Bukti Pendukung --}}
    @if($laporan->buktiLaporans->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-xs font-bold text-[#746B77] uppercase tracking-widest mb-3">Bukti Pendukung</h3>
            <ul class="space-y-3">
                @foreach($laporan->buktiLaporans as $bukti)
                    <li class="flex items-center justify-between bg-[#FCFAF8] p-4 rounded-2xl border border-[#DCD5DD] text-xs sm:text-sm">
                        <span class="font-semibold text-[#643B62] truncate max-w-[250px] sm:max-w-md">{{ $bukti->nama_file }}</span>
                        <a href="{{ asset('storage/' . $bukti->lokasi_file) }}" target="_blank" class="px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-2xs transition">
                            Unduh / Lihat
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tanggapan & Riwayat Penanganan --}}
    <div class="mb-8">
        <h3 class="text-xs font-bold text-[#746B77] uppercase tracking-widest mb-3">Tanggapan & Riwayat Penanganan</h3>
        @if($laporan->tanggapanLaporans->isEmpty())
            <p class="text-xs sm:text-sm text-[#746B77] bg-[#FCFAF8] p-6 rounded-2xl border border-[#DCD5DD] italic">Belum ada tanggapan atau pembaruan status dari tim penanganan.</p>
        @else
            <div class="space-y-4">
                @foreach($laporan->tanggapanLaporans as $tanggapan)
                    <div class="bg-[#FCFAF8] p-6 rounded-2xl border border-[#DCD5DD] shadow-2xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs text-[#746B77] mb-2.5 pb-2 border-b border-[#DCD5DD]/50 gap-1">
                            <span>Status saat itu: <strong class="capitalize text-[#3E293F]">{{ str_replace('_', ' ', $tanggapan->status_laporan_saat_itu) }}</strong></span>
                            <span>{{ $tanggapan->created_at ? \Carbon\Carbon::parse($tanggapan->created_at)->format('d M Y H:i') : '' }}</span>
                        </div>
                        <p class="text-sm text-[#3E293F] leading-relaxed">{{ $tanggapan->isi_tanggapan }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Tombol Navigasi Kembali --}}
    <div class="flex items-center justify-between pt-6 border-t border-[#DCD5DD]">
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.laporan.index') }}" class="px-5 py-2.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-semibold transition">&larr; Kembali ke Daftar Laporan Admin</a>
            @else
                <a href="{{ route('pelaporan.riwayat') }}" class="px-5 py-2.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-semibold transition">&larr; Kembali ke Riwayat Laporan</a>
            @endif
        @else
            <a href="{{ url('/') }}" class="px-5 py-2.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-semibold transition">&larr; Beranda</a>
        @endauth
    </div>
</div>
@endsection