@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kelola Laporan Masuk</h2>
            <p class="text-sm text-gray-600">Periksa, verifikasi, dan perbarui status penanganan laporan pengguna.</p>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Data Laporan -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-amber-50/50 text-gray-700 text-sm border-b">
                        <th class="p-3"># ID</th>
                        <th class="p-3">Pelapor</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($laporans as $laporan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 font-medium">{{ $laporan->id }}</td>
                        <td class="p-3">{{ $laporan->user->name ?? 'Anonim' }}</td>
                        <td class="p-3">{{ $laporan->created_at->format('d M Y') }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                @if($laporan->status == 'selesai') bg-green-100 text-green-800
                                @elseif($laporan->status == 'diproses') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucwords(str_replace('_', ' ', $laporan->status)) }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="px-3 py-1 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700 transition">
                                Periksa
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada laporan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginasi -->
            <div class="mt-4 p-3">
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
