@props(['materiEdukasis'])

{{-- Section: Sedikit belajar, lebih berdaya --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    {{-- Header Section --}}
    <div class="flex items-end justify-between mb-6">
        <div>
            <span class="text-[10px] font-semibold text-sage-600 tracking-[0.15em] uppercase">Bekal Untuk Bertumbuh</span>
            <h2 class="text-2xl sm:text-3xl font-bold font-fraunces text-sage-900 mt-1">Sedikit belajar, lebih berdaya</h2>
        </div>
        <a href="{{ route('edukasi.index') }}" class="text-xs font-semibold text-sage-700 hover:text-sage-900 flex items-center space-x-1 transition group">
            <span>Jelajahi semua materi</span>
            <span class="transform group-hover:translate-x-1 transition">&nearr;</span>
        </a>
    </div>

    {{-- Grid 4 Kolom --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $fallbackImages = [
                '/images/edukasi_hak_perempuan.jpg',
                '/images/edukasi_pencegahan.jpg',
                '/images/edukasi_kesehatan.jpg',
                '/images/edukasi_karir.jpg',
            ];
            $fallbackCategories = ['HAK PEREMPUAN', 'PENCEGAHAN KEKERASAN', 'KESEHATAN REPRODUKSI', 'PENGEMBANGAN KARIER'];
            $fallbackTitles = [
                'Mengenal hakmu di tempat kerja',
                'Mengenali batasan dalam relasi yang sehat',
                'Memahami siklus dan kebutuhan tubuhmu',
                'Langkah kecil membangun percaya diri',
            ];
            $fallbackReadTimes = ['6 menit baca', '5 menit baca', '7 menit baca', '4 menit baca'];
        @endphp

        @forelse($materiEdukasis as $index => $materi)
            <a href="{{ route('edukasi.show', $materi->id) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-sage-200/80 flex flex-col justify-between transform hover:-translate-y-1">
                <div>
                    {{-- Thumbnail / Banner --}}
                    <div class="h-40 bg-sage-200 relative overflow-hidden">
                        @if($materi->file_url)
                            <img src="{{ $materi->file_url }}" alt="{{ $materi->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <img src="{{ asset($fallbackImages[$index % 4]) }}" alt="{{ $materi->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <span class="text-[9px] font-bold text-sage-600 tracking-[0.12em] uppercase">
                            {{ $materi->kategoriEdukasi->nama_kategori ?? $fallbackCategories[$index % 4] }}
                        </span>
                        <h3 class="font-bold text-sage-900 text-sm font-fraunces line-clamp-2 group-hover:text-sage-600 transition leading-snug mt-1.5">
                            {{ $materi->judul }}
                        </h3>
                    </div>
                </div>

                {{-- Footer Card --}}
                <div class="px-4 pb-4 pt-1 flex items-center justify-between text-xs text-sage-500">
                    <span>{{ $fallbackReadTimes[$index % 4] }}</span>
                    <div class="w-7 h-7 rounded-full bg-sage-100 text-sage-700 flex items-center justify-center group-hover:bg-sage-700 group-hover:text-white transition">
                        &nearr;
                    </div>
                </div>
            </a>
        @empty
            {{-- Placeholder cards when no data --}}
            @for($i = 0; $i < 4; $i++)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-sage-200/80 flex flex-col justify-between">
                    <div>
                        <div class="h-40 bg-sage-200 relative overflow-hidden">
                            <img src="{{ asset($fallbackImages[$i]) }}" alt="{{ $fallbackTitles[$i] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <span class="text-[9px] font-bold text-sage-600 tracking-[0.12em] uppercase">{{ $fallbackCategories[$i] }}</span>
                            <h3 class="font-bold text-sage-900 text-sm font-fraunces line-clamp-2 leading-snug mt-1.5">
                                {{ $fallbackTitles[$i] }}
                            </h3>
                        </div>
                    </div>
                    <div class="px-4 pb-4 pt-1 flex items-center justify-between text-xs text-sage-500">
                        <span>{{ $fallbackReadTimes[$i] }}</span>
                        <div class="w-7 h-7 rounded-full bg-sage-100 text-sage-700 flex items-center justify-center">
                            &nearr;
                        </div>
                    </div>
                </div>
            @endfor
        @endforelse
    </div>
</section>
