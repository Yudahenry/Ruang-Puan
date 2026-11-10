@extends('layouts.pengguna')

@section('pengguna-content')
@php
    $langkah    = \App\Models\Laporan::LANGKAH;
    $idx        = array_search($laporan->status, $langkah, true);
    $ditutup    = $laporan->status === 'ditutup';
    $tanggapans = $laporan->tanggapanLaporans;

    $titik = [
        'diterima'              => 'bg-sky-500',
        'diverifikasi'          => 'bg-indigo-500',
        'diproses'              => 'bg-amber-500',
        'diteruskan_ke_lembaga' => 'bg-violet-500',
        'selesai'               => 'bg-emerald-500',
        'ditutup'               => 'bg-gray-500',
    ];

    $ikonLangkah = ['📥', '🔍', '⚙️', '🏛️', '✅'];

    $ikonFile = function ($tipe) {
        $tipe = strtolower((string) $tipe);
        if (str_contains($tipe, 'image'))  return '🖼️';
        if (str_contains($tipe, 'pdf'))    return '📄';
        if (str_contains($tipe, 'audio'))  return '🎧';
        if (str_contains($tipe, 'video'))  return '🎬';
        return '📎';
    };
@endphp

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <a href="{{ route('pelaporan.riwayat') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-sage-700 hover:bg-sage-800 text-white rounded-full text-xs font-semibold shadow-sm transition group">
        <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
        <span>Kembali ke Riwayat Laporan</span>
    </a>

    @if (session('success'))
        <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-4 text-xs leading-relaxed">
            <span class="text-base">🎉</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Banner kode pelacakan + stepper --}}
    <div class="relative overflow-hidden bg-sage-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg">
        <div class="absolute -right-10 -bottom-12 w-56 h-56 bg-sage-600/40 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <p class="text-[11px] tracking-widest uppercase text-sage-100/80">Kode Pelacakan</p>
                    <div class="flex flex-wrap items-center gap-3 mt-1">
                        <h1 id="kode" class="text-3xl font-bold font-mono">{{ $laporan->kode_pelacakan }}</h1>
                        <button type="button" id="salin"
                                class="px-3 py-1.5 text-[11px] font-semibold bg-white/10 hover:bg-white/20 border border-white/30 rounded-lg text-white transition">
                            Salin
                        </button>
                    </div>
                    <p class="text-xs text-sage-100/80 mt-2">
                        {{ $laporan->jenisKasusLabel() }} &middot; Dikirim {{ $laporan->created_at?->translatedFormat('d F Y, H:i') }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    @include('pelaporan._badge', ['status' => $laporan->status])
                </div>
            </div>

            {{-- Stepper --}}
            @if ($ditutup)
                <div class="mt-6 bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-xs text-white">
                    Laporan ini telah <strong>ditutup</strong>. Lihat tanggapan di bawah untuk keterangannya.
                </div>
            @else
                <ol class="mt-8 grid grid-cols-5">
                    @foreach ($langkah as $i => $s)
                        @php
                            $sudah    = $idx !== false && $i <= $idx;
                            $sekarang = $idx !== false && $i === $idx;
                            $garisKiri  = $idx !== false && $i <= $idx;
                            $garisKanan = $idx !== false && $i < $idx;
                        @endphp
                        <li class="relative text-center">
                            {{-- garis penghubung --}}
                            @if (!$loop->first)
                                <span class="absolute top-5 right-1/2 w-1/2 h-0.5 {{ $garisKiri ? 'bg-white' : 'bg-white/25' }}"></span>
                            @endif
                            @if (!$loop->last)
                                <span class="absolute top-5 left-1/2 w-1/2 h-0.5 {{ $garisKanan ? 'bg-white' : 'bg-white/25' }}"></span>
                            @endif

                            <div class="relative mx-auto w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2
                                {{ $sudah ? 'bg-white text-sage-800 border-white' : 'bg-sage-700 text-white/60 border-white/30' }}
                                {{ $sekarang ? 'ring-4 ring-white/30 animate-pulse' : '' }}">
                                {{ $sudah ? $ikonLangkah[$i] : $i + 1 }}
                            </div>
                            <p class="mt-2 text-[10px] sm:text-[11px] leading-tight {{ $sudah ? 'font-semibold text-white' : 'text-white/60' }}">
                                {{ \App\Models\Laporan::labelStatus($s) }}
                            </p>
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>
    </div>

    {{-- Detail laporan --}}
    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm p-6 space-y-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-sage-200 text-sage-700 flex items-center justify-center text-lg">📝</div>
            <h2 class="text-lg font-bold font-fraunces text-sage-900">Detail Laporan</h2>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <div class="bg-sage-100/60 border border-sage-200 rounded-xl p-4">
                <dt class="text-sage-600">Mode pelaporan</dt>
                <dd class="font-semibold text-sage-900 mt-1">{{ $laporan->anonim ? '🕶️ Anonim' : '👤 Dengan nama' }}</dd>
            </div>
            <div class="bg-sage-100/60 border border-sage-200 rounded-xl p-4">
                <dt class="text-sage-600">Waktu kejadian</dt>
                <dd class="font-semibold text-sage-900 mt-1">
                    {{ $laporan->waktu_kejadian?->translatedFormat('d F Y, H:i') ?? '-' }}
                </dd>
            </div>
            <div class="bg-sage-100/60 border border-sage-200 rounded-xl p-4">
                <dt class="text-sage-600">Lokasi kejadian</dt>
                <dd class="font-semibold text-sage-900 mt-1">{{ $laporan->lokasi_kejadian ?: '-' }}</dd>
            </div>
        </dl>

        <div>
            <p class="text-xs text-sage-600 mb-2">Kronologi</p>
            <div class="border-l-4 border-sage-200 pl-4">
                <p class="text-sm text-sage-900 leading-relaxed whitespace-pre-line">{{ $laporan->kronologi }}</p>
            </div>
        </div>

        @if ($laporan->anonim)
            <div class="flex items-start gap-3 text-[11px] text-sage-700 bg-sage-100/60 border border-sage-200 rounded-xl px-4 py-3 leading-relaxed">
                <span class="text-base">🔒</span>
                <span>Laporan ini dikirim secara anonim. Identitas Anda tidak ditampilkan kepada admin. Laporan tetap tertaut ke akun Anda agar Anda bisa memantau statusnya.</span>
            </div>
        @endif
    </div>

    {{-- Bukti --}}
    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm p-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">📎</div>
            <h2 class="text-lg font-bold font-fraunces text-sage-900">Bukti Terlampir</h2>
        </div>

        @forelse ($laporan->buktiLaporans as $b)
            <div class="flex items-center justify-between gap-3 py-3 {{ !$loop->last ? 'border-b border-sage-200' : '' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-lg bg-sage-100 border border-sage-200 flex items-center justify-center text-lg flex-shrink-0">
                        {{ $ikonFile($b->tipe_file) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-sage-900 truncate">{{ $b->nama_file }}</p>
                        <p class="text-[11px] text-sage-600">{{ number_format($b->ukuran_file / 1024, 1) }} KB &middot; {{ $b->tipe_file }}</p>
                    </div>
                </div>
                <a href="{{ route('pelaporan.bukti', $b->id) }}"
                   class="flex-shrink-0 px-4 py-2 bg-sage-700 hover:bg-sage-800 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                    Unduh
                </a>
            </div>
        @empty
            <p class="text-xs text-sage-600 font-light bg-sage-100/60 border border-sage-200 rounded-xl px-4 py-3">
                Tidak ada bukti yang dilampirkan.
            </p>
        @endforelse
    </div>

    {{-- Timeline --}}
    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-700 flex items-center justify-center text-lg">💬</div>
            <h2 class="text-lg font-bold font-fraunces text-sage-900">Perkembangan dan Tanggapan</h2>
        </div>

        <ol class="relative border-l-2 border-sage-200 ml-3 space-y-6">
            <li class="ml-6">
                <span class="absolute -left-[9px] w-4 h-4 rounded-full bg-sky-500 border-2 border-white shadow"></span>
                <div class="bg-sage-100/60 border border-sage-200 rounded-xl p-4">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="text-sm font-semibold text-sage-900">Laporan diterima</p>
                        <p class="text-[11px] text-sage-600">{{ $laporan->created_at?->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <p class="text-xs text-sage-600 mt-1">Laporan Anda sudah masuk ke sistem dan menunggu verifikasi.</p>
                </div>
            </li>

            @foreach ($tanggapans as $t)
                <li class="ml-6">
                    <span class="absolute -left-[9px] w-4 h-4 rounded-full {{ $titik[$t->status_laporan_saat_itu] ?? 'bg-sage-700' }} border-2 border-white shadow"></span>
                    <div class="bg-white border border-sage-200 rounded-xl p-4 shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-semibold text-sage-900">Tim Ruang Puan</p>
                                @include('pelaporan._badge', ['status' => $t->status_laporan_saat_itu])
                            </div>
                            <p class="text-[11px] text-sage-600">{{ $t->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}</p>
                        </div>
                        <p class="text-sm text-sage-900 mt-2 leading-relaxed whitespace-pre-line">{{ $t->isi_tanggapan }}</p>
                    </div>
                </li>
            @endforeach
        </ol>

        @if ($tanggapans->isEmpty())
            <p class="text-xs text-sage-600 font-light mt-5 bg-sage-100/60 border border-sage-200 rounded-xl px-4 py-3">
                Belum ada tanggapan dari admin. Status akan diperbarui di halaman ini.
            </p>
        @endif
    </div>

    {{-- Aksi cepat --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('pelaporan.cek') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-sage-100 border border-sage-200 text-sage-900 rounded-xl text-xs font-semibold shadow-sm transition">
            🔎 Cek Kode Lain
        </a>
        <a href="{{ route('pelaporan.riwayat') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-sage-700 hover:bg-sage-800 text-white rounded-xl text-xs font-semibold shadow-sm transition">
            📋 Semua Laporan Saya
        </a>
    </div>

</section>

<script>
    document.getElementById('salin')?.addEventListener('click', function () {
        const kode = document.getElementById('kode').textContent.trim();
        const tombol = this;
        navigator.clipboard.writeText(kode).then(() => {
            tombol.textContent = 'Tersalin ✓';
            setTimeout(() => tombol.textContent = 'Salin', 1500);
        });
    });
</script>
@endsection