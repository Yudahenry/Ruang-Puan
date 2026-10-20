@extends('layouts.pengguna')

@section('pengguna-content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-berry-900">Riwayat Laporan Saya</h1>
            <p class="text-sm text-ink-600 mt-1">Daftar laporan yang pernah Anda ajukan beserta status penanganannya.</p>
        </div>
        <a href="{{ route('pelaporan.buat') }}" class="px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition-all duration-200 active:scale-[0.98]">
            + Buat Laporan Baru
        </a>
    </div>

    @if($laporans->isEmpty())
        <div class="text-center py-12 bg-cream-50 rounded-xl border border-cream-200">
            <p class="text-ink-600 text-sm mb-3">Belum ada laporan yang Anda buat.</p>
            <a href="{{ route('pelaporan.buat') }}" class="text-rose-600 hover:underline font-medium text-sm">Buat laporan pertama Anda di sini</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-cream-100 text-ink-900 border-b border-cream-200">
                        <th class="p-3">Kode Pelacakan</th>
                        <th class="p-3">Jenis Kasus</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-200">
                    @foreach($laporans as $laporan)
                        <tr class="hover:bg-cream-50">
                            <td class="p-3 font-mono font-semibold text-berry-700">{{ $laporan->kode_pelacakan }}</td>
                            <td class="p-3 capitalize">{{ str_replace('_', ' ', $laporan->jenis_kasus) }}</td>
                            <td class="p-3 text-ink-600">{{ $laporan->created_at?->format('d M Y H:i') }}</td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($laporan->status === 'selesai') bg-success-100 text-success-600
                                    @elseif($laporan->status === 'ditolak' || $laporan->status === 'ditutup') bg-danger-100 text-danger-600
                                    @else bg-warning-100 text-warning-600 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                                </span>
                            </td>
                            <td class="p-3 text-right">
                                <a href="{{ route('pelaporan.lacak', $laporan->kode_pelacakan) }}" class="px-3 py-1.5 bg-cream-100 hover:bg-cream-200 text-ink-900 rounded-lg text-xs font-medium transition">
                                    Lacak / Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $laporans->links() }}
        </div>
    @endif
</div>
@endsection
