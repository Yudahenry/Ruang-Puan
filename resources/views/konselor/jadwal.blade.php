@extends('layouts.konselor')

@section('konselor-content')
@php
    $profilLengkap = isset($konselor) ? $konselor->isProfilLengkap() : false;
    $detailKelengkapan = isset($konselor) ? $konselor->kelengkapanProfil() : null;
@endphp

<div class="space-y-8 max-w-7xl mx-auto py-2 pb-16">

    <!-- ================================================================= -->
    <!-- 1. HEADER CARD DENGAN AKSEN HALUS & BREADCRUMB                    -->
    <!-- ================================================================= -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-white via-[#FCFAF8] to-[#EEE7F2]/40 border border-[#DCD5DD] p-6 sm:p-8 shadow-xs">
        <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-[#643B62]/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-[10px] font-bold text-[#643B62] uppercase tracking-widest">Manajemen Waktu</span>
                    <span class="text-[#DCD5DD]">&bull;</span>
                    <span class="text-xs text-[#746B77]">Slot Konsultasi Klien</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] tracking-tight">Kelola Jadwal Praktik</h1>
                <p class="text-xs sm:text-sm text-[#746B77] mt-1 font-light max-w-xl">
                    Buat dan atur slot waktu luang Anda agar klien dapat melihat ketersediaan Anda dan melakukan pemesanan (booking) konsultasi.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('konselor.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-[#EEE7F2] text-[#643B62] hover:text-[#3E293F] rounded-xl text-xs font-semibold border border-[#DCD5DD] shadow-2xs transition group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi Flash (Menggunakan SVG Icons Outline) -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 rounded-2xl text-xs font-semibold shadow-2xs border border-emerald-300 flex items-center gap-3">
            <div class="w-6 h-6 rounded-full bg-emerald-200 text-emerald-800 flex items-center justify-center shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 text-rose-800 rounded-2xl text-xs font-semibold shadow-2xs border border-rose-300 flex items-center gap-3">
            <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-800 flex items-center justify-center shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('warning'))
        <div class="p-4 bg-amber-50 text-amber-800 rounded-2xl text-xs font-semibold shadow-2xs border border-amber-300 flex items-center gap-3">
            <div class="w-6 h-6 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <span>{{ session('warning') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-rose-50 text-rose-800 rounded-2xl text-xs font-semibold shadow-2xs border border-rose-300">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Banner Peringatan jika Profil Belum Lengkap -->
    @if(!$profilLengkap)
        <div class="p-6 bg-gradient-to-r from-amber-50 via-white to-amber-50/70 border-2 border-amber-300 rounded-3xl text-amber-900 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="space-y-2 flex-1">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-xl bg-amber-200 text-amber-900 flex items-center justify-center text-xs font-bold shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <h4 class="font-bold text-sm text-[#3E293F]">Pembuatan Jadwal Praktik Terkunci Sementara</h4>
                </div>
                <p class="text-xs text-[#746B77] max-w-2xl leading-relaxed font-light">
                    Profil dan dokumen kredensial Anda baru terisi <strong class="tabular-nums font-semibold text-[#3E293F]">{{ $detailKelengkapan['persentase'] ?? 0 }}%</strong>. Anda wajib melengkapi data profil, informasi tarif, spesialisasi, dan nomor/dokumen STR & SIPP sebelum dapat membuka slot jadwal konsultasi untuk klien.
                </p>
                @if(!empty($detailKelengkapan['missing']))
                    <p class="text-[11px] text-amber-900 font-semibold pt-1">
                        Belum diisi: {{ implode(', ', array_slice($detailKelengkapan['missing'], 0, 4)) }}{{ count($detailKelengkapan['missing']) > 4 ? ', dll.' : '' }}
                    </p>
                @endif
            </div>
            <a href="{{ route('konselor.profil.edit') }}" 
               class="px-5 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-bold transition shrink-0 inline-flex items-center gap-2 shadow-sm hover:shadow-md group">
                <span>Lengkapi Profil Sekarang</span>
                <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
            </a>
        </div>
    @endif

    <!-- ================================================================= -->
    <!-- 2. FORM TAMBAH JADWAL PRAKTIK                                     -->
    <!-- ================================================================= -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-xs">
        <div class="flex items-center gap-2.5 pb-4 mb-6 border-b border-[#DCD5DD]/60">
            <span class="w-2.5 h-2.5 rounded-full bg-[#643B62]"></span>
            <h2 class="text-lg font-serif font-bold text-[#3E293F]">Tambah Slot Praktik Baru</h2>
        </div>

        <form action="{{ route('konselor.jadwal.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 {{ !$profilLengkap ? 'opacity-60' : '' }}">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#3E293F] mb-1.5">Tanggal Praktik</label>
                <input type="date" name="tanggal" required {{ !$profilLengkap ? 'disabled' : '' }} class="w-full rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] text-xs p-3.5 text-[#3E293F] focus:ring-1 focus:ring-[#643B62] focus:border-[#643B62] focus:outline-none shadow-2xs transition {{ !$profilLengkap ? 'cursor-not-allowed bg-stone-100' : '' }}">
            </div>
            <div>
                <label class="block text-xs font-bold text-[#3E293F] mb-1.5">Jam Mulai</label>
                <input type="time" name="jam_mulai" required {{ !$profilLengkap ? 'disabled' : '' }} class="w-full rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] text-xs p-3.5 text-[#3E293F] focus:ring-1 focus:ring-[#643B62] focus:border-[#643B62] focus:outline-none shadow-2xs transition {{ !$profilLengkap ? 'cursor-not-allowed bg-stone-100' : '' }}">
            </div>
            <div>
                <label class="block text-xs font-bold text-[#3E293F] mb-1.5">Jam Selesai</label>
                <input type="time" name="jam_selesai" required {{ !$profilLengkap ? 'disabled' : '' }} class="w-full rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] text-xs p-3.5 text-[#3E293F] focus:ring-1 focus:ring-[#643B62] focus:border-[#643B62] focus:outline-none shadow-2xs transition {{ !$profilLengkap ? 'cursor-not-allowed bg-stone-100' : '' }}">
            </div>
            <div class="flex items-end">
                @if($profilLengkap)
                    <button type="submit" class="w-full px-5 py-3.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm hover:shadow-md transition active:scale-[0.98] flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>+ Tambah Slot Jadwal</span>
                    </button>
                @else
                    <button type="button" disabled title="Lengkapi profil dan kredensial terlebih dahulu" class="w-full px-5 py-3.5 bg-stone-100 text-stone-500 rounded-2xl text-xs font-semibold cursor-not-allowed border border-stone-300 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Slot Terkunci</span>
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- ================================================================= -->
    <!-- 3. TABEL DAFTAR SLOT JADWAL PRAKTIK                              -->
    <!-- ================================================================= -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-xs">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#DCD5DD]/60">
            <div>
                <span class="text-[10px] font-bold text-[#643B62] uppercase tracking-widest block">Daftar Slot Waktu</span>
                <h3 class="text-xl font-serif font-bold text-[#3E293F] mt-0.5">Jadwal Praktik Anda</h3>
            </div>
            <span class="text-xs font-medium text-[#746B77] bg-[#FCFAF8] px-3.5 py-1.5 rounded-full border border-[#DCD5DD] tabular-nums">
                Total: {{ count($jadwals ?? []) }} slot
            </span>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-[#DCD5DD]">
            <table class="w-full text-left text-xs text-[#3E293F] border-collapse">
                <thead>
                    <tr class="bg-[#FCFAF8] border-b border-[#DCD5DD] text-[#746B77] uppercase text-[10px] tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Tanggal Praktik</th>
                        <th class="py-3.5 px-4 font-semibold">Waktu Konsultasi</th>
                        <th class="py-3.5 px-4 font-semibold">Status Slot</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD5DD]/50">
                    @forelse($jadwals as $jadwal)
                        @php
                            $daftarPesanan = $jadwal->pemesanans ?? $jadwal->bookings ?? collect();

                            // Fallback ambil langsung dari model Pemesanan jika relasi di $jadwal kosong
                            if ($daftarPesanan->isEmpty() && class_exists(\App\Models\Pemesanan::class)) {
                                $daftarPesanan = \App\Models\Pemesanan::with('user')
                                    ->where('jadwal_id', $jadwal->id)
                                    ->latest()
                                    ->get();
                            }

                            // Cek apakah waktu sesi (tanggal + jam_selesai) sudah habis
                            $tanggalSaja = \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d');
                            $jamSelesaiStr = $jadwal->jam_selesai ?: ($jadwal->jam_mulai ?: '23:59:59');
                            if (strlen($jamSelesaiStr) === 5) {
                                $jamSelesaiStr .= ':00';
                            }
                            $waktuBerakhir = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tanggalSaja . ' ' . $jamSelesaiStr, config('app.timezone'));
                            $isSesiHabis = now()->greaterThanOrEqualTo($waktuBerakhir);

                            $hasPesanan = $daftarPesanan->isNotEmpty() || strtolower($jadwal->status ?? '') === 'terpesan';

                            if ($isSesiHabis) {
                                $statusLabel = 'Selesai';
                                $statusClass = 'bg-stone-100 text-stone-700 border-stone-200';
                                $dotClass = 'bg-stone-400';
                            } elseif ($hasPesanan) {
                                $statusLabel = 'Terpesan';
                                $statusClass = 'bg-amber-50 text-amber-800 border-amber-200';
                                $dotClass = 'bg-amber-500';
                            } else {
                                $statusLabel = ucfirst($jadwal->status ?? 'tersedia');
                                $statusClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                                $dotClass = 'bg-emerald-500';
                            }
                        @endphp
                        <tr class="hover:bg-[#FCFAF8] transition">
                            <td class="py-4 px-4 font-medium text-[#3E293F]">
                                <div class="font-bold">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</div>
                                <span class="text-[10px] text-[#746B77] font-light">{{ \Carbon\Carbon::parse($jadwal->tanggal)->diffForHumans() }}</span>
                            </td>
                            <td class="py-4 px-4 text-[#746B77] tabular-nums font-medium">
                                <span class="px-2.5 py-1 rounded-lg bg-[#EEE7F2]/60 text-[#643B62] border border-[#DCD5DD]/60 font-semibold">
                                    {{ substr($jadwal->jam_mulai, 0, 5) }} &ndash; {{ substr($jadwal->jam_selesai, 0, 5) }} WIB
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-semibold border {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                    <span>{{ $statusLabel }}</span>
                                </span>
                                @if($daftarPesanan->isNotEmpty())
                                    <span class="ml-1.5 text-[11px] text-[#746B77]">({{ $daftarPesanan->count() }} pemesan)</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    @if($daftarPesanan->isNotEmpty())
                                    <button type="button"
                                            onclick="togglePemesan({{ $jadwal->id }})"
                                            title="Lihat daftar pemesan pada sesi ini"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl border border-[#DCD5DD] bg-[#FCFAF8] hover:bg-[#EEE7F2] text-[#643B62] font-semibold transition text-xs shadow-2xs cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Pemesan</span>
                                    </button>
                                    @endif

                                    <form action="{{ route('konselor.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus slot jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-xl font-semibold transition text-xs inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Panel Daftar Pemesan pada Sesi Ini (Muncul saat tombol pemesan diklik) --}}
                        <tr id="pemesan-row-{{ $jadwal->id }}" class="hidden bg-[#FCFAF8]">
                            <td colspan="4" class="px-5 py-4 border-t border-[#DCD5DD]/50">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-xs font-bold text-[#3E293F]">
                                        Daftar Pengguna yang Booking Sesi ({{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB)
                                    </p>
                                    <span class="text-[11px] text-[#746B77]">Total: {{ $daftarPesanan->count() }} orang</span>
                                </div>

                                @if($daftarPesanan->isNotEmpty())
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
                                        @foreach($daftarPesanan as $index => $pesanan)
                                            @php
                                                $pemesan = $pesanan->user ?? null;
                                                $namaPemesan = $pemesan?->nama ?? $pemesan?->name ?? $pemesan?->email ?? 'Pengguna #' . ($pesanan->user_id ?? ($index + 1));
                                                $emailPemesan = $pemesan?->email;
                                            @endphp
                                            <div class="bg-white border border-[#DCD5DD] rounded-2xl px-3.5 py-2.5 flex items-center justify-between gap-2 shadow-2xs">
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold text-[#3E293F] truncate">
                                                        {{ $index + 1 }}. {{ $namaPemesan }}
                                                    </p>
                                                    @if($emailPemesan && $namaPemesan !== $emailPemesan)
                                                        <p class="text-[11px] text-[#746B77] truncate">{{ $emailPemesan }}</p>
                                                    @endif
                                                </div>
                                                @if(!empty($pesanan->status))
                                                    <span class="px-2 py-0.5 rounded-full bg-[#EEE7F2] text-[#643B62] text-[10px] font-semibold whitespace-nowrap">
                                                        {{ ucfirst(str_replace('_', ' ', $pesanan->status)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-[#746B77]">Belum ada data pemesanan yang tercatat pada slot jadwal ini.</p>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State Berbingkai Indah --}}
                        <tr>
                            <td colspan="4" class="text-center py-12 px-4">
                                <div class="w-16 h-16 rounded-3xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto mb-3 ring-8 ring-[#EEE7F2]/40 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-serif font-bold text-[#3E293F]">Belum Ada Slot Jadwal Praktik</h4>
                                <p class="text-xs text-[#746B77] mt-1 max-w-sm mx-auto font-light leading-relaxed">
                                    Gunakan form di atas untuk menentukan tanggal dan jam konsultasi yang siap Anda layani bagi klien.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function togglePemesan(jadwalId) {
        const row = document.getElementById('pemesan-row-' + jadwalId);
        if (!row) return;
        row.classList.toggle('hidden');
    }
</script>
@endsection
