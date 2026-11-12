{{-- Hero Section: Full-width rounded card with photo background and plum gradient overlay --}}
<section class="relative w-full rounded-3xl overflow-hidden shadow-xl min-h-[420px] flex items-end bg-[#3E293F] mx-auto max-w-7xl px-0 mb-0">
    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero_beranda.jpg') }}" alt="Dua perempuan berbincang hangat" class="w-full h-full object-cover">
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(62,41,63,0.88) 0%, rgba(100,59,98,0.65) 45%, rgba(100,59,98,0.20) 100%);"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 w-full px-8 sm:px-12 lg:px-16 py-12 pb-24">
        <div class="max-w-2xl text-white space-y-5">
            {{-- Label kecil --}}
            <div class="inline-flex items-center space-x-2 text-[#EEE7F2] text-xs font-semibold tracking-wider uppercase">
                <span>SELAMAT DATANG KEMBALI, {{ strtoupper(explode(' ', auth()->user()->nama ?? 'Sobat')[0]) }}</span>
            </div>

            {{-- Headline 2 baris font serif --}}
            <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-bold tracking-tight font-serif leading-[1.1]">
                Ada ruang untukmu.<br>Di setiap langkah.
            </h1>

            {{-- Subheadline --}}
            <p class="text-sm sm:text-base text-[#EEE7F2]/90 font-normal leading-relaxed max-w-lg">
                Bercerita, menemukan pengetahuan, atau mencari pendampingan. Mulai dari yang kamu butuhkan hari ini.
            </p>

            {{-- Baris kecil --}}
            <div class="pt-1 flex items-center space-x-2 text-xs text-[#EEE7F2]/70 font-light">
                <svg class="w-4 h-4 text-[#EEE7F2] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Tak perlu terburu-buru. Kamu yang menentukan langkahmu.</span>
            </div>
        </div>
    </div>
</section>