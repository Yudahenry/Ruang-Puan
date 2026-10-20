@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-cream-200">
        <div>
            <h1 class="text-2xl font-bold text-berry-900">Pelacakan Laporan</h1>
            <p class="text-sm font-mono text-berry-700 mt-1">Kode: {{ $laporan->kode_pelacakan }}</p>
        </div>
        <div>
            <span class="px-3 py-1.5 rounded-full text-xs font-bold
                @if($laporan->status === 'selesai') bg-success-100 text-success-600
                @elseif($laporan->status === 'ditolak' || $laporan->status === 'ditutup') bg-danger-100 text-danger-600
                @else bg-warning-100 text-warning-600 @endif">
                Status: {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-sm">
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Jenis Kasus</span>
            <p class="font-medium text-ink-900 capitalize mt-1">{{ str_replace('_', ' ', $laporan->jenis_kasus) }}</p>
        </div>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Mode Laporan</span>
            <p class="font-medium text-ink-900 mt-1">
                @if($laporan->anonim)
                    <span class="text-rose-600 font-semibold">🔒 Anonim (Identitas disembunyikan dari admin)</span>
                @else
                    <span class="text-success-600 font-semibold">👤 Bernama ({{ $laporan->user->nama }})</span>
                @endif
            </p>
        </div>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Waktu Kejadian</span>
            <p class="font-medium text-ink-900 mt-1">{{ $laporan->waktu_kejadian ? \Carbon\Carbon::parse($laporan->waktu_kejadian)->format('d M Y H:i') : 'Tidak dicatat' }}</p>
        </div>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Lokasi Kejadian</span>
            <p class="font-medium text-ink-900 mt-1">{{ $laporan->lokasi_kejadian ?? 'Tidak dicatat' }}</p>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-sm font-semibold text-ink-600 uppercase mb-2">Kronologi Kejadian</h3>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200 text-sm text-ink-900 leading-relaxed whitespace-pre-line">
            {{ $laporan->kronologi }}
        </div>
    </div>

    @if($laporan->buktiLaporans->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-sm font-semibold text-ink-600 uppercase mb-2">Bukti Pendukung</h3>
            <ul class="space-y-2">
                @foreach($laporan->buktiLaporans as $bukti)
                    <li class="flex items-center justify-between bg-cream-50 p-3 rounded-xl border border-cream-200 text-sm">
                        <span class="font-medium text-berry-700">{{ $bukti->nama_file }}</span>
                        <a href="{{ asset('storage/' . $bukti->lokasi_file) }}" target="_blank" class="px-3 py-1 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-medium transition">
                            Unduh / Lihat
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-8">
        <h3 class="text-sm font-semibold text-ink-600 uppercase mb-3">Tanggapan & Riwayat Penanganan</h3>
        @if($laporan->tanggapanLaporans->isEmpty())
            <p class="text-sm text-ink-600 bg-cream-50 p-4 rounded-xl border border-cream-200">Belum ada tanggapan atau pembaruan status dari admin.</p>
        @else
            <div class="space-y-4">
                @foreach($laporan->tanggapanLaporans as $tanggapan)
                    <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
                        <div class="flex items-center justify-between text-xs text-ink-600 mb-2">
                            <span>Status saat itu: <strong class="capitalize">{{ str_replace('_', ' ', $tanggapan->status_laporan_saat_itu) }}</strong></span>
                            <span>{{ $tanggapan->created_at ? \Carbon\Carbon::parse($tanggapan->created_at)->format('d M Y H:i') : '' }}</span>
                        </div>
                        <p class="text-sm text-ink-900 leading-relaxed">{{ $tanggapan->isi_tanggapan }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="flex items-center justify-between pt-4 border-t border-cream-200">
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-cream-100 hover:bg-cream-200 text-ink-900 rounded-lg text-sm font-medium transition">&larr; Kembali ke Daftar Laporan Admin</a>
            @else
                <a href="{{ route('pelaporan.riwayat') }}" class="px-4 py-2 bg-cream-100 hover:bg-cream-200 text-ink-900 rounded-lg text-sm font-medium transition">&larr; Kembali ke Riwayat Laporan</a>
            @endif
        @else
            <a href="{{ url('/') }}" class="px-4 py-2 bg-cream-100 hover:bg-cream-200 text-ink-900 rounded-lg text-sm font-medium transition">&larr; Beranda</a>
        @endauth
    </div>
</div>
@endsection
