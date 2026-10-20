@extends('layouts.pengguna')

@section('pengguna-content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 my-6 transition-shadow duration-200 hover:shadow-md"
     x-data="{ loading: false }">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Buat Laporan Kasus</h1>
        <p class="text-sm text-ink-600 mt-1">Sampaikan laporan Anda dengan aman. Anda dapat memilih mode anonim untuk menyembunyikan identitas Anda dari admin.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-danger-100 border border-danger-600 text-danger-600 p-4 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pelaporan.store') }}" enctype="multipart/form-data" @submit="loading = true" class="space-y-6">
        @csrf

        <div>
            <label for="jenis_kasus" class="block text-sm font-semibold text-ink-900 mb-1">Jenis Kasus</label>
            <select id="jenis_kasus" name="jenis_kasus" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition">
                <option value="">-- Pilih Jenis Kasus --</option>
                <option value="kekerasan_fisik" @selected(old('jenis_kasus') == 'kekerasan_fisik')>Kekerasan Fisik</option>
                <option value="kekerasan_psikis" @selected(old('jenis_kasus') == 'kekerasan_psikis')>Kekerasan Psikis</option>
                <option value="kekerasan_seksual" @selected(old('jenis_kasus') == 'kekerasan_seksual')>Kekerasan Seksual</option>
                <option value="kdrt" @selected(old('jenis_kasus') == 'kdrt')>KDRT (Kekerasan Dalam Rumah Tangga)</option>
                <option value="kekerasan_online" @selected(old('jenis_kasus') == 'kekerasan_online')>Kekerasan Berbasis Gender Online (KBGO)</option>
                <option value="lainnya" @selected(old('jenis_kasus') == 'lainnya')>Lainnya</option>
            </select>
        </div>

        <div>
            <label for="kronologi" class="block text-sm font-semibold text-ink-900 mb-1">Kronologi Kejadian</label>
            <textarea id="kronologi" name="kronologi" rows="5" required placeholder="Ceritakan kronologi kejadian secara detail..."
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition">{{ old('kronologi') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="waktu_kejadian" class="block text-sm font-semibold text-ink-900 mb-1">Waktu Kejadian (Opsional)</label>
                <input id="waktu_kejadian" type="datetime-local" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}"
                    class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition">
            </div>
            <div>
                <label for="lokasi_kejadian" class="block text-sm font-semibold text-ink-900 mb-1">Lokasi Kejadian (Opsional)</label>
                <input id="lokasi_kejadian" type="text" name="lokasi_kejadian" value="{{ old('lokasi_kejadian') }}" placeholder="Contoh: Jakarta Selatan"
                    class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition">
            </div>
        </div>

        <div>
            <label for="bukti" class="block text-sm font-semibold text-ink-900 mb-1">Bukti Pendukung (Foto, PDF, Video - Maks 10MB per file)</label>
            <input id="bukti" type="file" name="bukti[]" multiple
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-berry-700 file:text-white hover:file:bg-berry-900 transition">
        </div>

        <div class="bg-cream-50 p-4 rounded-xl border border-cream-200 flex items-start space-x-3">
            <input type="checkbox" id="anonim" name="anonim" value="1" @checked(old('anonim'))
                class="mt-1 rounded border-cream-200 text-berry-700 focus:ring-berry-500">
            <div>
                <label for="anonim" class="font-bold text-sm text-berry-900 block">Kirim sebagai Laporan Anonim</label>
                <p class="text-xs text-ink-600 mt-0.5">Identitas asli Anda akan disembunyikan dari admin dan peninjau (NFR-05). Anda tetap dapat memantau riwayat dan status laporan ini di akun Anda.</p>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-cream-200">
            <a href="{{ route('pelaporan.riwayat') }}" class="px-4 py-2 text-sm text-ink-600 hover:text-berry-700 font-medium transition-all duration-200 active:scale-[0.98]">Batal</a>
            <button type="submit" :disabled="loading" 
                    class="px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition-all duration-200 active:scale-[0.98] flex items-center space-x-2">
                <span x-show="!loading">Kirim Laporan</span>
                <span x-show="loading" class="inline-flex items-center space-x-2" style="display: none;">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memproses...</span>
                </span>
            </button>
        </div>
    </form>
</div>
@endsection
