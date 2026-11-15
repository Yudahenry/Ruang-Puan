@extends('layouts.pengguna')

@section('pengguna-content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Header Judul --}}
    <div>
        <h1 class="text-3xl font-bold font-serif text-[#3E293F]">Daftar Konselor</h1>
        <p class="text-xs sm:text-sm text-[#746B77] font-light mt-1">
            Pilih konselor terverifikasi untuk pendampingan awalmu
        </p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold shadow-2xs">
            {{ session('success') }}
        </div>
    @endif

    {{-- Banner Peringatan & Direktori Layanan --}}
    <div class="relative overflow-hidden bg-[#EEE7F2]/80 border border-[#DCD5DD] rounded-2xl p-5 sm:p-6 flex items-center justify-between">
        <div class="flex items-start gap-3.5 max-w-2xl z-10">
            <div class="w-6 h-6 rounded-full border border-[#643B62] text-[#643B62] flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                i
            </div>
            <div class="space-y-2">
                <p class="text-xs sm:text-sm text-[#3E293F] leading-relaxed">
                    Konsultasi adalah pendampingan awal dan bukan pengganti layanan medis profesional.<br class="hidden sm:inline">
                    Dalam keadaan darurat, hubungi hotline bantuan.
                </p>
                <a href="{{ route('direktori.index') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#643B62] hover:text-[#3E293F] transition group">
                    <span>Lihat Direktori Layanan</span>
                    <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
                </a>
            </div>
        </div>

        {{-- Dekorasi Daun Tipis di Sisi Kanan --}}
        <div class="hidden sm:flex items-center justify-center text-[#643B62]/15 pointer-events-none select-none">
            <svg class="w-20 h-20" viewBox="0 0 64 64" fill="currentColor">
                <path d="M32 10C26 20 26 34 32 46C38 34 38 20 32 10Z"/>
                <path d="M16 24C16 34 22 42 32 46C28 36 24 28 16 24Z"/>
                <path d="M48 24C40 28 36 36 32 46C42 42 48 34 48 24Z"/>
            </svg>
        </div>
    </div>

    {{-- Form Pencarian & 4 Filter Dropdown --}}
    <form method="GET" action="{{ route('konsultasi.index') }}" class="space-y-3">
        {{-- Search Input --}}
        <div class="relative">
            <span class="absolute inset-y-0 left-4 flex items-center text-[#746B77]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z"/>
                </svg>
            </span>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama atau bidang keahlian"
                   class="w-full pl-11 pr-4 py-3 bg-white border border-[#DCD5DD] rounded-2xl text-xs sm:text-sm text-[#3E293F] placeholder-[#746B77] focus:outline-none focus:border-[#643B62] transition">
        </div>

        {{-- 4 Dropdown Filter --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <select name="keahlian" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 bg-white border border-[#DCD5DD] rounded-2xl text-xs font-medium text-[#3E293F] focus:outline-none focus:border-[#643B62] cursor-pointer">
                <option value="">Bidang Keahlian</option>
                <option value="Kekerasan dalam Rumah Tangga" {{ request('keahlian') == 'Kekerasan dalam Rumah Tangga' ? 'selected' : '' }}>Kekerasan dalam Rumah Tangga</option>
                <option value="Kekerasan Seksual" {{ request('keahlian') == 'Kekerasan Seksual' ? 'selected' : '' }}>Kekerasan Seksual</option>
                <option value="Trauma Psikologis" {{ request('keahlian') == 'Trauma Psikologis' ? 'selected' : '' }}>Trauma Psikologis</option>
                <option value="Kesehatan Mental" {{ request('keahlian') == 'Kesehatan Mental' ? 'selected' : '' }}>Kesehatan Mental</option>
                <option value="Pelecehan di Tempat Kerja" {{ request('keahlian') == 'Pelecehan di Tempat Kerja' ? 'selected' : '' }}>Pelecehan di Tempat Kerja</option>
                <option value="Kekerasan Berbasis Gender Online" {{ request('keahlian') == 'Kekerasan Berbasis Gender Online' ? 'selected' : '' }}>Kekerasan Berbasis Gender Online</option>
                <option value="Konseling Keluarga" {{ request('keahlian') == 'Konseling Keluarga' ? 'selected' : '' }}>Konseling Keluarga</option>
                <option value="Konseling Remaja" {{ request('keahlian') == 'Konseling Remaja' ? 'selected' : '' }}>Konseling Remaja</option>
            </select>

            <select name="tarif" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 bg-white border border-[#DCD5DD] rounded-2xl text-xs font-medium text-[#3E293F] focus:outline-none focus:border-[#643B62] cursor-pointer">
                <option value="">Rentang Tarif</option>
                <option value="under_150" {{ request('tarif') == 'under_150' ? 'selected' : '' }}>&lt; Rp 150.000</option>
                <option value="150_200" {{ request('tarif') == '150_200' ? 'selected' : '' }}>Rp 150.000 – Rp 200.000</option>
                <option value="above_200" {{ request('tarif') == 'above_200' ? 'selected' : '' }}>&gt; Rp 200.000</option>
            </select>

            <select name="ketersediaan" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 bg-white border border-[#DCD5DD] rounded-2xl text-xs font-medium text-[#3E293F] focus:outline-none focus:border-[#643B62] cursor-pointer">
                <option value="">Ketersediaan</option>
                <option value="tersedia" {{ request('ketersediaan') == 'tersedia' ? 'selected' : '' }}>Jadwal Tersedia</option>
                <option value="hari_ini" {{ request('ketersediaan') == 'hari_ini' ? 'selected' : '' }}>Tersedia Hari Ini</option>
            </select>

            <select name="sort" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 bg-white border border-[#DCD5DD] rounded-2xl text-xs font-medium text-[#3E293F] focus:outline-none focus:border-[#643B62] cursor-pointer">
                <option value="jadwal_terdekat" {{ request('sort', 'jadwal_terdekat') == 'jadwal_terdekat' ? 'selected' : '' }}>Urutkan: Jadwal terdekat</option>
                <option value="tarif_terendah" {{ request('sort') == 'tarif_terendah' ? 'selected' : '' }}>Urutkan: Tarif terendah</option>
                <option value="tarif_tertinggi" {{ request('sort') == 'tarif_tertinggi' ? 'selected' : '' }}>Urutkan: Tarif tertinggi</option>
            </select>
        </div>
    </form>

    {{-- Sub-header & Counter --}}
    <div class="flex items-center justify-between pt-1">
        <h2 class="text-sm sm:text-base font-bold text-[#3E293F]">Temukan pendamping yang tepat</h2>
        <p class="text-xs text-[#746B77]">
            Menampilkan {{ $konsolors->count() }} dari {{ method_exists($konsolors, 'total') ? $konsolors->total() : $konsolors->count() }} konselor
        </p>
    </div>

    {{-- Grid Daftar Konselor (3 Kolom) --}}
    @if (isset($konsolors) && $konsolors->isEmpty())
        <div class="bg-white border border-[#DCD5DD] rounded-3xl p-12 text-center space-y-3 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-2xl shadow-inner">
                👥
            </div>
            <p class="text-base font-bold font-serif text-[#3E293F]">Konselor tidak ditemukan</p>
            <p class="text-xs text-[#746B77]">Belum ada konselor yang sesuai dengan filter pencarian saat ini.</p>
            @if(request()->hasAny(['search', 'keahlian', 'tarif', 'ketersediaan']))
                <a href="{{ route('konsultasi.index') }}"
                   class="inline-flex items-center gap-2 mt-2 px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold transition">
                    Reset Filter
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($konsolors as $konselor)
                @php
                    $userKons = $konselor->user;
                    $namaKons = $userKons->nama ?? $userKons->name ?? 'Konselor Profesional';
                    $foto     = $userKons->foto_profil ?? null;

                    // Ambil spesialisasi/keahlian (mendukung array maupun string dipisah koma)
                    if (!empty($konselor->spesialisasi)) {
                        $tags = is_array($konselor->spesialisasi)
                            ? $konselor->spesialisasi
                            : array_filter(array_map('trim', explode(',', $konselor->spesialisasi)));
                    } else {
                        $tags = ['Psikolog Klinis'];
                    }

                    $tagline  = $konselor->bio_singkat ?? $konselor->deskripsi ?? 'Menemani proses pulih, tanpa menghakimi.';
                    $tarif    = $konselor->tarif ?? $konselor->biaya_konsultasi ?? $konselor->harga ?? 150000;
                    $durasi   = $konselor->durasi_sesi ?? 60;

                    // Jadwal terdekat dari relasi
                    $jadwalTerdekat = $konselor->jadwalKonsultasis?->first();
                @endphp

                <div class="bg-white border border-[#DCD5DD] rounded-3xl p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between space-y-5">
                    <div class="space-y-4">
                        {{-- Foto Profil + Nama + Badge Terverifikasi --}}
                        <div class="flex items-center gap-3.5">
                            @if ($foto)
                                <img src="{{ asset('storage/' . $foto) }}"
                                     alt="{{ $namaKons }}"
                                     class="w-14 h-14 rounded-full object-cover border border-[#DCD5DD] flex-shrink-0">
                            @else
                                <div class="w-14 h-14 rounded-full bg-[#EEE7F2] text-[#643B62] border border-[#DCD5DD] flex items-center justify-center font-serif font-bold text-lg flex-shrink-0">
                                    {{ strtoupper(mb_substr($namaKons, 0, 1)) }}
                                </div>
                            @endif

                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-[#3E293F] truncate" title="{{ $namaKons }}">
                                    {{ $namaKons }}
                                </h3>
                                <span class="inline-flex items-center gap-1 mt-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-medium">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                            </div>
                        </div>

                        {{-- Badge Keahlian --}}
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($tags as $tag)
                                <span class="px-2.5 py-1 rounded-lg bg-[#EEE7F2] text-[#643B62] text-[11px] font-medium">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Tagline / Deskripsi Singkat --}}
                        <p class="text-xs text-[#746B77] line-clamp-2 min-h-[2rem]">
                            {{ $tagline }}
                        </p>
                    </div>

                    <div class="space-y-4 pt-2 border-t border-[#DCD5DD]/60">
                        {{-- Tarif & Durasi --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-base font-bold text-[#643B62]">
                                    Rp {{ number_format($tarif, 0, ',', '.') }}
                                </span>
                                <span class="text-[11px] text-[#746B77]">/ sesi</span>
                            </div>
                            <div class="flex items-center gap-1 text-[11px] text-[#746B77]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $durasi }} menit</span>
                            </div>
                        </div>

                        {{-- Info Jadwal Terdekat --}}
                        <div class="text-xs">
                            @if ($jadwalTerdekat)
                                <p class="flex items-center gap-1.5 text-[11px] text-[#746B77]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Jadwal terdekat</span>
                                </p>
                                <p class="font-semibold text-[#3E293F] mt-0.5">
                                    {{ \Carbon\Carbon::parse($jadwalTerdekat->tanggal)->translatedFormat('D, d M') }},
                                    {{ \Carbon\Carbon::parse($jadwalTerdekat->jam_mulai)->format('H.i') }}
                                </p>
                            @else
                                <p class="flex items-center gap-1.5 text-[11px] text-[#746B77]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    <span>Belum ada jadwal</span>
                                </p>
                                <p class="text-[#746B77] mt-0.5">Cek kembali untuk jadwal terbaru</p>
                            @endif
                        </div>

                        {{-- 2 Tombol Aksi: Lihat Profil & Pilih Jadwal --}}
                        <div class="grid grid-cols-2 gap-2.5 pt-1">
                            <a href="{{ route('konsultasi.konselor.profil', $konselor->id) }}"
                               class="inline-flex items-center justify-center px-3 py-2.5 bg-white hover:bg-[#EEE7F2]/60 text-[#3E293F] border border-[#DCD5DD] rounded-xl text-xs font-semibold transition">
                                Lihat profil
                            </a>

                            @if ($jadwalTerdekat)
                                <a href="{{ route('konsultasi.jadwal', $konselor->id) }}"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-2xs transition">
                                    <span>Pilih jadwal</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                            @else
                                <button type="button" disabled
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-gray-200 text-gray-400 rounded-xl text-xs font-semibold cursor-not-allowed">
                                    <span>Pilih jadwal</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Bawah --}}
        @if(method_exists($konsolors, 'links'))
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4">
                <p class="text-xs text-[#746B77]">
                    Menampilkan {{ $konsolors->firstItem() ?? 0 }}-{{ $konsolors->lastItem() ?? 0 }} dari {{ $konsolors->total() }} konselor
                </p>
                <div>
                    {{ $konsolors->links() }}
                </div>
            </div>
        @endif
    @endif

</section>
@endsection