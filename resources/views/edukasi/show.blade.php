@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('edukasi.index') }}" class="text-xs font-semibold text-[#643B62] hover:underline mb-3 inline-flex items-center gap-1">
            &larr; Kembali ke Daftar Edukasi
        </a>
        <div class="flex items-center space-x-2 text-xs mb-3">
            <span class="px-3 py-1 rounded-full bg-[#EEE7F2] text-[#643B62] font-medium text-[11px]">{{ $materi->kategoriEdukasi->nama_kategori }}</span>
            <span class="text-[#746B77]">·</span>
            <span class="text-[#746B77] uppercase tracking-wider font-bold text-[10px]">{{ $materi->jenis_konten }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tracking-tight leading-snug">{{ $materi->judul }}</h1>
        <p class="text-xs text-[#746B77] mt-2">Diposting pada {{ $materi->tanggal_posting ? \Carbon\Carbon::parse($materi->tanggal_posting)->format('d M Y') : $materi->created_at->format('d M Y') }}</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-8 sm:p-10 mb-12">
        <div class="prose max-w-none text-[#3E293F] leading-relaxed space-y-4 text-sm sm:text-base font-normal">
            {!! nl2br(e($materi->isi)) !!}
        </div>
    </div>

    @if($relatedMateris->isNotEmpty())
        <div class="border-t border-[#DCD5DD]/60 pt-8">
            <h3 class="text-xl font-serif font-bold text-[#3E293F] mb-6">Materi Edukasi Terkait</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedMateris as $rel)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#DCD5DD] flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-[#643B62]">{{ $rel->kategoriEdukasi->nama_kategori }}</span>
                            <h4 class="font-serif font-bold text-[#3E293F] text-sm mt-1 mb-3 leading-snug">
                                <a href="{{ route('edukasi.show', $rel->id) }}" class="hover:text-[#643B62] transition">{{ $rel->judul }}</a>
                            </h4>
                        </div>
                        <div class="pt-4 border-t border-[#DCD5DD]/50">
                            <a href="{{ route('edukasi.show', $rel->id) }}" class="text-xs font-semibold text-[#643B62] hover:underline flex items-center gap-1">
                                Baca selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection