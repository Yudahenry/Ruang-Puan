@props(['laporanTerbaru', 'konsultasiMendatang'])

{{-- Section: Langkahmu sejauh ini --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    {{-- Header Section --}}
    <div class="flex items-end justify-between mb-6">
        <div>
            <span class="text-[10px] font-semibold text-sage-600 tracking-[0.15em] uppercase">Ruang Personalmu</span>
            <h2 class="text-2xl sm:text-3xl font-bold font-fraunces text-sage-900 mt-1">Langkahmu sejauh ini</h2>
        </div>
        <a href="{{ route('pelaporan.riwayat') }}" class="text-xs font-semibold text-sage-700 hover:text-sage-900 flex items-center space-x-1 transition group">
            <span>Lihat semua riwayat</span>
            <span class="transform group-hover:translate-x-1 transition">&nearr;</span>
        </a>
    </div>

    {{-- Grid 2 Kolom --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Kolom 1: Laporan Terbarumu --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-sage-200/80 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center space-x-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-sage-700"></div>
                        <span class="text-xs font-semibold text-sage-700">Laporan terbarumu</span>
                    </div>
                    @if($laporanTerbaru)
                        @php
                            $statusBadgeClass = match($laporanTerbaru->status) {
                                'selesai' => 'bg-success-100 text-success-600',
                                'diproses' => 'bg-sage-100 text-sage-700',
                                'ditolak' => 'bg-danger-100 text-danger-600',
                                default => 'bg-warning-100 text-warning-600',
                            };
                        @endphp
                        <span class="text-[11px] px-3 py-1 rounded-full font-medium {{ $statusBadgeClass }}">
                            {{ ucfirst($laporanTerbaru->status) }}
                        </span>
                    @endif
                </div>

                @if($laporanTerbaru)
                    <div class="space-y-4">
                        {{-- Kode Pelacakan --}}
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold font-fraunces text-sage-900">{{ $laporanTerbaru->kode_pelacakan }}</h3>
                            <span class="w-7 h-7 rounded-full bg-sage-100 flex items-center justify-center text-sage-700 text-xs">
                                &nearr;
                            </span>
                        </div>

                        {{-- Detail --}}
                        <p class="text-xs text-sage-500">
                            {{ $laporanTerbaru->anonim ? 'Laporan anonim' : 'Laporan terbuka' }} · Dikirim {{ $laporanTerbaru->created_at->format('d F Y') }}
                        </p>

                        {{-- Step Indicator (Checkmarks like PDF) --}}
                        <div class="pt-3 border-t border-sage-100">
                            <div class="flex items-center space-x-6 text-xs">
                                {{-- Step 1: Diterima --}}
                                <div class="flex items-center space-x-1.5">
                                    <div class="w-5 h-5 rounded-full bg-sage-700 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sage-700 font-medium">Diterima</span>
                                </div>

                                {{-- Step 2: Diverifikasi --}}
                                <div class="flex items-center space-x-1.5">
                                    @if(in_array($laporanTerbaru->status, ['diproses', 'selesai']))
                                        <div class="w-5 h-5 rounded-full bg-sage-700 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                        </div>
                                        <span class="text-sage-700 font-medium">Diverifikasi</span>
                                    @else
                                        <div class="w-5 h-5 rounded-full bg-sage-200 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-sage-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                        </div>
                                        <span class="text-sage-400">Diverifikasi</span>
                                    @endif
                                </div>

                                {{-- Step 3: Diproses --}}
                                <div class="flex items-center space-x-1.5">
                                    @if($laporanTerbaru->status === 'selesai')
                                        <div class="w-5 h-5 rounded-full bg-sage-700 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                        </div>
                                        <span class="text-sage-700 font-medium">Diproses</span>
                                    @else
                                        <div class="w-5 h-5 rounded-full {{ $laporanTerbaru->status === 'diproses' ? 'bg-sage-700' : 'bg-sage-200' }} flex items-center justify-center">
                                            @if($laporanTerbaru->status === 'diproses')
                                                <div class="w-2 h-2 rounded-full bg-white"></div>
                                            @else
                                                <svg class="w-3 h-3 text-sage-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                            @endif
                                        </div>
                                        <span class="{{ $laporanTerbaru->status === 'diproses' ? 'text-sage-700 font-medium' : 'text-sage-400' }}">Diproses</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Info box --}}
                        <div class="bg-sage-100/50 rounded-xl p-3 mt-2">
                            <p class="text-xs text-sage-600 leading-relaxed">
                                Tim sedang menindaklanjuti laporanmu. Pembaruan status akan muncul di notifikasi.
                            </p>
                            <p class="text-[10px] text-sage-400 mt-1">Diperbarui hari ini, {{ now()->format('H:i') }} WIB</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 space-y-4">
                        <div class="w-12 h-12 rounded-full bg-sage-100 text-sage-600 flex items-center justify-center mx-auto text-xl">
                            📋
                        </div>
                        <p class="text-xs text-sage-500">Belum ada laporan yang dikirimkan.</p>
                        <a href="{{ route('pelaporan.buat') }}" class="inline-flex items-center px-4 py-2 bg-sage-700 hover:bg-sage-900 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                            Buat laporan pertamamu &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kolom 2: Konsultasi Mendatang --}}
        <div class="bg-sage-100/60 rounded-2xl p-6 shadow-sm border border-sage-200 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center space-x-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-sage-700"></div>
                        <span class="text-xs font-semibold text-sage-700">Konsultasi mendatang</span>
                    </div>
                    @if($konsultasiMendatang)
                        <span class="text-[11px] px-3 py-1 rounded-full font-medium bg-sage-200 text-sage-700">Pembayaran dikonfirmasi</span>
                    @endif
                </div>

                @if($konsultasiMendatang && $konsultasiMendatang->jadwalKonsultasi)
                    @php $jadwal = $konsultasiMendatang->jadwalKonsultasi; @endphp
                    <div class="space-y-4">
                        {{-- Nama Konselor with Calendar Badge --}}
                        <div class="flex items-start space-x-4">
                            {{-- Calendar date badge --}}
                            <div class="flex-shrink-0 w-14 h-16 bg-white rounded-xl border border-sage-200 flex flex-col items-center justify-center shadow-sm">
                                <span class="text-[9px] font-semibold text-sage-500 uppercase tracking-wider">{{ strtoupper(\Carbon\Carbon::parse($jadwal->tanggal)->format('M')) }}</span>
                                <span class="text-2xl font-bold text-sage-900 leading-none">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-bold text-sage-900">{{ $jadwal->konselor->user->nama ?? 'Konselor' }}</h4>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-[10px] text-sage-600 bg-sage-200 px-2 py-0.5 rounded-full flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>Psikolog terverifikasi</span>
                                    </span>
                                </div>
                                <p class="text-xs text-sage-500 mt-2">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }} · {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }} WIB
                                </p>
                            </div>
                        </div>

                        {{-- Detail row --}}
                        <div class="flex items-center space-x-3 text-[11px] text-sage-600 bg-white/60 rounded-xl p-3 border border-sage-200/60">
                            <span class="bg-sage-200 px-2 py-0.5 rounded-full">Sesi melalui chat</span>
                            <span>·</span>
                            <span>Pengingat 30 menit sebelum sesi</span>
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-xs text-sage-500">60 menit · Rp150.000</span>
                            <a href="{{ route('pengguna.dashboard') }}" class="text-xs font-semibold text-sage-900 hover:underline flex items-center space-x-1">
                                <span>Lihat detail sesi</span>
                                <span>&nearr;</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 space-y-4">
                        <div class="w-12 h-12 rounded-full bg-sage-200 text-sage-700 flex items-center justify-center mx-auto text-xl">
                            💬
                        </div>
                        <p class="text-xs text-sage-600">Belum ada jadwal konsultasi mendatang.</p>
                        {{-- UBAH ROUTE DI BAWAH INI MENJADI KONSULTASI.INDEX --}}
                        <a href="{{ route('konsultasi.index') }}" class="inline-flex items-center px-4 py-2 bg-sage-700 hover:bg-sage-900 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                            Jadwalkan konsultasi &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>