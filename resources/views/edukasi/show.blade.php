@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('edukasi.index') }}" class="text-xs font-semibold text-berry-700 hover:underline mb-2 inline-block">&larr; Kembali ke Daftar Edukasi</a>
        <div class="flex items-center space-x-2 text-xs mb-3">
            <span class="px-2.5 py-1 rounded-full bg-berry-100 text-berry-700 font-semibold">{{ $materi->kategoriEdukasi->nama_kategori }}</span>
            <span class="text-ink-600 uppercase tracking-wider font-bold">• {{ $materi->jenis_konten }}</span>
        </div>
        <h1 class="text-3xl font-extrabold text-berry-900 tracking-tight leading-snug">{{ $materi->judul }}</h1>
        <p class="text-xs text-ink-600 mt-2">Diposting pada {{ $materi->tanggal_posting ? \Carbon\Carbon::parse($materi->tanggal_posting)->format('d M Y') : $materi->created_at->format('d M Y') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-8 mb-12">
        <div class="prose max-w-none text-ink-900 leading-relaxed space-y-4">
            {!! nl2br(e($materi->isi)) !!}
        </div>
    </div>

    @if($relatedMateris->isNotEmpty())
        <div>
            <h3 class="text-xl font-bold text-berry-900 mb-6">Materi Edukasi Terkait</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedMateris as $rel)
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-cream-200 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-berry-700">{{ $rel->kategoriEdukasi->nama_kategori }}</span>
                            <h4 class="font-bold text-berry-900 text-sm mt-1 mb-2">
                                <a href="{{ route('edukasi.show', $rel->id) }}" class="hover:text-rose-600 transition">{{ $rel->judul }}</a>
                            </h4>
                        </div>
                        <a href="{{ route('edukasi.show', $rel->id) }}" class="text-xs font-semibold text-rose-600 hover:underline mt-4">Baca &rarr;</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
