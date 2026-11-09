@extends('layouts.pengguna')

@section('pengguna-content')
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-4">

    <a href="{{ route('pengguna.riwayat-konsultasi') }}"
       class="inline-flex items-center gap-2 text-xs font-semibold text-sage-700 hover:text-sage-900 transition group">
        <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
        <span>Kembali ke Riwayat Konsultasi</span>
    </a>

    <div class="bg-white border border-sage-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-5 py-4 border-b border-sage-200 bg-sage-100/60 flex items-center justify-between gap-3">
            <div>
                <h1 class="text-lg font-bold font-fraunces text-sage-900">{{ $namaLawan }}</h1>
                <p class="text-xs text-sage-600">
                    {{ $konsultasi->waktuMulai()?->translatedFormat('l, d F Y · H:i') }}
                    &ndash; {{ $konsultasi->waktuSelesai()?->format('H:i') }}
                </p>
            </div>
            <span id="badge-sesi"
                  class="inline-flex px-3 py-1 rounded-full border text-[11px] font-semibold
                  {{ $aktif ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-sage-200 text-sage-900 border-sage-200' }}">
                {{ $aktif ? 'Sesi berlangsung' : ($berakhir ? 'Sesi selesai' : 'Belum dimulai') }}
            </span>
        </div>

        {{-- Daftar pesan --}}
        <div id="kotak-pesan" class="h-[420px] overflow-y-auto px-5 py-4 space-y-3 bg-white">
            <p id="kosong" class="text-center text-xs text-sage-600 font-light py-10">Belum ada pesan.</p>
        </div>

        {{-- Form kirim --}}
        <div class="border-t border-sage-200 p-4 bg-sage-100/40">
            <p id="info-nonaktif" class="text-xs text-sage-600 text-center mb-3 {{ $aktif ? 'hidden' : '' }}">
                @if ($berakhir)
                    Sesi telah berakhir. Percakapan hanya dapat dibaca.
                @else
                    Chat akan aktif pada jam sesi yang dijadwalkan.
                @endif
            </p>

            <form id="form-chat" class="flex items-end gap-3">
                <textarea id="isi" rows="1" maxlength="1000"
                          placeholder="Tulis pesan..."
                          {{ $aktif ? '' : 'disabled' }}
                          class="flex-1 resize-none bg-white border border-sage-200 rounded-xl px-3 py-2.5 text-sm text-sage-900 focus:outline-none focus:ring-2 focus:ring-sage-200 disabled:bg-sage-100 disabled:cursor-not-allowed"></textarea>
                <button id="tombol-kirim" type="submit" {{ $aktif ? '' : 'disabled' }}
                        class="px-5 py-2.5 bg-sage-700 hover:bg-sage-800 text-white rounded-xl text-xs font-semibold shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Kirim
                </button>
            </form>
        </div>
    </div>

    <p class="text-[11px] text-sage-600 font-light text-center">
        Konsultasi di Ruang Puan adalah pendampingan awal, bukan pengganti layanan medis profesional.
    </p>
</section>

<script>
(function () {
    const urlPesan = @json(route('konsultasi.chat.pesan', $konsultasi->id));
    const urlKirim = @json(route('konsultasi.chat.kirim', $konsultasi->id));
    const csrf     = @json(csrf_token());

    const kotak   = document.getElementById('kotak-pesan');
    const kosong  = document.getElementById('kosong');
    const form    = document.getElementById('form-chat');
    const isi     = document.getElementById('isi');
    const tombol  = document.getElementById('tombol-kirim');
    const info    = document.getElementById('info-nonaktif');
    const badge   = document.getElementById('badge-sesi');

    let terakhir = 0;
    let aktif = @json($aktif);

    function tambahPesan(p) {
        if (kosong) kosong.remove();

        const baris = document.createElement('div');
        baris.className = 'flex ' + (p.mine ? 'justify-end' : 'justify-start');

        const gelembung = document.createElement('div');
        gelembung.className = 'max-w-[75%] rounded-2xl px-4 py-2.5 ' +
            (p.mine ? 'bg-sage-700 text-white rounded-br-md' : 'bg-sage-100 text-sage-900 rounded-bl-md');

        const nama = document.createElement('p');
        nama.className = 'text-[10px] font-semibold mb-0.5 ' + (p.mine ? 'text-white/70' : 'text-sage-600');
        nama.textContent = p.nama;

        const teks = document.createElement('p');
        teks.className = 'text-sm whitespace-pre-wrap break-words';
        teks.textContent = p.isi; // textContent: aman dari XSS

        const waktu = document.createElement('p');
        waktu.className = 'text-[10px] mt-1 text-right ' + (p.mine ? 'text-white/70' : 'text-sage-600');
        waktu.textContent = p.waktu;

        gelembung.append(nama, teks, waktu);
        baris.appendChild(gelembung);
        kotak.appendChild(baris);
    }

    function setAktif(nilai) {
        aktif = nilai;
        isi.disabled = !nilai;
        tombol.disabled = !nilai;
        info.classList.toggle('hidden', nilai);
        if (!nilai) {
            info.textContent = 'Sesi telah berakhir. Percakapan hanya dapat dibaca.';
            badge.textContent = 'Sesi selesai';
            badge.className = 'inline-flex px-3 py-1 rounded-full border text-[11px] font-semibold bg-sage-200 text-sage-900 border-sage-200';
        } else {
            badge.textContent = 'Sesi berlangsung';
            badge.className = 'inline-flex px-3 py-1 rounded-full border text-[11px] font-semibold bg-emerald-100 text-emerald-800 border-emerald-200';
        }
    }

    async function ambilPesan() {
        try {
            const res = await fetch(urlPesan + '?after=' + terakhir, {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const data = await res.json();

            const dekat = kotak.scrollHeight - kotak.scrollTop - kotak.clientHeight < 80;
            data.pesan.forEach(p => { tambahPesan(p); terakhir = p.id; });
            if (data.pesan.length && dekat) kotak.scrollTop = kotak.scrollHeight;

            if (data.aktif !== aktif) setAktif(data.aktif);
        } catch (e) { /* abaikan, coba lagi di polling berikutnya */ }
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const teks = isi.value.trim();
        if (!teks || !aktif) return;

        tombol.disabled = true;
        try {
            const res = await fetch(urlKirim, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ isi_pesan: teks })
            });
            if (res.ok) {
                isi.value = '';
                await ambilPesan();
                kotak.scrollTop = kotak.scrollHeight;
            } else if (res.status === 403) {
                setAktif(false);
            }
        } finally {
            if (aktif) tombol.disabled = false;
            isi.focus();
        }
    });

    // Enter = kirim, Shift+Enter = baris baru
    isi.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.requestSubmit();
        }
    });

    ambilPesan().then(() => { kotak.scrollTop = kotak.scrollHeight; });
    setInterval(ambilPesan, 3000); // polling tiap 3 detik
})();
</script>
@endsection
