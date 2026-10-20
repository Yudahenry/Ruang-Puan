@extends('layouts.admin')

@section('admin-content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-berry-900">Buat Materi Edukasi Baru</h1>
        <p class="text-sm text-ink-600 mt-1">Publikasikan artikel atau panduan edukasi untuk pengguna.</p>
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

    <form method="POST" action="{{ route('admin.edukasi.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="judul" class="block text-sm font-medium text-ink-900 mb-1">Judul Materi</label>
            <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Memahami Hak Hukum Korban KDRT"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="kategori_id" class="block text-sm font-medium text-ink-900 mb-1">Kategori</label>
                <select id="kategori_id" name="kategori_id" required
                    class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="jenis_konten" class="block text-sm font-medium text-ink-900 mb-1">Jenis Konten</label>
                <select id="jenis_konten" name="jenis_konten" required
                    class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
                    <option value="artikel" @selected(old('jenis_konten') == 'artikel')>Artikel</option>
                    <option value="infografis" @selected(old('jenis_konten') == 'infografis')>Infografis</option>
                    <option value="video" @selected(old('jenis_konten') == 'video')>Video</option>
                </select>
            </div>
        </div>

        <div>
            <label for="file_url" class="block text-sm font-medium text-ink-900 mb-1">URL File / Lampiran (Opsional)</label>
            <input id="file_url" type="url" name="file_url" value="{{ old('file_url') }}" placeholder="https://..."
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div>
            <label for="isi" class="block text-sm font-medium text-ink-900 mb-1">Isi / Konten Materi</label>
            <textarea id="isi" name="isi" rows="8" required placeholder="Tuliskan isi materi selengkapnya di sini..."
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">{{ old('isi') }}</textarea>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-ink-900 mb-1">Status Publikasi</label>
            <select id="status" name="status" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
                <option value="draft" @selected(old('status') == 'draft')>Draft (Simpan sementara)</option>
                <option value="terbit" @selected(old('status') == 'terbit')>Terbit (Publikasikan sekarang)</option>
            </select>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-cream-200">
            <a href="{{ route('admin.edukasi.index') }}" class="px-4 py-2 text-sm text-ink-600 hover:text-berry-700 font-medium">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition">
                Simpan Materi
            </button>
        </div>
    </form>
</div>
@endsection
