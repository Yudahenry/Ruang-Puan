@extends('layouts.konselor')

@php
    $input = 'w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition';
    $tombol = 'px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition-all duration-200 active:scale-[0.98]';
    $tabs = [
        'identitas' => 'Identitas Profesional',
        'kredensial' => 'Kredensial',
        'layanan' => 'Layanan',
        'rekening' => 'Rekening',
        'kode-etik' => 'Kode Etik',
    ];
    $tabCalon = old('_bagian', request('tab', 'identitas'));
    $tabAwal = array_key_exists($tabCalon, $tabs) ? $tabCalon : 'identitas';
    $status = $konselor->status_verifikasi ?? 'menunggu';
@endphp

@section('konselor-content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 my-6"
     x-data="{ activeTab: '{{ $tabAwal }}' }">

    <div class="mb-6 pb-4 border-b border-cream-200">
        <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Profil Profesional</h1>
        <p class="text-sm text-ink-600 mt-0.5">
            Lengkapi data profesional Anda. Nama, foto, dan kata sandi diatur di halaman
            <a href="{{ route('profile.edit') }}" class="font-semibold text-berry-700 hover:underline">Dokumen &amp; Profil</a>.
        </p>
    </div>

    <!-- Navigasi Tab -->
    <div class="mb-6 flex flex-wrap items-center gap-1 bg-cream-50 p-1 rounded-lg border border-cream-200">
        @foreach($tabs as $kunci => $label)
            <button type="button" @click="activeTab = '{{ $kunci }}'"
                    :class="activeTab === '{{ $kunci }}' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @if($errors->any())
        <div class="mb-6 bg-danger-100 border border-danger-600 text-danger-600 p-4 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tab: Identitas Profesional -->
    <form method="POST" action="{{ route('konselor.profil.update', 'identitas') }}" x-show="activeTab === 'identitas'" class="space-y-5" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="_bagian" value="identitas">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="gelar" class="block text-sm font-semibold text-ink-900 mb-1.5">Gelar</label>
                <input id="gelar" type="text" name="gelar" value="{{ old('gelar', $konselor->gelar) }}" placeholder="Contoh: M.Psi., Psikolog" class="{{ $input }}">
            </div>
            <div>
                <label for="pengalaman_tahun" class="block text-sm font-semibold text-ink-900 mb-1.5">Pengalaman (tahun)</label>
                <input id="pengalaman_tahun" type="number" min="0" max="60" name="pengalaman_tahun" value="{{ old('pengalaman_tahun', $konselor->pengalaman_tahun) }}" class="{{ $input }}">
            </div>
        </div>

        <div>
            <label for="pendidikan" class="block text-sm font-semibold text-ink-900 mb-1.5">Pendidikan</label>
            <textarea id="pendidikan" name="pendidikan" rows="3" placeholder="Contoh: S1 Psikologi, Universitas ...; S2 Psikologi Profesi, Universitas ..." class="{{ $input }}">{{ old('pendidikan', $konselor->pendidikan) }}</textarea>
        </div>

        <div>
            <label for="bahasa" class="block text-sm font-semibold text-ink-900 mb-1.5">Bahasa yang Dikuasai</label>
            <input id="bahasa" type="text" name="bahasa" value="{{ old('bahasa', $konselor->bahasa) }}" placeholder="Contoh: Indonesia, Inggris, Jawa" class="{{ $input }}">
        </div>

        <div>
            <label for="bio" class="block text-sm font-semibold text-ink-900 mb-1.5">Bio Singkat</label>
            <textarea id="bio" name="bio" rows="5" maxlength="1000" placeholder="Ceritakan singkat pendekatan dan pengalaman Anda (maksimal 1000 karakter)" class="{{ $input }}">{{ old('bio', $konselor->bio) }}</textarea>
        </div>

        <div class="flex justify-end pt-5 border-t border-cream-200">
            <button type="submit" class="{{ $tombol }}">Simpan Identitas</button>
        </div>
    </form>

    <!-- Tab: Kredensial -->
    <form method="POST" action="{{ route('konselor.profil.update', 'kredensial') }}" enctype="multipart/form-data" x-show="activeTab === 'kredensial'" class="space-y-5" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="_bagian" value="kredensial">

        <div class="p-4 rounded-xl border flex items-center justify-between
            @if($status === 'disetujui') bg-success-100/50 border-success-600/30 text-success-600
            @elseif($status === 'ditolak') bg-danger-100/50 border-danger-600/30 text-danger-600
            @else bg-warning-100/50 border-warning-600/30 text-warning-600 @endif">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Status Verifikasi (hanya dibaca)</span>
                <span class="text-sm font-semibold capitalize">{{ $status }}</span>
                @if($konselor->alasan_penolakan)
                    <p class="text-xs mt-1">Alasan: {{ $konselor->alasan_penolakan }}</p>
                @endif
            </div>
        </div>

        <p class="text-xs text-ink-600">Mengubah nomor STR/SIPP atau mengunggah dokumen baru akan mengembalikan status verifikasi menjadi menunggu.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="no_str" class="block text-sm font-semibold text-ink-900 mb-1.5">Nomor STR</label>
                <input id="no_str" type="text" name="no_str" value="{{ old('no_str', $konselor->no_str) }}" class="{{ $input }}">
            </div>
            <div>
                <label for="masa_berlaku_str" class="block text-sm font-semibold text-ink-900 mb-1.5">Masa Berlaku STR</label>
                <input id="masa_berlaku_str" type="date" name="masa_berlaku_str" value="{{ old('masa_berlaku_str', optional($konselor->masa_berlaku_str)->format('Y-m-d')) }}" class="{{ $input }}">
            </div>
            <div>
                <label for="no_sipp" class="block text-sm font-semibold text-ink-900 mb-1.5">Nomor SIPP</label>
                <input id="no_sipp" type="text" name="no_sipp" value="{{ old('no_sipp', $konselor->no_sipp) }}" class="{{ $input }}">
            </div>
            <div>
                <label for="masa_berlaku_sipp" class="block text-sm font-semibold text-ink-900 mb-1.5">Masa Berlaku SIPP</label>
                <input id="masa_berlaku_sipp" type="date" name="masa_berlaku_sipp" value="{{ old('masa_berlaku_sipp', optional($konselor->masa_berlaku_sipp)->format('Y-m-d')) }}" class="{{ $input }}">
            </div>
        </div>

        <div>
            <label for="dokumen_verifikasi" class="block text-sm font-semibold text-ink-900 mb-1.5">Dokumen STR / SIPP (PDF, JPG, PNG - maks 10 MB)</label>
            <input id="dokumen_verifikasi" type="file" name="dokumen_verifikasi" accept=".pdf,.jpg,.jpeg,.png" class="block text-sm text-ink-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-berry-100 file:text-berry-700 file:font-semibold">
            @if($konselor->dokumen_verifikasi)
                <a href="{{ asset('storage/' . $konselor->dokumen_verifikasi) }}" target="_blank" class="inline-block mt-2 text-xs font-semibold text-berry-700 hover:underline">Lihat dokumen saat ini &rarr;</a>
            @endif
        </div>

        <div>
            <label for="dokumen_ijazah" class="block text-sm font-semibold text-ink-900 mb-1.5">Ijazah (PDF, JPG, PNG - maks 10 MB)</label>
            <input id="dokumen_ijazah" type="file" name="dokumen_ijazah" accept=".pdf,.jpg,.jpeg,.png" class="block text-sm text-ink-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-berry-100 file:text-berry-700 file:font-semibold">
            @if($konselor->dokumen_ijazah)
                <a href="{{ asset('storage/' . $konselor->dokumen_ijazah) }}" target="_blank" class="inline-block mt-2 text-xs font-semibold text-berry-700 hover:underline">Lihat ijazah saat ini &rarr;</a>
            @endif
        </div>

        <div class="flex justify-end pt-5 border-t border-cream-200">
            <button type="submit" class="{{ $tombol }}">Simpan Kredensial</button>
        </div>
    </form>

    <!-- Tab: Layanan -->
    <form method="POST" action="{{ route('konselor.profil.update', 'layanan') }}" x-show="activeTab === 'layanan'" class="space-y-5" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="_bagian" value="layanan">

        <div>
            <span class="block text-sm font-semibold text-ink-900 mb-2">Spesialisasi (boleh pilih lebih dari satu)</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach($spesialisasiList as $s)
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-cream-200 bg-cream-50 cursor-pointer">
                        <input type="checkbox" name="spesialisasi[]" value="{{ $s }}" class="rounded border-cream-200 text-berry-700 focus:ring-berry-500"
                               {{ in_array($s, old('spesialisasi', $konselor->spesialisasi ?? [])) ? 'checked' : '' }}>
                        <span class="text-sm text-ink-900">{{ $s }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="durasi_sesi" class="block text-sm font-semibold text-ink-900 mb-1.5">Durasi Sesi</label>
                <select id="durasi_sesi" name="durasi_sesi" class="{{ $input }}">
                    <option value="">Pilih durasi</option>
                    @foreach($durasiList as $d)
                        <option value="{{ $d }}" {{ (string) old('durasi_sesi', $konselor->durasi_sesi) === (string) $d ? 'selected' : '' }}>{{ $d }} menit</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tarif" class="block text-sm font-semibold text-ink-900 mb-1.5">Tarif per Sesi (Rp)</label>
                <input id="tarif" type="number" min="0" step="1000" name="tarif" value="{{ old('tarif', $konselor->tarif ?? 0) }}" class="{{ $input }}">
            </div>
        </div>

        <div>
            <label for="kebijakan_pembatalan" class="block text-sm font-semibold text-ink-900 mb-1.5">Kebijakan Pembatalan</label>
            <textarea id="kebijakan_pembatalan" name="kebijakan_pembatalan" rows="4" placeholder="Contoh: Pembatalan maksimal 24 jam sebelum sesi agar dana dikembalikan penuh." class="{{ $input }}">{{ old('kebijakan_pembatalan', $konselor->kebijakan_pembatalan) }}</textarea>
        </div>

        <div class="flex justify-end pt-5 border-t border-cream-200">
            <button type="submit" class="{{ $tombol }}">Simpan Layanan</button>
        </div>
    </form>

    <!-- Tab: Rekening Pencairan -->
    <form method="POST" action="{{ route('konselor.profil.update', 'rekening') }}" x-show="activeTab === 'rekening'" class="space-y-5" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="_bagian" value="rekening">

        <p class="text-xs text-ink-600">Nomor rekening dan nama pemilik disimpan terenkripsi dan hanya dipakai untuk pencairan honor.</p>

        <div>
            <label for="rekening_bank" class="block text-sm font-semibold text-ink-900 mb-1.5">Bank</label>
            <input id="rekening_bank" type="text" name="rekening_bank" value="{{ old('rekening_bank', $konselor->rekening_bank) }}" placeholder="Contoh: BCA, Mandiri, BRI" class="{{ $input }}">
        </div>
        <div>
            <label for="rekening_nomor" class="block text-sm font-semibold text-ink-900 mb-1.5">Nomor Rekening</label>
            <input id="rekening_nomor" type="text" inputmode="numeric" name="rekening_nomor" value="{{ old('rekening_nomor', $konselor->rekening_nomor) }}" class="{{ $input }}">
        </div>
        <div>
            <label for="rekening_atas_nama" class="block text-sm font-semibold text-ink-900 mb-1.5">Atas Nama</label>
            <input id="rekening_atas_nama" type="text" name="rekening_atas_nama" value="{{ old('rekening_atas_nama', $konselor->rekening_atas_nama) }}" class="{{ $input }}">
        </div>

        <div class="flex justify-end pt-5 border-t border-cream-200">
            <button type="submit" class="{{ $tombol }}">Simpan Rekening</button>
        </div>
    </form>

    <!-- Tab: Kode Etik -->
    <form method="POST" action="{{ route('konselor.profil.update', 'kode-etik') }}" x-show="activeTab === 'kode-etik'" class="space-y-5" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="_bagian" value="kode-etik">

        <div class="p-4 rounded-xl border border-cream-200 bg-cream-50 text-sm text-ink-900 space-y-2">
            <p class="font-semibold">Kode Etik dan Kerahasiaan Konselor Ruang Puan</p>
            <ul class="list-disc list-inside space-y-1 text-ink-600">
                <li>Menjaga kerahasiaan identitas dan cerita pengguna.</li>
                <li>Tidak membagikan data pengguna kepada pihak mana pun tanpa persetujuan pengguna.</li>
                <li>Memberikan layanan secara profesional dan tanpa menghakimi.</li>
                <li>Bekerja sesuai bidang kompetensi dan izin praktik yang dimiliki.</li>
            </ul>
        </div>

        @if($konselor->kode_etik_disetujui_at)
            <p class="text-sm font-semibold text-success-600">Disetujui pada {{ $konselor->kode_etik_disetujui_at->format('d/m/Y H:i') }}</p>
        @else
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" name="setuju" value="1" class="mt-1 rounded border-cream-200 text-berry-700 focus:ring-berry-500">
                <span class="text-sm text-ink-900">Saya telah membaca dan menyetujui kode etik dan kerahasiaan di atas.</span>
            </label>

            <div class="flex justify-end pt-5 border-t border-cream-200">
                <button type="submit" class="{{ $tombol }}">Setujui</button>
            </div>
        @endif
    </form>
</div>
@endsection
