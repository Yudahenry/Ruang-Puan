@php
    $layout = match(auth()->user()->role) {
        'admin' => 'layouts.admin',
        'konselor' => 'layouts.konselor',
        default => 'layouts.pengguna',
    };
    $section = match(auth()->user()->role) {
        'admin' => 'admin-content',
        'konselor' => 'konselor-content',
        default => 'pengguna-content',
    };
@endphp

@extends($layout)

@section($section)
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 my-6">

    <div class="flex items-start gap-5 pb-6 border-b border-cream-200">
        @if($user->foto_profil)
            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto {{ $user->nama }}" class="w-24 h-24 rounded-full object-cover border border-cream-200">
        @else
            <div class="w-24 h-24 rounded-full bg-berry-100 text-berry-700 flex items-center justify-center text-3xl font-bold">
                {{ strtoupper(mb_substr($user->nama, 0, 1)) }}
            </div>
        @endif

        <div>
            <h1 class="text-2xl font-bold text-berry-900 tracking-tight">{{ $user->nama }}</h1>
            @if($konselor->gelar)
                <p class="text-sm text-ink-600 mt-0.5">{{ $konselor->gelar }}</p>
            @endif
            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-success-100/50 text-success-600 text-xs font-semibold">Terverifikasi</span>
        </div>
    </div>

    @if($konselor->bio)
        <div class="py-6 border-b border-cream-200">
            <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider mb-2">Tentang</h2>
            <p class="text-sm text-ink-900 leading-relaxed whitespace-pre-line">{{ $konselor->bio }}</p>
        </div>
    @endif

    @if(!empty($konselor->spesialisasi))
        <div class="py-6 border-b border-cream-200">
            <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider mb-3">Spesialisasi</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($konselor->spesialisasi as $s)
                    <span class="px-3 py-1 rounded-full bg-berry-100 text-berry-700 text-xs font-semibold">{{ $s }}</span>
                @endforeach
            </div>
        </div>
    @endif

    <div class="py-6 border-b border-cream-200 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
        @if($konselor->pendidikan)
            <div>
                <p class="font-semibold text-ink-900">Pendidikan</p>
                <p class="text-ink-600 whitespace-pre-line">{{ $konselor->pendidikan }}</p>
            </div>
        @endif
        @if($konselor->pengalaman_tahun !== null)
            <div>
                <p class="font-semibold text-ink-900">Pengalaman</p>
                <p class="text-ink-600">{{ $konselor->pengalaman_tahun }} tahun</p>
            </div>
        @endif
        @if($konselor->bahasa)
            <div>
                <p class="font-semibold text-ink-900">Bahasa</p>
                <p class="text-ink-600">{{ $konselor->bahasa }}</p>
            </div>
        @endif
        @if($konselor->durasi_sesi)
            <div>
                <p class="font-semibold text-ink-900">Durasi Sesi</p>
                <p class="text-ink-600">{{ $konselor->durasi_sesi }} menit</p>
            </div>
        @endif
        <div>
            <p class="font-semibold text-ink-900">Tarif per Sesi</p>
            <p class="text-ink-600">Rp {{ number_format($konselor->tarif ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    @if($konselor->kebijakan_pembatalan)
        <div class="py-6 border-b border-cream-200">
            <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider mb-2">Kebijakan Pembatalan</h2>
            <p class="text-sm text-ink-600 whitespace-pre-line">{{ $konselor->kebijakan_pembatalan }}</p>
        </div>
    @endif

    <div class="pt-6 flex justify-end">
        <a href="{{ route('konsultasi.jadwal', $konselor) }}" class="px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition-all duration-200 active:scale-[0.98]">
            Pilih Jadwal
        </a>
    </div>
</div>
@endsection
