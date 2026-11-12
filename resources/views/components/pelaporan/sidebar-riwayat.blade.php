<div class="bg-white border border-[#DCD5DD] rounded-2xl p-6 shadow-xs">
    {{-- Clock/History icon --}}
    <div class="text-[#643B62]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>

    {{-- Title --}}
    <h3 class="font-serif font-bold text-base text-[#3E293F] mt-3 leading-snug">
        Pantau langkahmu
    </h3>

    {{-- Content --}}
    <p class="text-xs text-[#746B77] mt-2 leading-relaxed">
        Setelah mengirim, lihat status dan riwayat laporan milikmu dalam satu tempat.
    </p>

    {{-- Link ke riwayat --}}
    <div class="mt-4">
        <a href="{{ route('pelaporan.riwayat') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#643B62] hover:text-[#3E293F] transition">
            <span>Buka riwayat laporan</span>
            <span class="text-xs">&nearr;</span>
        </a>
    </div>
</div>