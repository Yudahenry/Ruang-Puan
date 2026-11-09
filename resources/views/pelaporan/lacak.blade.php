@extends('layouts.pengguna')

@section('pengguna-content')
@php
    $langkah  = \App\Models\Laporan::LANGKAH;
    $idx      = array_search($laporan->status, $langkah, true);
    $ditutup  = $laporan->status === 'ditutup';
    $tanggapans = $laporan->tanggapanLaporans;
@endphp

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <a href="{{ route('pelaporan.riwayat') }}"
       class="inline-flex items-center gap-2 text-xs font-semibold text-sage-700 hover:text-sage-900 transition group">
        <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
        <span>Kembali ke Riwayat Laporan</span>
    </a>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-4 text-xs leading-relaxed">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header kode --}}
    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <p class="text-xs text-sage-600">Kode Pelacakan</p>
                <div class="flex items-center gap-3 mt-1">
                    <h1 id="kode" class="text-2xl font-bold font-mono text-sage-900">{{ $laporan->kode_pelacakan }}</h1>
                    <button type="button" id="salin"
                            class="px-3 py-1 text-[11px] font-semibold bg-sage-100 hover:bg-sage-200 border border-sage-200 rounded-lg text-sage-900 transition">
                        Salin
                    </button>
                </div>
                <p class="text-xs text-sage-600 mt-2">
                    {{ $laporan->jenisKasusLabel() }} &middot; Dikirim {{ $laporan->created_at?->translatedFormat('d F Y, H:i') }}
                </p>
            </div>
            @include('pelaporan._badge', ['status' => $laporan->status])
        </div>

        {{-- Stepper --}}
        @if ($ditutup)
            <div class="mt-6 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs text-gray-700">
                Laporan ini telah <strong>ditutup</strong>. Lihat tanggapan di bawah untuk keterangannya.
            </div>
        @else
            <ol class="mt-6 grid grid-cols-5 gap-2">
                @foreach ($langkah as $i => $s)
                    @php
                        $sudah   = $idx !== false && $i <= $idx;
                        $sekarang = $idx !== false && $i === $idx;
                    @endphp
                    <li class="text-center">
                        <div class="mx-auto w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold border-2
                            {{ $sudah ? 'bg-sage-700 text-white border-sage-700' : 'bg-white text-sage-600 border-sage-200' }}
                            {{ $sekarang ? 'ring-4 ring-sage-200' : '' }}">
                            {{ $sudah ? '✓' : $i + 1 }}
                        </div>
                        <p class="mt-2 text-[10px] sm:text-[11px] leading-tight {{ $sudah ? 'font-semibold text-sage-900' : 'text-sage-600' }}">
                            {{ \App\Models\Laporan::labelStatus($s) }}
                        </p>
                    </li>
                @endforeach
            </ol>
        @endif
    </div>

    {{-- Detail laporan --}}
    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm p-6 space-y-5">
        <h2 class="text-lg font-bold font-fraunces text-sage-900">Detail Laporan</h2>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <dt class="text-sage-600">Mode pelaporan</dt>
                <dd class="font-semibold text-sage-900 mt-0.5">{{ $laporan->anonim ? 'Anonim' : 'Dengan nama' }}</dd>
            </div>
            <div>
                <dt class="text-sage-600">Waktu kejadian</dt>
                <dd class="font-semibold text-sage-900 mt-0.5">
                    {{ $laporan->waktu_kejadian?->translatedFormat('d F Y, H:i') ?? '-' }}
                </dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-sage-600">Lokasi kejadian</dt>
                <dd class="font-semibold text-sage-900 mt-0.5">{{ $laporan->lokasi_kejadian ?: '-' }}</dd>
            </div>
        </dl>

        <div>
            <p class="text-xs text-sage-600 mb-1">Kronologi</p>
            <p class="text-sm text-sage-900 leading-relaxed whitespace-pre-line">{{ $laporan->kronologi }}</p>
        </div>

        @if ($laporan->anonim)
            <p class="text-[11px] text-sage-600 bg-sage-100/60 border border-sage-200 rounded-xl px-4 py-3 leading-relaxed">
                Laporan ini dikirim secara anonim. Identitas Anda tidak ditampilkan kepada admin. Laporan tetap tertaut ke akun Anda agar Anda bisa memantau statusnya.
            </p>
        @endif
    </div>

    {{-- Bukti --}}
    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-bold font-fraunces text-sage-900 mb-3">Bukti Terlampir</h2>
        @forelse ($laporan->buktiLaporans as $b)
            <div class="flex items-center justify-between gap-3 py-3 {{ !$loop->last ? 'border-b border-sage-200' : '' }}">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-sage-900 truncate">{{ $b->nama_file }}</p>
                    <p class="text-[11px] text-sage-600">{{ number_format($b->ukuran_file / 1024, 1) }} KB &middot; {{ $b->tipe_file }}</p>
                </div>
                <a href="{{ route('pelaporan.bukti', $b->id) }}"
                   class="flex-shrink-0 px-3 py-1.5 bg-sage-100 hover:bg-sage-200 border border-sage-200 rounded-lg text-xs font-semibold text-sage-900 transition">
                    Unduh
                </a>
            </div>
        @empty
            <p class="text-xs text-sage-600 font-light">Tidak ada bukti yang dilampirkan.</p>
        @endforelse
    </div>

    {{-- Timeline --}}
    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-bold font-fraunces text-sage-900 mb-4">Perkembangan dan Tanggapan</h2>

        <ol class="relative border-l-2 border-sage-200 ml-2 space-y-6">
            <li class="ml-5">
                <span class="absolute -left-[9px] w-4 h-4 rounded-full bg-sage-700 border-2 border-white"></span>
                <p class="text-sm font-semibold text-sage-900">Laporan diterima</p>
                <p class="text-[11px] text-sage-600">{{ $laporan->created_at?->translatedFormat('d F Y, H:i') }}</p>
                <p class="text-xs text-sage-600 mt-1">Laporan Anda sudah masuk ke sistem dan menunggu verifikasi.</p>
            </li>

            @foreach ($tanggapans as $t)
                <li class="ml-5">
                    <span class="absolute -left-[9px] w-4 h-4 rounded-full bg-sage-700 border-2 border-white"></span>
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="text-sm font-semibold text-sage-900">Tim Ruang Puan</p>
                        @include('pelaporan._badge', ['status' => $t->status_laporan_saat_itu])
                    </div>
                    <p class="text-[11px] text-sage-600">{{ $t->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}</p>
                    <p class="text-sm text-sage-900 mt-1 leading-relaxed whitespace-pre-line">{{ $t->isi_tanggapan }}</p>
                </li>
            @endforeach
        </ol>

        @if ($tanggapans->isEmpty())
            <p class="text-xs text-sage-600 font-light mt-5">Belum ada tanggapan dari admin. Status akan diperbarui di halaman ini.</p>
        @endif
    </div>

</section>

<script>
    document.getElementById('salin')?.addEventListener('click', function () {
        const kode = document.getElementById('kode').textContent.trim();
        navigator.clipboard.writeText(kode).then(() => {
            this.textContent = 'Tersalin ✓';
            setTimeout(() => this.textContent = 'Salin', 1500);
        });
    });
</script>
@endsection
