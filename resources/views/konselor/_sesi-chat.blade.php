@php
    $sesiChatKonselor = \App\Models\Konsultasi::with([
            'pemesanan.jadwalKonsultasi',
            'pemesanan.user',
        ])
        ->whereHas('pemesanan.jadwalKonsultasi.konselor', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->whereHas('pemesanan', function ($q) {
            $q->where('status', 'terkonfirmasi');
        })
        ->get()
        ->filter(fn ($k) => in_array($k->status_efektif, ['terjadwal', 'berlangsung']))
        ->sortBy(fn ($k) => $k->waktuMulai()?->timestamp ?? PHP_INT_MAX)
        ->take(5);
@endphp

<div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-lg shadow-inner">
                💬
            </div>
            <div>
                <h2 class="text-xl font-serif font-bold text-[#3E293F]">Sesi Chat Konsultasi</h2>
                <p class="text-xs text-[#746B77]">Daftar sesi konsultasi aktif dan mendatang yang telah dikonfirmasi.</p>
            </div>
        </div>
        <a href="{{ route('konselor.riwayat') }}" class="text-xs font-semibold text-[#643B62] hover:text-[#3E293F] transition flex items-center gap-1 group">
            <span>Riwayat sesi</span>
            <span class="transform group-hover:translate-x-0.5 transition">&rarr;</span>
        </a>
    </div>

    @if($sesiChatKonselor->isEmpty())
        <div class="text-center py-8 border border-dashed border-[#DCD5DD] rounded-2xl bg-[#FCFAF8]/60">
            <p class="text-xs text-[#746B77]">Belum ada sesi chat yang sedang berlangsung atau terjadwal saat ini.</p>
            <a href="{{ route('konselor.riwayat') }}" class="inline-block mt-2 text-xs font-semibold text-[#643B62] hover:underline">
                Lihat semua riwayat sesi &rarr;
            </a>
        </div>
    @else
        <div class="divide-y divide-[#DCD5DD]/50">
            @foreach($sesiChatKonselor as $sesi)
                @php
                    $klien = $sesi->pemesanan?->user;
                    // Privasi ketat FR-03: gunakan alias, jika kosong tampilkan Klien #ID
                    $aliasKlien = !empty($klien?->alias) ? $klien->alias : ('Klien #' . ($klien?->id ?? $sesi->id));
                    $jadwal = $sesi->pemesanan?->jadwalKonsultasi;
                    $isBerlangsung = $sesi->status_efektif === 'berlangsung';
                @endphp
                <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start sm:items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-2xl {{ $isBerlangsung ? 'bg-emerald-100 text-emerald-800' : 'bg-[#EEE7F2] text-[#643B62]' }} flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-xs">
                            {{ strtoupper(substr($aliasKlien, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-serif font-bold text-[#3E293F]">{{ $aliasKlien }}</h3>
                                @if($isBerlangsung)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Sedang Berlangsung
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                        Terjadwal
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-[#746B77] mt-0.5">
                                {{ $jadwal ? \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') : '-' }} ·
                                {{ $jadwal ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') . '–' . \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') . ' WIB' : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-end sm:self-center">
                        @if($isBerlangsung)
                            <a href="{{ route('konsultasi.chat', $sesi->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-xs transition">
                                <span>Masuk Chat</span>
                                <span>&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('konsultasi.chat', $sesi->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#746B77] hover:text-[#3E293F] border border-[#DCD5DD] rounded-xl text-xs font-semibold transition">
                                <span>Belum dimulai</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
