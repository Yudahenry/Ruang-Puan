@extends('layouts.pengguna')

@section('pengguna-content')
<div class="space-y-12 pb-16">
    
    <!-- Hero Banner Header (Full Styled Container) -->
    <div class="relative rounded-3xl bg-gradient-to-br from-[#3E293F] via-[#643B62] to-[#3E293F] text-white p-8 sm:p-14 text-center max-w-7xl mx-auto shadow-xl overflow-hidden">
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -top-16 w-64 h-64 bg-[#EEE7F2]/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-md text-white text-[11px] font-bold tracking-widest uppercase mb-4 border border-white/20 shadow-inner">
                📖 Bekal Untuk Bertumbuh & Berdaya
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold mb-4 tracking-tight">Pusat Edukasi & Literasi</h1>
            <p class="text-xs sm:text-sm text-[#EEE7F2] leading-relaxed max-w-xl mx-auto">
                Pelajari hak-hak perlindungan, panduan kesehatan mental, pencegahan kekerasan, serta artikel inspiratif secara komprehensif.
            </p>
            
            <!-- Search Bar Modern -->
            <form method="GET" action="{{ route('edukasi.index') }}" class="mt-8 flex flex-col sm:flex-row gap-2.5 bg-white p-2 rounded-2xl border border-white/20 shadow-lg max-w-xl mx-auto">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#746B77]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari artikel, panduan, atau topik edukasi..."
                        class="w-full rounded-xl border-0 bg-transparent focus:ring-0 pl-11 pr-4 py-2.5 text-xs sm:text-sm text-[#3E293F] placeholder-[#746B77]/60 focus:outline-none">
                </div>
                @if($kategoriId)
                    <input type="hidden" name="kategori" value="{{ $kategoriId }}">
                @endif
                <button type="submit" class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition active:scale-[0.98]">
                    Cari Materi
                </button>
            </form>
        </div>
    </div>

    <!-- Kategori Filter Pills (Di dalam kontainer lembut agar tidak monoton) -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-[#EEE7F2]/50 border border-[#DCD5DD] p-3 rounded-2xl flex items-center justify-start sm:justify-center overflow-x-auto gap-2">
            <a href="{{ route('edukasi.index', array_merge(request()->except('kategori'), ['kategori' => null])) }}" 
               class="px-5 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 {{ is_null($kategoriId) ? 'bg-[#3E293F] text-white shadow-sm' : 'bg-white text-[#746B77] border border-[#DCD5DD] hover:text-[#3E293F] hover:bg-[#EEE7F2]' }}">
                Semua Materi
            </a>
            @foreach($kategoris as $kat)
                <a href="{{ route('edukasi.index', array_merge(request()->except('kategori'), ['kategori' => $kat->id])) }}" 
                   class="px-5 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 {{ $kategoriId == $kat->id ? 'bg-[#3E293F] text-white shadow-sm' : 'bg-white text-[#746B77] border border-[#DCD5DD] hover:text-[#3E293F] hover:bg-[#EEE7F2]' }}">
                    {{ $kat->nama_kategori }} <span class="opacity-75">({{ $kat->materi_edukasis_count }})</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Main Content Section -->
    @if($materis->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-[#DCD5DD] max-w-xl mx-auto shadow-sm p-8">
            <div class="w-16 h-16 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-2xl mb-4 shadow-inner">
                🔍
            </div>
            <h3 class="font-serif font-bold text-[#3E293F] text-base">Tidak ada materi ditemukan</h3>
            <p class="text-xs text-[#746B77] mt-1.5 mb-6">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
            <a href="{{ route('edukasi.index') }}" class="inline-flex items-center px-5 py-2.5 bg-[#643B62] text-white rounded-xl text-xs font-semibold hover:bg-[#3E293F] transition">
                Reset Pencarian
            </a>
        </div>
    @else
        @php
            $fallbackImages = [
                'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=800',
                'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=800',
                'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800',
                'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=800'
            ];
            $featured = ($materis->currentPage() == 1 && !$search && !$kategoriId) ? $materis->first() : null;
            $gridMateris = $featured ? $materis->skip(1) : $materis;
        @endphp

        <!-- Kontainer Berlatar Belakang Lembut (Mengurangi Ruang Putih Polos) -->
        <div class="bg-[#FCFAF8] border-y border-[#DCD5DD] py-12 px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Featured Article -->
            @if($featured)
                <div class="max-w-7xl mx-auto">
                    <div class="group bg-white rounded-3xl shadow-sm border border-[#DCD5DD] overflow-hidden grid grid-cols-1 lg:grid-cols-12 hover:shadow-md transition-all duration-300">
                        <div class="lg:col-span-7 relative bg-[#EEE7F2] min-h-[280px] lg:min-h-[380px] overflow-hidden">
                            <img src="{{ $featured->file_url ?? $fallbackImages[0] }}" 
                                 alt="{{ $featured->judul }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                                 onerror="this.src='{{ $fallbackImages[0] }}'">
                            <div class="absolute top-4 left-4">
                                <span class="px-3.5 py-1.5 rounded-full bg-[#3E293F]/90 backdrop-blur-md text-white font-bold text-[10px] tracking-wider uppercase shadow-sm">
                                    ⭐ Artikel Unggulan
                                </span>
                            </div>
                        </div>
                        <div class="lg:col-span-5 p-8 sm:p-10 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 text-xs text-[#746B77] mb-3">
                                    <span class="font-bold uppercase tracking-wider text-[#643B62] bg-[#EEE7F2] px-3 py-1 rounded-md text-[10px]">
                                        {{ $featured->kategoriEdukasi->nama_kategori ?? 'Edukasi' }}
                                    </span>
                                    <span>{{ $featured->tanggal_posting ? \Carbon\Carbon::parse($featured->tanggal_posting)->format('d M Y') : $featured->created_at->format('d M Y') }}</span>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#3E293F] mb-3 leading-snug group-hover:text-[#643B62] transition">
                                    <a href="{{ route('edukasi.show', $featured->id) }}">{{ $featured->judul }}</a>
                                </h2>
                                <p class="text-xs sm:text-sm text-[#746B77] line-clamp-3 leading-relaxed mb-6">
                                    {{ Str::limit(strip_tags($featured->isi), 160) }}
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#DCD5DD]/60 flex items-center justify-between">
                                <span class="text-xs font-medium text-[#746B77]">⏱️ 5 menit baca</span>
                                <a href="{{ route('edukasi.show', $featured->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Grid Materi Lainnya -->
            <div class="max-w-7xl mx-auto">
                @if($featured)
                    <h3 class="text-lg font-serif font-bold text-[#3E293F] mb-6 mt-8">Materi & Panduan Lainnya</h3>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($gridMateris as $index => $materi)
                        <div class="group bg-white rounded-3xl shadow-sm border border-[#DCD5DD] overflow-hidden flex flex-col justify-between hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                            <div>
                                {{-- Thumbnail Image --}}
                                <div class="h-48 bg-[#EEE7F2] relative overflow-hidden">
                                    <img src="{{ $materi->file_url ?? $fallbackImages[($index + 1) % count($fallbackImages)] }}" 
                                         alt="{{ $materi->judul }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                         onerror="this.src='{{ $fallbackImages[0] }}'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-50"></div>
                                    <span class="absolute bottom-3 left-4 px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-[#643B62] font-semibold text-[10px] tracking-wider uppercase shadow-xs">
                                        {{ $materi->kategoriEdukasi->nama_kategori ?? 'Edukasi' }}
                                    </span>
                                </div>

                                {{-- Card Body --}}
                                <div class="p-6">
                                    <div class="flex items-center justify-between text-[11px] text-[#746B77] mb-2.5">
                                        <span class="uppercase tracking-wider font-bold text-[10px] text-[#643B62] bg-[#EEE7F2] px-2.5 py-0.5 rounded-md">{{ $materi->jenis_konten ?? 'Artikel' }}</span>
                                        <span>{{ $materi->tanggal_posting ? \Carbon\Carbon::parse($materi->tanggal_posting)->format('d M Y') : $materi->created_at->format('d M Y') }}</span>
                                    </div>

                                    <h3 class="text-base font-serif font-bold text-[#3E293F] mb-2.5 leading-snug group-hover:text-[#643B62] transition line-clamp-2">
                                        <a href="{{ route('edukasi.show', $materi->id) }}">{{ $materi->judul }}</a>
                                    </h3>

                                    <p class="text-xs text-[#746B77] line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($materi->isi), 100) }}
                                    </p>
                                </div>
                            </div>

                            {{-- Card Footer --}}
                            <div class="px-6 pb-6 pt-0">
                                <div class="pt-4 border-t border-[#DCD5DD]/50 flex items-center justify-between">
                                    <span class="text-[11px] text-[#746B77]">📖 4 min baca</span>
                                    <a href="{{ route('edukasi.show', $materi->id) }}" class="w-8 h-8 rounded-full bg-[#EEE7F2] text-[#643B62] flex items-center justify-center group-hover:bg-[#3E293F] group-hover:text-white transition shadow-2xs">
                                        &nearr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination Links -->
            <div class="mt-12 flex justify-center">
                {{ $materis->withQueryString()->links() }}
            </div>

        </div>
    @endif

    <!-- Banner Tambahan di Bawah untuk Mengisi Ruang & Memberi Kesan Profesional -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="rounded-3xl bg-[#EEE7F2]/70 border border-[#DCD5DD] p-8 sm:p-10 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
            <div class="space-y-1 text-center sm:text-left">
                <h4 class="font-serif font-bold text-lg text-[#3E293F]">Butuh Pendampingan Lebih Lanjut?</h4>
                <p class="text-xs text-[#746B77]">Jika Anda atau seseorang yang Anda kenal membutuhkan konsultasi privat, konselor kami siap mendengarkan.</p>
            </div>
            <a href="{{ route('konsultasi.index') }}" class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white font-semibold rounded-2xl text-xs transition shadow-sm whitespace-nowrap">
                Jadwalkan Konsultasi &rarr;
            </a>
        </div>
    </div>

</div>
@endsection