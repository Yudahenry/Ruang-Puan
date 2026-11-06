@extends('layouts.pengguna')

@section('pengguna-content')
<div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 transition-shadow duration-200 hover:shadow-md">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-berry-900 tracking-tight">Dashboard Pengguna</h1>
        <p class="text-sm text-ink-600 mt-1">Selamat datang kembali, <span class="font-semibold text-berry-700">{{ auth()->user()->nama }}</span>. Pantau laporan dan temukan pendampingan di sini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-berry-100 text-berry-700 flex items-center justify-center font-bold mb-4">
                    📝
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Buat Laporan Baru</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Laporkan kasus kekerasan secara aman, baik bernama maupun anonim dengan kode pelacakan resmi.</p>
            </div>
            <a href="{{ route('pelaporan.buat') }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                Buat Laporan &rarr;
            </a>
        </div>

        <!-- Card 2 -->
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-rose-200 text-rose-600 flex items-center justify-center font-bold mb-4">
                    📋
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Riwayat Laporan</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Pantau perkembangan tindak lanjut laporan dan respons resmi dari pihak penanganan.</p>
            </div>
            <a href="{{ route('pelaporan.riwayat') }}" 
               class="inline-flex items-center justify-center px-4 py-2 border border-rose-600/40 text-rose-600 hover:bg-rose-200/50 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                Lihat Riwayat &rarr;
            </a>
        </div>

        <!-- Card 3 -->
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-lavender-200 text-lavender-600 flex items-center justify-center font-bold mb-4">
                    🏛️
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Direktori Lembaga</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Dapatkan informasi nomor darurat, kantor UPTD PPA, dan LBH terdekat di daerah Anda.</p>
            </div>
            <a href="{{ route('direktori.index') }}" 
               class="inline-flex items-center justify-center px-4 py-2 border border-lavender-600/40 text-lavender-600 hover:bg-lavender-200/50 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                Cari Lembaga &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
