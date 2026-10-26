@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <h1 class="text-3xl font-bold text-berry-900 mb-3">Direktori Lembaga Bantuan</h1>
        <p class="text-ink-600">Temukan kontak darurat, UPTD PPA, LBH, dan rumah aman di wilayah Anda.</p>

        <!-- Search & Filter Bar -->
        <form method="GET" action="{{ route('direktori.index') }}" class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl mx-auto">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama lembaga / alamat..."
                class="rounded-xl border-cream-200 bg-white focus:border-berry-500 focus:ring-berry-500 px-4 py-2.5 text-sm text-ink-900 border shadow-sm">
            
            <select name="jenis" class="rounded-xl border-cream-200 bg-white focus:border-berry-500 focus:ring-berry-500 px-4 py-2.5 text-sm text-ink-900 border shadow-sm">
                <option value="">Semua Jenis Layanan</option>
                <option value="hotline" @selected($jenis === 'hotline')>Hotline</option>
                <option value="uptd_ppa" @selected($jenis === 'uptd_ppa')>UPTD PPA</option>
                <option value="lbh" @selected($jenis === 'lbh')>LBH (Lembaga Bantuan Hukum)</option>
                <option value="rumah_aman" @selected($jenis === 'rumah_aman')>Rumah Aman</option>
                <option value="lainnya" @selected($jenis === 'lainnya')>Lainnya</option>
            </select>

            <button type="submit" class="px-5 py-2.5 bg-berry-700 hover:bg-berry-900 text-white rounded-xl text-sm font-medium shadow-sm transition">
                Filter Direktori
            </button>
        </form>
    </div>

    <!-- Lembaga List -->
    @if($lembagas->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-cream-200 max-w-xl mx-auto shadow-sm">
            <p class="text-ink-600 text-sm">Tidak ada lembaga bantuan yang ditemukan sesuai filter.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($lembagas as $lembaga)
                <div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-6 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($lembaga->jenis_layanan === 'hotline') bg-danger-100 text-danger-600
                                @elseif($lembaga->jenis_layanan === 'uptd_ppa') bg-info-100 text-info-600
                                @elseif($lembaga->jenis_layanan === 'lbh') bg-success-100 text-success-600
                                @else bg-warning-100 text-warning-600 @endif">
                                {{ strtoupper(str_replace('_', ' ', $lembaga->jenis_layanan)) }}
                            </span>
                            <span class="text-xs font-medium text-ink-600">Wilayah: {{ $lembaga->wilayah }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-berry-900 mb-2">{{ $lembaga->nama }}</h3>
                        <p class="text-sm text-ink-600 mb-4 leading-relaxed">{{ $lembaga->alamat ?? 'Alamat tidak dicantumkan secara publik.' }}</p>
                    </div>
                    <div class="pt-4 border-t border-cream-200 flex items-center justify-between">
                        <span class="text-sm font-bold text-berry-700">Kontak: {{ $lembaga->kontak ?? 'Tidak tersedia' }}</span>
                        @if($lembaga->kontak)
                            <a href="tel:{{ $lembaga->kontak }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                Hubungi
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $lembagas->links() }}
        </div>
    @endif
</div>
@endsection
