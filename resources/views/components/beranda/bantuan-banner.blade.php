@props(['wilayahList', 'layananList'])

{{-- Section: Bantuan + Jejak Langkahmu --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Banner Kiri: Temukan bantuan di sekitarmu (3/5 width) --}}
        <div class="lg:col-span-3 bg-[#3E293F] rounded-3xl p-7 lg:p-8 text-white shadow-sm flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#643B62]/30 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white font-bold text-xl shadow-inner backdrop-blur-md">
                    📍
                </div>
                <h3 class="text-xl font-serif font-medium">Temukan bantuan di sekitarmu</h3>
                <p class="text-xs text-[#EEE7F2]/80 font-light leading-relaxed max-w-md">
                    Cari lembaga pendampingan sesuai wilayah dan layanan yang kamu butuhkan.
                </p>

                {{-- Form Filter Direktori --}}
                <form action="{{ route('direktori.index') }}" method="GET" class="pt-2">
                    <div class="flex flex-col sm:flex-row items-stretch gap-3">
                        <div class="flex-1">
                            <select name="wilayah" class="w-full bg-[#643B62]/60 border border-white/20 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:ring-2 focus:ring-white/40 appearance-none" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%23EEE7F2%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-repeat: no-repeat; background-position: right 0.8rem center; background-size: 1.2em 1.2em; padding-right: 2.5rem;">
                                <option value="" class="text-[#3E293F]">📍 Pilih wilayah</option>
                                @foreach($wilayahList ?? [] as $wilayah)
                                    <option value="{{ $wilayah }}" class="text-[#3E293F]">{{ $wilayah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="jenis_layanan" class="w-full bg-[#643B62]/60 border border-white/20 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:ring-2 focus:ring-white/40 appearance-none" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%23EEE7F2%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-repeat: no-repeat; background-position: right 0.8rem center; background-size: 1.2em 1.2em; padding-right: 2.5rem;">
                                <option value="" class="text-[#3E293F]">Jenis layanan</option>
                                @foreach($layananList ?? [] as $layanan)
                                    <option value="{{ $layanan }}" class="text-[#3E293F]">{{ $layanan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-5 py-3 bg-white hover:bg-[#EEE7F2] text-[#643B62] rounded-xl text-xs font-semibold shadow-sm transition flex items-center justify-center space-x-2 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            <span>Cari bantuan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Banner Kanan: Jejak Langkahmu (2/5 width) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-7 lg:p-8 shadow-sm flex flex-col justify-between border border-[#DCD5DD] relative overflow-hidden">
            <div class="space-y-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] flex items-center justify-center text-[#643B62] font-bold text-lg shadow-inner">
                    ⏱️
                </div>
                <h3 class="text-xl font-serif font-medium text-[#3E293F]">Jejak langkahmu</h3>
                <p class="text-xs text-[#746B77] font-light leading-relaxed">
                    Tinjau laporan, sesi konsultasi, dan pembayaranmu dalam satu tempat.
                </p>
            </div>

            <div class="pt-6 relative z-10">
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('pelaporan.riwayat') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition group">
                        <span>📝 Riwayat Laporan</span>
                        <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
                    </a>

                    <a href="{{ route('pengguna.riwayat-konsultasi') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition group">
                        <span>📅 Riwayat Konsultasi</span>
                        <span class="transform group-hover:translate-x-1 transition">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>