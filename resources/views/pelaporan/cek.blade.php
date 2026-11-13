@extends('layouts.pengguna')

@section('pengguna-content')
<section class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <a href="{{ route('pelaporan.riwayat') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-full text-xs font-semibold shadow-sm transition group">
        <span class="transform group-hover:-translate-x-1 transition">&larr;</span>
        <span>Kembali ke Riwayat Laporan</span>
    </a>

    <div class="bg-white border border-[#DCD5DD] rounded-3xl shadow-sm p-6 sm:p-8">
        <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center text-xl mb-4 shadow-inner">🔎</div>
        <h1 class="text-2xl font-bold font-serif text-[#3E293F]">Cek Status Laporan</h1>
        <p class="text-xs text-[#746B77] mt-2 leading-relaxed">
            Masukkan kode pelacakan yang Anda terima setelah membuat laporan.
        </p>

        <form method="GET" action="{{ route('pelaporan.cek') }}" class="mt-5 space-y-3">
            <input type="text" name="kode" value="{{ $kode }}" placeholder="Contoh: RP-ABC12345" autofocus
                   class="w-full bg-[#FCFAF8] border border-[#DCD5DD] rounded-2xl px-4 py-3 text-sm font-mono uppercase text-[#3E293F] focus:outline-none focus:ring-2 focus:ring-[#643B62]/30 shadow-inner">

            @if ($tidakDitemukan)
                <p class="text-xs text-rose-700 bg-rose-50 border border-rose-200 rounded-2xl px-4 py-3">
                    Kode <strong>{{ $kode }}</strong> tidak ditemukan di akun Anda. Periksa kembali penulisannya.
                </p>
            @endif

            <button type="submit"
                    class="w-full px-5 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition">
                Cek Status
            </button>
        </form>
    </div>
</section>
@endsection