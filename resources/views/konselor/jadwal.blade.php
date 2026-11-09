@extends('layouts.konselor')

@section('konselor-content')
<div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-cream-200">
        <div>
            <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Kelola Jadwal Praktik</h1>
            <p class="text-sm text-ink-600 mt-1">Buat slot waktu luang Anda agar klien/pengguna dapat melihat dan melakukan pemesanan (booking).</p>
        </div>
        <div>
            <a href="{{ route('konselor.dashboard') }}" class="inline-flex items-center text-xs font-semibold text-berry-700 hover:text-berry-900 transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-success-100 text-success-600 rounded-lg text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Konselor Menambahkan Jadwal Praktik --}}
    <form action="{{ route('konselor.jadwal.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8 pb-6 border-b border-cream-200">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-ink-700 mb-1">Tanggal Praktik</label>
            <input type="date" name="tanggal" required class="w-full rounded-lg border-cream-300 text-xs p-2.5 focus:ring-berry-700 focus:border-berry-700">
        </div>
        <div>
            <label class="block text-xs font-semibold text-ink-700 mb-1">Jam Mulai</label>
            <input type="time" name="jam_mulai" required class="w-full rounded-lg border-cream-300 text-xs p-2.5 focus:ring-berry-700 focus:border-berry-700">
        </div>
        <div>
            <label class="block text-xs font-semibold text-ink-700 mb-1">Jam Selesai</label>
            <input type="time" name="jam_selesai" required class="w-full rounded-lg border-cream-300 text-xs p-2.5 focus:ring-berry-700 focus:border-berry-700">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-2.5 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                + Tambah Slot Jadwal
            </button>
        </div>
    </form>

    {{-- Tabel Daftar Slot Jadwal yang Dibuat Konselor --}}
    <h3 class="font-bold text-berry-900 text-base mb-4">Daftar Slot Waktu Anda</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-ink-700 border-collapse">
            <thead>
                <tr class="bg-cream-50 border-b border-cream-200 text-berry-900">
                    <th class="p-3 font-semibold">Tanggal</th>
                    <th class="p-3 font-semibold">Waktu</th>
                    <th class="p-3 font-semibold">Status</th>
                    <th class="p-3 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr class="border-b border-cream-100 hover:bg-cream-50/50">
                        <td class="p-3 font-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</td>
                        <td class="p-3">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB</td>
                        <td class="p-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold 
                                {{ $jadwal->status === 'tersedia' ? 'bg-success-100 text-success-600' : 'bg-warning-100 text-warning-600' }}">
                                {{ ucfirst($jadwal->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <form action="{{ route('konselor.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger-600 hover:underline font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-ink-500">Belum ada slot jadwal praktik yang Anda buat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection