@extends('layouts.konselor')

@section('konselor-content')
<div class="bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-6 sm:p-8">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-[#DCD5DD]">
        <div>
            <h1 class="text-2xl font-serif font-bold text-[#3E293F] tracking-tight">Kelola Jadwal Praktik</h1>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1">Buat slot waktu luang Anda agar klien/pengguna dapat melihat dan melakukan pemesanan (booking).</p>
        </div>
        <div>
            <a href="{{ route('konselor.dashboard') }}" class="inline-flex items-center text-xs font-semibold text-[#643B62] hover:text-[#3E293F] transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl text-xs font-semibold shadow-2xs border border-green-500/30">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-2xl text-xs font-semibold shadow-2xs border border-red-500/30">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Konselor Menambahkan Jadwal Praktik --}}
    <form action="{{ route('konselor.jadwal.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8 pb-8 border-b border-[#DCD5DD]">
        @csrf
        <div>
            <label class="block text-xs font-bold text-[#3E293F] mb-1.5">Tanggal Praktik</label>
            <input type="date" name="tanggal" required class="w-full rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] text-xs p-3 text-[#3E293F] focus:ring-1 focus:ring-[#643B62] focus:border-[#643B62] focus:outline-none shadow-inner transition">
        </div>
        <div>
            <label class="block text-xs font-bold text-[#3E293F] mb-1.5">Jam Mulai</label>
            <input type="time" name="jam_mulai" required class="w-full rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] text-xs p-3 text-[#3E293F] focus:ring-1 focus:ring-[#643B62] focus:border-[#643B62] focus:outline-none shadow-inner transition">
        </div>
        <div>
            <label class="block text-xs font-bold text-[#3E293F] mb-1.5">Jam Selesai</label>
            <input type="time" name="jam_selesai" required class="w-full rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] text-xs p-3 text-[#3E293F] focus:ring-1 focus:ring-[#643B62] focus:border-[#643B62] focus:outline-none shadow-inner transition">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition active:scale-[0.98]">
                + Tambah Slot Jadwal
            </button>
        </div>
    </form>

    {{-- Tabel Daftar Slot Jadwal yang Dibuat Konselor --}}
    <h3 class="font-serif font-bold text-[#3E293F] text-base mb-4">Daftar Slot Waktu Anda</h3>
    <div class="overflow-x-auto rounded-2xl border border-[#DCD5DD]">
        <table class="w-full text-left text-xs text-[#3E293F] border-collapse">
            <thead>
                <tr class="bg-[#EEE7F2]/60 border-b border-[#DCD5DD] text-[#3E293F]">
                    <th class="p-4 font-bold">Tanggal</th>
                    <th class="p-4 font-bold">Waktu</th>
                    <th class="p-4 font-bold">Status</th>
                    <th class="p-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
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
                            $statusClass = 'bg-red-600 text-white border border-red-700 shadow-2xs';
                        } elseif ($hasPesanan) {
                            $statusLabel = 'Terpesan';
                            $statusClass = 'bg-amber-100 text-amber-700';
                        } else {
                            $statusLabel = ucfirst($jadwal->status ?? 'tersedia');
                            $statusClass = 'bg-green-100 text-green-700';
                        }
                    @endphp
                    <tr class="border-b border-[#DCD5DD]/50 hover:bg-[#FCFAF8] transition">
                        <td class="p-4 font-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</td>
                        <td class="p-4 text-[#746B77]">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-semibold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                            @if($daftarPesanan->isNotEmpty())
                                <span class="ml-1.5 text-[11px] text-[#746B77]">({{ $daftarPesanan->count() }} pemesan)</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center justify-end gap-3">
                                {{-- Tombol Mata untuk melihat siapa saja yang booking pada jam sesi ini --}}
                                <button type="button"
                                        onclick="togglePemesan({{ $jadwal->id }})"
                                        title="Lihat daftar pemesan pada sesi ini"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl border border-[#DCD5DD] bg-white hover:bg-[#EEE7F2]/70 text-[#643B62] font-semibold transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="text-[11px]">Pemesan</span>
                                </button>

                                <form action="{{ route('konselor.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Panel Daftar Pemesan pada Sesi Ini (Muncul saat tombol mata diklik) --}}
                    <tr id="pemesan-row-{{ $jadwal->id }}" class="hidden bg-[#FCFAF8] border-b border-[#DCD5DD]/70">
                        <td colspan="4" class="px-5 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-bold text-[#3E293F]">
                                    Daftar Pengguna yang Booking Sesi {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB
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
                                        <div class="bg-white border border-[#DCD5DD] rounded-2xl px-3.5 py-2.5 flex items-center justify-between gap-2">
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
                    <tr>
                        <td colspan="4" class="text-center py-12 text-[#746B77]">Belum ada slot jadwal praktik yang Anda buat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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