@extends('layouts.pengguna')

@section('pengguna-content')
@php
    $aksen = [
        'diterima'              => 'border-l-sky-400',
        'diverifikasi'          => 'border-l-indigo-400',
        'diproses'              => 'border-l-amber-400',
        'diteruskan_ke_lembaga' => 'border-l-violet-400',
        'selesai'               => 'border-l-emerald-500',
        'ditutup'               => 'border-l-gray-400',
    ];
@endphp

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <a href="{{ route('pengguna.dashboard') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-full text-xs font-semibold shadow-sm transition group">
        <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
        <span>Kembali ke Dashboard</span>
    </a>

    {{-- Banner header --}}
    <div class="relative overflow-hidden bg-[#3E293F] rounded-3xl p-6 sm:p-8 text-white shadow-lg">
        <div class="absolute -right-10 -bottom-12 w-56 h-56 bg-[#643B62]/40 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
            <div>
                <p class="text-[11px] tracking-widest uppercase text-[#EEE7F2]/80">Pelaporan</p>
                <h1 class="text-3xl font-bold font-serif mt-1">Riwayat Laporan</h1>
                <p class="text-sm text-[#EEE7F2]/80 font-light mt-1">Daftar laporan yang pernah Anda ajukan beserta statusnya.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('pelaporan.cek') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/30 text-white rounded-xl text-xs font-semibold transition">
                    🔎 Cek Status
                </a>
                <a href="{{ route('pelaporan.buat') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-[#EEE7F2] text-[#3E293F] rounded-xl text-xs font-semibold shadow-md transition group">
                    <span>+ Buat Laporan Baru</span>
                    <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach ([
            ['Total Laporan', $ringkasan['total'], '📋', 'bg-[#EEE7F2]'],
            ['Sedang Berjalan', $ringkasan['aktif'], '⏳', 'bg-amber-100'],
            ['Selesai / Ditutup', $ringkasan['selesai'], '✅', 'bg-emerald-100'],
        ] as [$label, $nilai, $ikon, $bg])
            <div class="bg-white border border-[#DCD5DD] rounded-2xl shadow-sm p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl {{ $bg }} text-[#643B62] flex items-center justify-center text-xl flex-shrink-0">{{ $ikon }}</div>
                <div>
                    <p class="text-xs text-[#746B77]">{{ $label }}</p>
                    <p class="text-2xl font-bold font-serif text-[#3E293F]">{{ $nilai }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Filter dan pencarian --}}
    <form method="GET" action="{{ route('pelaporan.riwayat') }}"
          class="bg-white border border-[#DCD5DD] rounded-2xl shadow-sm p-4 flex flex-col sm:flex-row gap-3">
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari kode pelacakan (contoh: RP-ABC123)"
               class="flex-1 bg-[#FCFAF8] border border-[#DCD5DD] rounded-xl px-3 py-2.5 text-xs text-[#3E293F] focus:outline-none focus:ring-2 focus:ring-[#643B62]/30">
        <select name="status"
                class="sm:w-56 bg-[#FCFAF8] border border-[#DCD5DD] rounded-xl px-3 py-2.5 text-xs text-[#3E293F] focus:outline-none focus:ring-2 focus:ring-[#643B62]/30">
            <option value="">Semua status</option>
            @foreach (\App\Models\Laporan::STATUS_LIST as $s)
                <option value="{{ $s }}" @selected($status === $s)>{{ \App\Models\Laporan::labelStatus($s) }}</option>
            @endforeach
        </select>
        <button type="submit"
                class="px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition">
            Terapkan
        </button>
        @if ($q !== '' || $status)
            <a href="{{ route('pelaporan.riwayat') }}"
               class="px-4 py-2.5 text-xs font-semibold text-[#746B77] hover:text-[#3E293F] text-center flex items-center justify-center">Reset</a>
        @endif
    </form>

    {{-- Daftar --}}
    @if ($laporans->isEmpty())
        <div class="bg-white border border-[#DCD5DD] rounded-2xl shadow-sm px-6 py-14 text-center">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center text-2xl mb-4">📋</div>
            @if ($q !== '' || $status)
                <h3 class="text-lg font-bold font-serif text-[#3E293F]">Tidak ada laporan yang cocok</h3>
                <p class="text-xs text-[#746B77] font-light mt-2">Coba ubah kata kunci atau filter status.</p>
            @else
                <h3 class="text-lg font-bold font-serif text-[#3E293F]">Belum ada laporan</h3>
                <p class="text-xs text-[#746B77] font-light mt-2 max-w-sm mx-auto leading-relaxed">
                    Laporan yang Anda kirim, termasuk yang anonim, akan muncul di sini beserta perkembangan statusnya.
                </p>
                <a href="{{ route('pelaporan.buat') }}"
                   class="inline-flex items-center gap-2 mt-6 px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition">
                    Buat laporan pertamamu &rarr;
                </a>
            @endif
        </div>
    @else
        <div class="space-y-4">
            @foreach ($laporans as $laporan)
                <div class="bg-white border border-[#DCD5DD] border-l-4 {{ $aksen[$laporan->status] ?? 'border-l-[#DCD5DD]' }} rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-mono font-bold text-[#3E293F] text-sm">{{ $laporan->kode_pelacakan }}</span>
                                <span class="inline-flex px-2 py-0.5 rounded-full bg-[#EEE7F2] border border-[#DCD5DD] text-[10px] font-semibold text-[#643B62]">
                                    {{ $laporan->anonim ? '🕶️ Anonim' : '👤 Bernama' }}
                                </span>
                            </div>
                            <p class="text-base font-bold font-serif text-[#3E293F] mt-1">{{ $laporan->jenisKasusLabel() }}</p>
                            <p class="text-xs text-[#746B77] mt-1">
                                Dikirim {{ $laporan->created_at?->translatedFormat('d F Y, H:i') }}
                                &middot; {{ $laporan->buktiLaporans()->count() }} bukti
                            </p>
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-3">
                            @include('pelaporan._badge', ['status' => $laporan->status])
                            <a href="{{ route('pelaporan.lacak', $laporan->kode_pelacakan) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition group">
                                <span>Lacak / Detail</span>
                                <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $laporans->links() }}</div>
    @endif

</section>
@endsection