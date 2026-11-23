@extends('layouts.pengguna')
@section('title', $materi->judul)

@section('pengguna-content')
@php
    $isi = (string) $materi->isi;
    $isiHtml = $isi !== strip_tags($isi)
        ? \App\Support\HtmlBersih::bersihkan($isi)
        : nl2br(e($isi));
    $kata = str_word_count(strip_tags($isi));
    $menitBaca = max(1, (int) ceil($kata / 200));
    $tanggal = \Carbon\Carbon::parse($materi->tanggal_posting ?? $materi->created_at)
        ->locale('id')->translatedFormat('l, d F Y');
    $kat = $materi->kategoriEdukasi;
    $namaKat = $kat->nama_kategori ?? $kat->nama ?? 'Edukasi';
    $lampiran = preg_match('/^https?:\/\//i', (string) $materi->file_url) ? $materi->file_url : null;
@endphp

<style>
    #bar-baca{position:fixed;top:0;left:0;height:3px;width:0;background:#633a5e;z-index:60}
    .rp-wrap{max-width:1120px;margin:0 auto;padding:32px 16px 64px}
    .rp-grid{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:48px}
    @@media (max-width:900px){.rp-grid{grid-template-columns:1fr;gap:32px}}
    .rp-back{font-size:14px;font-weight:600;color:#633a5e;text-decoration:none}
    .rp-chip{display:inline-block;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:6px 14px;border-radius:999px;background:#633a5e;color:#fff;margin:20px 8px 0 0}
    .rp-chip.alt{background:#efe3ef;color:#633a5e}
    .berita-judul{font-family:Georgia,'Times New Roman',serif;font-size:42px;line-height:1.15;font-weight:700;color:#3d2038;margin:16px 0 20px}
    @@media (max-width:600px){.berita-judul{font-size:30px}}
    .rp-byline{display:flex;align-items:center;gap:12px;flex-wrap:wrap;padding:16px 0;border-top:1px solid #e5dde4;border-bottom:1px solid #e5dde4;margin-bottom:28px}
    .rp-av{width:48px;height:48px;border-radius:50%;background:#633a5e;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700}
    .rp-meta{flex:1;min-width:180px;font-size:14px;color:#6b5a68}
    .rp-meta b{display:block;color:#2b1f29;font-size:15px}
    .rp-btn{font-size:14px;font-weight:600;padding:9px 16px;border-radius:999px;background:#efe3ef;color:#633a5e;border:0;cursor:pointer;text-decoration:none}
    .artikel-isi{font-family:Georgia,'Times New Roman',serif;font-size:19px;line-height:1.8;color:#2b1f29;overflow-wrap:anywhere}
    .artikel-isi p{margin:0 0 1.2em}
    .artikel-isi h2{font-size:28px;margin:1.6em 0 .6em;font-weight:700}
    .artikel-isi h3{font-size:22px;margin:1.4em 0 .5em;font-weight:700}
    .artikel-isi ul{list-style:disc;padding-left:1.6em;margin:0 0 1.2em}
    .artikel-isi ol{list-style:decimal;padding-left:1.6em;margin:0 0 1.2em}
    .artikel-isi blockquote{border-left:4px solid #633a5e;padding:4px 0 4px 18px;margin:1.4em 0;color:#5a4757;font-style:italic}
    .artikel-isi a{color:#633a5e;text-decoration:underline}
    .artikel-isi img{max-width:100%;height:auto;border-radius:12px}
    .artikel-isi .ql-align-center{text-align:center}
    .artikel-isi .ql-align-right{text-align:right}
    .artikel-isi .ql-align-justify{text-align:justify}
    .rp-lampiran{display:inline-block;margin-top:12px;padding:14px 24px;border-radius:999px;background:#633a5e;color:#fff;font-weight:700;text-decoration:none}
    .rp-disc{margin-top:40px;padding-top:20px;border-top:1px solid #e5dde4;font-size:14px;color:#6b5a68}
    .rp-cta{background:#633a5e;color:#fff;border-radius:24px;padding:28px;position:sticky;top:24px}
    .rp-cta h3{font-family:Georgia,serif;font-size:22px;margin:0 0 10px}
    .rp-cta p{font-size:15px;line-height:1.6;margin:0 0 18px}
    .rp-cta a{display:block;text-align:center;background:#fff;color:#633a5e;font-weight:700;padding:14px;border-radius:999px;text-decoration:none}
    .rp-baca{margin-top:64px;padding-top:32px;border-top:2px solid #3d2038}
    .rp-baca-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:20px}
    .rp-baca h2{font-family:Georgia,serif;font-size:28px;color:#3d2038;margin:0}
    .rp-cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}
    @@media (max-width:900px){.rp-cards{grid-template-columns:1fr}}
    .rp-card{display:flex;flex-direction:column;gap:10px;background:#fff;border:1px solid #e5dde4;border-radius:18px;padding:20px;text-decoration:none;color:inherit;transition:box-shadow .2s,transform .2s}
    .rp-card:hover{box-shadow:0 8px 24px rgba(99,58,94,.15);transform:translateY(-2px)}
    .rp-card .k{font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#633a5e}
    .rp-card .j{font-family:Georgia,serif;font-size:21px;line-height:1.3;font-weight:700;color:#2b1f29}
    .rp-card .m{font-size:13px;color:#6b5a68;margin-top:auto}
    .rp-card .go{font-size:14px;font-weight:700;color:#633a5e}
</style>

<div id="bar-baca"></div>

<div class="rp-wrap">
    <a href="{{ route('edukasi.index') }}" class="rp-back">← Kembali ke Daftar Edukasi</a>

    <div class="rp-grid" style="margin-top:8px">
        <article>
            <span class="rp-chip">{{ $namaKat }}</span><span class="rp-chip alt">{{ strtoupper($materi->jenis_konten) }}</span>
            <h1 class="berita-judul">{{ $materi->judul }}</h1>

            <div class="rp-byline">
                <div class="rp-av">RP</div>
                <div class="rp-meta"><b>Tim Ruang Puan</b>{{ $tanggal }} · {{ $menitBaca }} menit baca</div>
                <a class="rp-btn" target="_blank" rel="noopener" href="https://wa.me/?text={{ urlencode($materi->judul.' - '.url()->current()) }}">WhatsApp</a>
                <button type="button" class="rp-btn" id="salin">Salin tautan</button>
            </div>

            <div class="artikel-isi">{!! $isiHtml !!}</div>

            @if($lampiran)
                <a class="rp-lampiran" href="{{ $lampiran }}" target="_blank" rel="noopener noreferrer">Buka lampiran ({{ $materi->jenis_konten }}) →</a>
            @endif

            <p class="rp-disc">Materi edukasi ini bersifat informatif dan tidak menggantikan bantuan profesional.</p>
        </article>

        <aside>
            <div class="rp-cta">
                <h3>Butuh pendampingan?</h3>
                <p>Ceritakan kondisimu kepada konselor profesional kami. Rahasia dan tanpa penghakiman.</p>
                <a href="{{ url('/konsultasi') }}">Konsultasi Sekarang</a>
            </div>
        </aside>
    </div>

    @if($relatedMateris->count())
    <section class="rp-baca">
        <div class="rp-baca-head">
            <h2>Baca Juga</h2>
            <a class="rp-back" href="{{ route('edukasi.index') }}">Lihat semua materi →</a>
        </div>
        <div class="rp-cards">
            @foreach($relatedMateris as $rel)
                @php
                    $katRel = $rel->kategoriEdukasi;
                    $tglRel = \Carbon\Carbon::parse($rel->tanggal_posting ?? $rel->created_at)->locale('id')->translatedFormat('d F Y');
                @endphp
                <a class="rp-card" href="{{ route('edukasi.show', $rel->id) }}">
                    <span class="k">{{ $katRel->nama_kategori ?? $katRel->nama ?? 'Edukasi' }}</span>
                    <span class="j">{{ $rel->judul }}</span>
                    <span class="m">{{ ucfirst($rel->jenis_konten) }} · {{ $tglRel }}</span>
                    <span class="go">Baca →</span>
                </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

<script>
(function () {
    var bar = document.getElementById('bar-baca');
    window.addEventListener('scroll', function () {
        var h = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.width = (h > 0 ? (window.scrollY / h) * 100 : 0) + '%';
    });
    var tombol = document.getElementById('salin');
    tombol.addEventListener('click', function () {
        if (navigator.clipboard) { navigator.clipboard.writeText(window.location.href); }
        tombol.textContent = 'Tersalin!';
        setTimeout(function () { tombol.textContent = 'Salin tautan'; }, 1500);
    });
})();
</script>
@endsection
