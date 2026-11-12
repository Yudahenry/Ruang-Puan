@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Hero Banner Header --}}
    <div class="relative rounded-3xl bg-gradient-to-br from-[#EEE7F2] to-[#FCFAF8] border border-[#DCD5DD] p-8 sm:p-12 mb-12 text-center max-w-4xl mx-auto shadow-sm overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#643B62]/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#643B62] text-[10px] font-bold tracking-widest uppercase mb-4 shadow-2xs border border-[#DCD5DD]">
                📖 Bekal Untuk Bertumbuh
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#3E293F] mb-3">Pusat Edukasi & Pengetahuan</h1>
            <p class="text-xs sm:text-sm text-[#746B77] max-w-xl mx-auto leading-relaxed">
                Pelajari hak-hak perempuan, panduan kesehatan reproduksi, serta pencegahan kekerasan secara komprehensif.
            </p>
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('edukasi.index') }}" class="mt-8 flex flex-col sm:flex-row max-w-xl mx-auto gap-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#746B77]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari artikel atau materi edukasi..."
                        class="w-full rounded-2xl border border-[#DCD5DD] bg-white focus:border-[#643B62] focus:ring-1 focus:ring-[#643B62] focus:outline-none pl-11 pr-4 py-3 text-xs text-[#3E293F] placeholder-[#746B77]/50 shadow-inner transition">
                </div>
                @if($kategoriId)
                    <input type="hidden" name="kategori" value="{{ $kategoriId }}">
                @endif
                <button type="submit" class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition flex items-center justify-center gap-1.5">
                    <span>Cari</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Kategori Filter Tabs -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
        <a href="{{ route('edukasi.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold transition {{ is_null($kategoriId) ? 'bg-[#643B62] text-white shadow-sm' : 'bg-white text-[#3E293F] border border-[#DCD5DD] hover:bg-[#EEE7F2]/50' }}">
            Semua Materi
        </a>
        @foreach($kategoris as $kat)
            <a href="{{ route('edukasi.index', ['kategori' => $kat->id]) }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold transition {{ $kategoriId == $kat->id ? 'bg-[#643B62] text-white shadow-sm' : 'bg-white text-[#3E293F] border border-[#DCD5DD] hover:bg-[#EEE7F2]/50' }}">
                {{ $kat->nama_kategori }} <span class="opacity-75">({{ $kat->materi_edukasis_count }})</span>
            </a>
        @endforeach
    </div>

    <!-- Materi Grid -->
    @if($materis->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-[#DCD5DD] max-w-xl mx-auto shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-xl mb-3 shadow-inner">
                🔍
            </div>
            <p class="text-xs font-semibold text-[#3E293F]">Tidak ada materi ditemukan</p>
            <p class="text-xs text-[#746B77] mt-1">Belum ada materi edukasi yang tersedia untuk kategori atau pencarian ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $fallbackImages = [
                    'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=600',
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=600',
                    'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600',
                    'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=600'
                ];
            @endphp

            @foreach($materis as $index => $materi)
                <div class="group bg-white rounded-3xl shadow-sm border border-[#DCD5DD] overflow-hidden flex flex-col justify-between hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div>
                        {{-- Thumbnail Image Header --}}
                        <div class="h-48 bg-[#EEE7F2] relative overflow-hidden">
                            <img src="{{ $materi->file_url ?? $fallbackImages[$index % count($fallbackImages)] }}" 
                                 alt="{{ $materi->judul }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                 onerror="this.src='{{ $fallbackImages[0] }}'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-60"></div>
                            <span class="absolute bottom-3 left-4 px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[#643B62] font-semibold text-[10px] tracking-wider uppercase shadow-xs">
                                {{ $materi->kategoriEdukasi->nama_kategori ?? 'Edukasi' }}
                            </span>
                        </div>

                        {{-- Content --}}
                        <div class="p-6">
                            <div class="flex items-center justify-between text-[11px] text-[#746B77] mb-2">
                                <span class="uppercase tracking-wider font-bold text-[10px] text-[#643B62] bg-[#EEE7F2] px-2.5 py-0.5 rounded-md">{{ $materi->jenis_konten ?? 'Artikel' }}</span>
                                <span>{{ $materi->tanggal_posting ? \Carbon\Carbon::parse($materi->tanggal_posting)->format('d M Y') : $materi->created_at->format('d M Y') }}</span>
                            </div>

                            <h3 class="text-base font-serif font-bold text-[#3E293F] mb-2 leading-snug group-hover:text-[#643B62] transition">
                                <a href="{{ route('edukasi.show', $materi->id) }}">{{ $materi->judul }}</a>
                            </h3>

                            <p class="text-xs text-[#746B77] line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($materi->isi), 110) }}
                            </p>
                        </div>
                    </div>

                    {{-- Footer Card --}}
                    <div class="px-6 pb-6 pt-0">
                        <div class="pt-4 border-t border-[#DCD5DD]/50 flex items-center justify-between">
                            <span class="text-[11px] text-[#746B77]">5 menit baca</span>
                            <a href="{{ route('edukasi.show', $materi->id) }}" class="w-8 h-8 rounded-full bg-[#EEE7F2] text-[#643B62] flex items-center justify-center group-hover:bg-[#3E293F] group-hover:text-white transition shadow-2xs">
                                &nearr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $materis->links() }}
        </div>
    @endif
</div>
@endsection