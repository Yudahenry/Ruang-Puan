@extends('layouts.admin')

@section('admin-content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-berry-900">Tambah Lembaga Bantuan Baru</h1>
        <p class="text-sm text-ink-600 mt-1">Daftarkan hotline, UPTD PPA, LBH, atau rumah aman ke direktori layanan.</p>
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

    <form method="POST" action="{{ route('admin.direktori.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="nama" class="block text-sm font-medium text-ink-900 mb-1">Nama Lembaga</label>
            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: LBH APIK Jakarta"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="jenis_layanan" class="block text-sm font-medium text-ink-900 mb-1">Jenis Layanan</label>
                <select id="jenis_layanan" name="jenis_layanan" required
                    class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
                    <option value="hotline" @selected(old('jenis_layanan') == 'hotline')>Hotline</option>
                    <option value="uptd_ppa" @selected(old('jenis_layanan') == 'uptd_ppa')>UPTD PPA</option>
                    <option value="lbh" @selected(old('jenis_layanan') == 'lbh')>LBH (Lembaga Bantuan Hukum)</option>
                    <option value="rumah_aman" @selected(old('jenis_layanan') == 'rumah_aman')>Rumah Aman</option>
                    <option value="lainnya" @selected(old('jenis_layanan') == 'lainnya')>Lainnya</option>
                </select>
            </div>
            <div>
                <label for="wilayah" class="block text-sm font-medium text-ink-900 mb-1">Wilayah Operasional</label>
                <input id="wilayah" type="text" name="wilayah" value="{{ old('wilayah') }}" required placeholder="Contoh: DKI Jakarta / Nasional"
                    class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
            </div>
        </div>

        <div>
            <label for="kontak" class="block text-sm font-medium text-ink-900 mb-1">Nomor Kontak / Telepon</label>
            <input id="kontak" type="text" name="kontak" value="{{ old('kontak') }}" placeholder="Contoh: 021-87793395 / 129"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-ink-900 mb-1">Alamat Lengkap</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat kantor atau lokasi lembaga..."
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">{{ old('alamat') }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-cream-200">
            <a href="{{ route('admin.direktori.index') }}" class="px-4 py-2 text-sm text-ink-600 hover:text-berry-700 font-medium">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition">
                Simpan Lembaga
            </button>
        </div>
    </form>
</div>
@endsection
