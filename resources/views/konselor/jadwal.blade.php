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
                    <tr class="border-b border-[#DCD5DD]/50 hover:bg-[#FCFAF8] transition">
                        <td class="p-4 font-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</td>
                        <td class="p-4 text-[#746B77]">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB</td>
                        <td class="p-4">
                            @php
                                $statusClass = $jadwal->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-semibold {{ $statusClass }}">
                                {{ ucfirst($jadwal->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('konselor.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                            </form>
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
@endsection