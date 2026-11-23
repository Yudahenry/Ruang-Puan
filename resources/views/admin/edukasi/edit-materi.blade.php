@extends('layouts.admin')
@section('title', 'Ubah Materi')

@section('admin-content')
<style>
    .ed-wrap{max-width:860px}
    .ed-field{margin-bottom:20px}
    .ed-field label{display:block;font-size:14px;font-weight:600;margin-bottom:6px;color:#2b1f29}
    .ed-field input,.ed-field select{width:100%;border:1px solid #e5dde4;background:#fdfaf6;border-radius:10px;padding:10px 12px;font-size:14px;color:#2b1f29}
    .ed-field input:focus,.ed-field select:focus{outline:none;border-color:#633a5e;box-shadow:0 0 0 2px rgba(99,58,94,.2)}
    .ed-err{background:#fde8e8;color:#9b1c1c;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px}
    .ed-btns{display:flex;gap:12px;margin-top:8px}
    .ed-simpan{background:#633a5e;color:#fff;font-weight:700;border:0;border-radius:999px;padding:12px 28px;cursor:pointer}
    .ed-batal{background:#efe3ef;color:#633a5e;font-weight:700;border-radius:999px;padding:12px 28px;text-decoration:none}
    #editor-isi{height:320px;background:#fff;font-size:16px}
    .ql-toolbar.ql-snow{border-radius:10px 10px 0 0;background:#fdfaf6;border-color:#e5dde4}
    .ql-container.ql-snow{border-radius:0 0 10px 10px;border-color:#e5dde4}
</style>

<div class="ed-wrap">
    <h1 style="font-size:26px;font-weight:700;margin-bottom:20px">Ubah Materi</h1>

    @if ($errors->any())
        <div class="ed-err">
            @foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.edukasi.update', $materi->id) }}">
        @csrf
        @method('PUT')

        <div class="ed-field">
            <label for="judul">Judul Materi</label>
            <input id="judul" type="text" name="judul" value="{{ old('judul', $materi->judul) }}" required placeholder="Contoh: Memahami Hak Hukum Korban KDRT">
        </div>

        <div class="ed-field">
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id" required>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" @selected(old('kategori_id', $materi->kategori_id) == $kat->id)>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="ed-field">
            <label for="jenis_konten">Jenis Konten</label>
            <select id="jenis_konten" name="jenis_konten" required>
                <option value="artikel" @selected(old('jenis_konten', $materi->jenis_konten) == 'artikel')>Artikel</option>
                <option value="infografis" @selected(old('jenis_konten', $materi->jenis_konten) == 'infografis')>Infografis</option>
                <option value="video" @selected(old('jenis_konten', $materi->jenis_konten) == 'video')>Video</option>
            </select>
        </div>

        <div class="ed-field">
            <label for="file_url">Tautan File / Video (opsional)</label>
            <input id="file_url" type="url" name="file_url" value="{{ old('file_url', $materi->file_url) }}" placeholder="https://...">
        </div>

        <div class="ed-field">
            <label>Isi / Konten Materi</label>
            <div id="editor-isi"></div>
            <input type="hidden" id="isi" name="isi" value="{{ old('isi', $materi->isi) }}">
        </div>

        <div class="ed-field">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="draft" @selected(old('status', $materi->status) == 'draft')>Draft (Simpan sementara)</option>
                <option value="terbit" @selected(old('status', $materi->status) == 'terbit')>Terbit (Publikasikan sekarang)</option>
            </select>
        </div>

        <div class="ed-btns">
            <button type="submit" class="ed-simpan">Simpan Perubahan</button>
            <a href="{{ route('admin.edukasi.index') }}" class="ed-batal">Batal</a>
        </div>
    </form>
</div>

<link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
<script>
(function () {
    var input = document.getElementById('isi');
    var quill = new Quill('#editor-isi', {
        theme: 'snow',
        placeholder: 'Tuliskan isi materi selengkapnya di sini...',
        modules: { toolbar: [ [{ header: [2, 3, false] }], ['bold','italic','underline','strike'], [{ list: 'ordered' }, { list: 'bullet' }], ['blockquote','link'], [{ align: [] }], ['clean'] ] }
    });
    var awal = input.value || '';
    if (awal && awal === awal.replace(/<[^>]*>/g, '')) {
        awal = '<p>' + awal.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/\n/g, '</p><p>') + '</p>';
    }
    quill.root.innerHTML = awal;
    input.form.addEventListener('submit', function (e) {
        if (quill.getText().trim().length === 0) { e.preventDefault(); alert('Isi materi wajib diisi.'); return; }
        input.value = quill.root.innerHTML;
    });
})();
</script>
@endsection
