@props(['wilayahList', 'layananList'])

{{-- Section: Bantuan + Jejak Langkahmu --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Banner Kiri: Temukan bantuan di sekitarmu (3/5 width) --}}
        <div class="lg:col-span-3 bg-sage-700 rounded-2xl p-7 lg:p-8 text-white shadow-lg flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-sage-600/30 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 space-y-4">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold font-fraunces">Temukan bantuan di sekitarmu</h3>
                <p class="text-xs text-sage-100/80 font-light leading-relaxed max-w-md">
                    Cari lembaga pendampingan sesuai wilayah dan layanan yang kamu butuhkan.
                </p>

                {{-- Form Filter Direktori --}}
                <form action="{{ route('direktori.index') }}" method="GET" class="pt-2">
                    <div class="flex flex-col sm:flex-row items-stretch gap-3">
                        <div class="flex-1">
                            <select name="wilayah" class="w-full bg-sage-800/60 border border-sage-500/40 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-sage-200 appearance-none" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%23E9EEDC%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-repeat: no-repeat; background-position: right 0.7rem center; background-size: 1.2em 1.2em; padding-right: 2.5rem;">
                                <option value="">📍 Pilih wilayah</option>
                                @foreach($wilayahList ?? [] as $wilayah)
                                    <option value="{{ $wilayah }}">{{ $wilayah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="jenis_layanan" class="w-full bg-sage-800/60 border border-sage-500/40 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-sage-200 appearance-none" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%23E9EEDC%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-repeat: no-repeat; background-position: right 0.7rem center; background-size: 1.2em 1.2em; padding-right: 2.5rem;">
                                <option value="">Jenis layanan</option>
                                @foreach($layananList ?? [] as $layanan)
                                    <option value="{{ $layanan }}">{{ $layanan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-white hover:bg-sage-100 text-sage-900 rounded-xl text-xs font-semibold shadow-md transition flex items-center justify-center space-x-2 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            <span>Cari bantuan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Banner Kanan: Jejak Langkahmu (2/5 width) --}}
        <div class="lg:col-span-2 bg-sage-100/60 rounded-2xl p-7 lg:p-8 shadow-sm flex flex-col justify-between border border-sage-200 relative overflow-hidden">
            <div class="space-y-4 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-sage-200 flex items-center justify-center text-sage-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold font-fraunces text-sage-900">Jejak langkahmu</h3>
                <p class="text-xs text-sage-600 font-light leading-relaxed">
                    Tinjau laporan, sesi konsultasi, dan pembayaranmu dalam satu tempat.
                </p>
            </div>

            <div class="pt-6 relative z-10">
                <a href="{{ route('pelaporan.riwayat') }}" class="inline-flex items-center space-x-2 text-xs font-semibold text-sage-900 hover:underline transition group">
                    <span>Buka riwayat saya</span>
                    <span class="transform group-hover:translate-x-1 transition">&nearr;</span>
                </a>
            </div>
        </div>
    </div>
</section>
