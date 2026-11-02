<div class="bg-sage-150/80 border border-sage-200/80 rounded-2xl p-6">
    {{-- Clock/History icon --}}
    <div class="text-sage-800">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>

    {{-- Title --}}
    <h3 class="font-fraunces text-xl font-normal text-sage-900 mt-3 leading-snug">
        Pantau langkahmu
    </h3>

    {{-- Content --}}
    <p class="text-xs text-sage-600 mt-2 leading-relaxed">
        Setelah mengirim, lihat status dan riwayat laporan milikmu dalam satu tempat.
    </p>

    {{-- Link ke riwayat --}}
    <div class="mt-4">
        <a href="{{ route('pelaporan.riwayat') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-sage-900 hover:text-sage-700 transition">
            <span>Buka riwayat laporan</span>
            <span class="text-xs">&nearr;</span>
        </a>
    </div>
</div>
