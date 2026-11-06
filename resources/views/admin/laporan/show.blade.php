@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Tombol Kembali & Judul -->
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Detail Laporan #{{ $laporan->id }}</h2>
            <p class="text-sm text-gray-600">Periksa informasi laporan dan perbarui status penanganannya.</p>
        </div>
        <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informasi Utama Laporan -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h3 class="text-md font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Kasus</h3>

                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <span class="block text-gray-500">Pelapor:</span>
                        <span class="font-medium text-gray-800">{{ $laporan->user->name ?? 'Anonim' }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500">Tanggal Laporan:</span>
                        <span class="font-medium text-gray-800">{{ $laporan->created_at?->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                </div>

                <div class="mb-4 text-sm">
                    <span class="block text-gray-500 mb-1">Isi Kronologi / Keterangan:</span>
                    <div class="p-3 bg-gray-50 rounded-lg text-gray-700 whitespace-pre-line border">
                        {{ $laporan->kronologi ?? $laporan->deskripsi ?? 'Tidak ada keterangan.' }}
                    </div>
                </div>
            </div>

            <!-- Riwayat Tanggapan Admin -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h3 class="text-md font-semibold text-gray-800 mb-4 border-b pb-2">Riwayat Tindak Lanjut</h3>
                <div class="space-y-4">
                    @forelse($laporan->tanggapanLaporans as $tanggapan)
                        <div class="p-3 bg-indigo-50/50 rounded-lg border border-indigo-100 text-sm">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span class="font-semibold text-indigo-700">{{ $tanggapan->admin->user->name ?? 'Admin' }}</span>
                                <span>{{ $tanggapan->created_at?->format('d M Y H:i') ?? '-' }}</span>
                            </div>
                            <p class="text-gray-700">{{ $tanggapan->isi_tanggapan }}</p>
                            <span class="inline-block mt-2 px-2 py-0.5 text-xs bg-indigo-100 text-indigo-800 rounded">
                                Status saat itu: {{ ucwords(str_replace('_', ' ', $tanggapan->status_laporan_saat_itu)) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Belum ada tanggapan atau catatan tindak lanjut.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Panel Update Status (Aksi Admin) -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h3 class="text-md font-semibold text-gray-800 mb-4 border-b pb-2">Perbarui Status</h3>

                <div class="mb-4 text-sm">
                    <span class="block text-gray-500 mb-1">Status Saat Ini:</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        {{ ucwords(str_replace('_', ' ', $laporan->status)) }}
                    </span>
                </div>

                <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 font-medium mb-1">Ubah Status Menjadi:</label>
                        <select name="status" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="diverifikasi" {{ $laporan->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="diteruskan_ke_lembaga" {{ $laporan->status == 'diteruskan_ke_lembaga' ? 'selected' : '' }}>Diteruskan ke Lembaga</option>
                            <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditutup" {{ $laporan->status == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 font-medium mb-1">Catatan / Tanggapan Admin:</label>
                        <textarea name="isi_tanggapan" rows="4" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tuliskan catatan tindak lanjut untuk pelapor..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
