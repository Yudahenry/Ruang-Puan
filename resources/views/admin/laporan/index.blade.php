@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-berry-900">Kelola Laporan Masuk</h1>
            <p class="text-sm text-ink-600 mt-1">Tinjau dan perbarui status laporan kasus kekerasan.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.laporan.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request('status') == '' ? 'bg-berry-700 text-white' : 'bg-cream-100 text-ink-900' }}">Semua</a>
            <a href="{{ route('admin.laporan.index', ['status' => 'diterima']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request('status') == 'diterima' ? 'bg-berry-700 text-white' : 'bg-cream-100 text-ink-900' }}">Diterima</a>
            <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request('status') == 'diproses' ? 'bg-berry-700 text-white' : 'bg-cream-100 text-ink-900' }}">Diproses</a>
            <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request('status') == 'selesai' ? 'bg-berry-700 text-white' : 'bg-cream-100 text-ink-900' }}">Selesai</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-cream-100 text-ink-900 border-b border-cream-200">
                    <th class="p-3">Kode Pelacakan</th>
                    <th class="p-3">Pelapor</th>
                    <th class="p-3">Jenis Kasus</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cream-200">
                @forelse($laporans as $laporan)
                    <tr class="hover:bg-cream-50">
                        <td class="p-3 font-mono font-semibold text-berry-700">{{ $laporan->kode_pelacakan }}</td>
                        <td class="p-3">
                            @if($laporan->anonim)
                                <span class="text-rose-600 font-medium italic">🔒 Anonim (Dirahasiakan)</span>
                            @else
                                <span class="font-medium text-ink-900">{{ $laporan->user->nama ?? '-' }}</span>
                            @endif
                        </td>
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
                            <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="px-3 py-1.5 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-medium transition">
                                Tinjau & Tanggapi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-ink-600">Tidak ada laporan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $laporans->withQueryString()->links() }}
    </div>
</div>
@endsection
