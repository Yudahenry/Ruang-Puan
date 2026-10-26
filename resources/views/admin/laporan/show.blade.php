@extends('layouts.admin')

@section('admin-content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-6">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-cream-200">
        <div>
            <h1 class="text-2xl font-bold text-berry-900">Detail & Penanganan Laporan</h1>
            <p class="text-sm font-mono text-berry-700 mt-1">Kode Pelacakan: {{ $laporan->kode_pelacakan }}</p>
        </div>
        <a href="{{ route('admin.laporan.index') }}" class="px-3 py-1.5 bg-cream-100 hover:bg-cream-200 text-ink-900 rounded-lg text-xs font-medium transition">
            &larr; Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-danger-100 border border-danger-600 text-danger-600 p-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-sm">
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Identitas Pelapor</span>
            <p class="font-medium text-ink-900 mt-1">
                @if($laporan->anonim)
                    <span class="text-rose-600 font-bold">🔒 ANONIM (Identitas disembunyikan sesuai NFR-05)</span>
                @else
                    <span class="text-success-600 font-bold">👤 Bernama: {{ $laporan->user->nama ?? '-' }} ({{ $laporan->user->email ?? '-' }})</span>
                @endif
            </p>
        </div>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Jenis Kasus</span>
            <p class="font-medium text-ink-900 capitalize mt-1">{{ str_replace('_', ' ', $laporan->jenis_kasus) }}</p>
        </div>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Waktu Kejadian</span>
            <p class="font-medium text-ink-900 mt-1">{{ $laporan->waktu_kejadian ? \Carbon\Carbon::parse($laporan->waktu_kejadian)->format('d M Y H:i') : 'Tidak dicatat' }}</p>
        </div>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
            <span class="text-xs font-semibold text-ink-600 uppercase">Lokasi Kejadian</span>
            <p class="font-medium text-ink-900 mt-1">{{ $laporan->lokasi_kejadian ?? 'Tidak dicatat' }}</p>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-sm font-semibold text-ink-600 uppercase mb-2">Kronologi Kasus</h3>
        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200 text-sm text-ink-900 leading-relaxed whitespace-pre-line">
            {{ $laporan->kronologi }}
        </div>
    </div>

    @if($laporan->buktiLaporans->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-sm font-semibold text-ink-600 uppercase mb-2">Bukti Pendukung</h3>
            <ul class="space-y-2">
                @foreach($laporan->buktiLaporans as $bukti)
                    <li class="flex items-center justify-between bg-cream-50 p-3 rounded-xl border border-cream-200 text-sm">
                        <span class="font-medium text-berry-700">{{ $bukti->nama_file }}</span>
                        <a href="{{ asset('storage/' . $bukti->lokasi_file) }}" target="_blank" class="px-3 py-1 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-medium transition">
                            Unduh / Lihat
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-8 bg-cream-50 p-6 rounded-2xl border border-cream-200">
        <h3 class="text-base font-bold text-berry-900 mb-4">Perbarui Status & Berikan Tanggapan</h3>
        <form method="POST" action="{{ route('admin.laporan.update', $laporan->id) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="status" class="block text-sm font-medium text-ink-900 mb-1">Status Laporan</label>
                <select id="status" name="status" required
                    class="w-full rounded-lg border-cream-200 bg-white focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
                    <option value="diterima" @selected($laporan->status === 'diterima')>Diterima</option>
                    <option value="diverifikasi" @selected($laporan->status === 'diverifikasi')>Diverifikasi</option>
                    <option value="diproses" @selected($laporan->status === 'diproses')>Diproses</option>
                    <option value="diteruskan_ke_lembaga" @selected($laporan->status === 'diteruskan_ke_lembaga')>Diteruskan ke Lembaga Bantuan</option>
                    <option value="selesai" @selected($laporan->status === 'selesai')>Selesai</option>
                    <option value="ditutup" @selected($laporan->status === 'ditutup')>Ditutup</option>
                </select>
            </div>

            <div>
                <label for="isi_tanggapan" class="block text-sm font-medium text-ink-900 mb-1">Catatan / Tanggapan Admin (Opsional)</label>
                <textarea id="isi_tanggapan" name="isi_tanggapan" rows="4" placeholder="Tulis catatan atau instruksi penanganan untuk laporan ini..."
                    class="w-full rounded-lg border-cream-200 bg-white focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm"></textarea>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition">
                Simpan Pembaruan
            </button>
        </form>
    </div>

    <div class="mb-4">
        <h3 class="text-sm font-semibold text-ink-600 uppercase mb-3">Riwayat Tanggapan Sebelumnya</h3>
        @if($laporan->tanggapanLaporans->isEmpty())
            <p class="text-sm text-ink-600 bg-cream-50 p-4 rounded-xl border border-cream-200">Belum ada tanggapan yang tercatat.</p>
        @else
            <div class="space-y-4">
                @foreach($laporan->tanggapanLaporans as $tanggapan)
                    <div class="bg-cream-50 p-4 rounded-xl border border-cream-200">
                        <div class="flex items-center justify-between text-xs text-ink-600 mb-2">
                            <span>Status: <strong class="capitalize">{{ str_replace('_', ' ', $tanggapan->status_laporan_saat_itu) }}</strong> oleh Admin</span>
                            <span>{{ $tanggapan->created_at ? \Carbon\Carbon::parse($tanggapan->created_at)->format('d M Y H:i') : '' }}</span>
                        </div>
                        <p class="text-sm text-ink-900 leading-relaxed">{{ $tanggapan->isi_tanggapan }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
