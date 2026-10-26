@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <h1 class="text-3xl font-bold text-berry-900 mb-3">Pusat Edukasi & Pengetahuan</h1>
        <p class="text-ink-600">Pelajari hak-hak perempuan, panduan kesehatan reproduksi, serta pencegahan kekerasan secara komprehensif.</p>
        
        <!-- Search Bar -->
        <form method="GET" action="{{ route('edukasi.index') }}" class="mt-6 flex max-w-xl mx-auto gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari artikel atau materi edukasi..."
                class="flex-1 rounded-xl border-cream-200 bg-white focus:border-berry-500 focus:ring-berry-500 px-4 py-2.5 text-sm text-ink-900 border shadow-sm">
            @if($kategoriId)
                <input type="hidden" name="kategori" value="{{ $kategoriId }}">
            @endif
            <button type="submit" class="px-5 py-2.5 bg-berry-700 hover:bg-berry-900 text-white rounded-xl text-sm font-medium shadow-sm transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Kategori Filter Tabs -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
        <a href="{{ route('edukasi.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ is_null($kategoriId) ? 'bg-berry-700 text-white shadow-sm' : 'bg-white text-ink-900 border border-cream-200 hover:bg-cream-100' }}">
            Semua Materi
        </a>
        @foreach($kategoris as $kat)
            <a href="{{ route('edukasi.index', ['kategori' => $kat->id]) }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $kategoriId == $kat->id ? 'bg-berry-700 text-white shadow-sm' : 'bg-white text-ink-900 border border-cream-200 hover:bg-cream-100' }}">
                {{ $kat->nama_kategori }} ({{ $kat->materi_edukasis_count }})
            </a>
        @endforeach
    </div>

    <!-- Materi Grid -->
    @if($materis->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-cream-200 max-w-xl mx-auto shadow-sm">
            <p class="text-ink-600 text-sm">Belum ada materi edukasi yang tersedia untuk kategori atau pencarian ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($materis as $materi)
                <div class="bg-white rounded-2xl shadow-sm border border-cream-200 overflow-hidden flex flex-col hover:shadow-md transition">
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center justify-between text-xs mb-3">
                            <span class="px-2.5 py-1 rounded-full bg-berry-100 text-berry-700 font-semibold">{{ $materi->kategoriEdukasi->nama_kategori }}</span>
                            <span class="text-ink-600 uppercase text-[10px] tracking-wider font-bold">{{ $materi->jenis_konten }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-berry-900 mb-2 leading-snug">
                            <a href="{{ route('edukasi.show', $materi->id) }}" class="hover:text-rose-600 transition">{{ $materi->judul }}</a>
                        </h3>
                        <p class="text-sm text-ink-600 line-clamp-3 mb-4 flex-1">
                            {{ Str::limit(strip_tags($materi->isi), 120) }}
                        </p>
                        <div class="pt-4 border-t border-cream-200 flex items-center justify-between text-xs text-ink-600">
                            <span>Diposting: {{ $materi->tanggal_posting ? \Carbon\Carbon::parse($materi->tanggal_posting)->format('d M Y') : $materi->created_at->format('d M Y') }}</span>
                            <a href="{{ route('edukasi.show', $materi->id) }}" class="text-rose-600 hover:underline font-semibold">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $materis->links() }}
        </div>
    @endif
</div>
@endsection
