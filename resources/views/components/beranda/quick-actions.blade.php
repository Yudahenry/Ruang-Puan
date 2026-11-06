{{-- Quick Action Cards: 3 cards overlapping hero bottom, matching PDF --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 mb-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Card 1: Buat Laporan (Dark green, prominent) --}}
        <a href="{{ route('pelaporan.buat') }}" class="group bg-sage-700 hover:bg-sage-600 text-white rounded-2xl px-6 py-5 shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between border border-sage-500/30">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold font-fraunces">Buat laporan</h3>
                    <p class="text-xs text-sage-100/80 font-light mt-0.5">Ceritakan dengan nama atau anonim.</p>
                </div>
            </div>
            <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white group-hover:bg-white group-hover:text-sage-900 transition flex-shrink-0 ml-3">
                &nearr;
            </span>
        </a>

        {{-- Card 2: Jelajahi Edukasi (White card) --}}
        <a href="{{ route('edukasi.index') }}" class="group bg-white hover:bg-cream-50 text-sage-900 rounded-2xl px-6 py-5 shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between border border-sage-200">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-sage-100 flex items-center justify-center text-sage-700 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold font-fraunces text-sage-900">Jelajahi edukasi</h3>
                    <p class="text-xs text-sage-500 font-light mt-0.5">Kenali hakmu, perluas wawasanmu.</p>
                </div>
            </div>
            <span class="w-8 h-8 rounded-full bg-sage-100 flex items-center justify-center text-sage-700 group-hover:bg-sage-700 group-hover:text-white transition flex-shrink-0 ml-3">
                &nearr;
            </span>
        </a>

        {{-- Card 3: Jadwalkan Konsultasi (DIUBAH KE RUTE KONSULTASI) --}}
        <a href="{{ route('konsultasi.index') }}" class="group bg-white hover:bg-cream-50 text-sage-900 rounded-2xl px-6 py-5 shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between border border-sage-200">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-sage-100 flex items-center justify-center text-sage-700 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold font-fraunces text-sage-900">Jadwalkan konsultasi</h3>
                    <p class="text-xs text-sage-500 font-light mt-0.5">Pilih sesi chat berbayar dengan ahli.</p>
                </div>
            </div>
            <span class="w-8 h-8 rounded-full bg-sage-100 flex items-center justify-center text-sage-700 group-hover:bg-sage-700 group-hover:text-white transition flex-shrink-0 ml-3">
                &nearr;
            </span>
        </a>
    </div>
</div>