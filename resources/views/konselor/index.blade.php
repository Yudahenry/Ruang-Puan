@extends('layouts.pengguna')

@section('pengguna-content')
<div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-berry-900 tracking-tight">Daftar Konselor</h1>
        <p class="text-sm text-ink-600 mt-1">Silakan pilih psikolog atau konselor berlisensi untuk memulai sesi konsultasi privat yang aman dan nyaman.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-success-100 text-success-600 rounded-xl text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($konsolors) && $konsolors->isEmpty())
        <div class="text-center py-12 bg-cream-50 rounded-xl border border-cream-200">
            <p class="text-ink-600 text-sm">Belum ada konselor yang tersedia atau disetujui saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($konsolors as $konselor)
                <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                    <div>
                        <div class="w-12 h-12 rounded-full bg-berry-100 text-berry-700 flex items-center justify-center font-bold text-lg mb-4">
                            {{ substr($konselor->user->nama ?? 'K', 0, 1) }}
                        </div>
                                                <h3 class="font-bold text-berry-900 text-lg mb-1"><a href="{{ route('konsultasi.konselor.profil', $konselor->id) }}" class="hover:text-berry-700 hover:underline">{{ $konselor->user->nama ?? 'Konselor Profesional' }}</a></h3>
                                                <p class="text-xs text-rose-600 font-semibold mb-3">{{ !empty($konselor->spesialisasi) ? implode(', ', $konselor->spesialisasi) : 'Psikolog Klinis & Pendampingan' }}</p>
                        <p class="text-xs text-ink-600 leading-relaxed mb-6">{{ Str::limit($konselor->bio ?? 'Pendampingan profesional yang aman, rahasia, dan bebas stigma.', 90) }}</p>
                    </div>
                    <div>
                        <a href="{{ route('konsultasi.jadwal', $konselor->id) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                            Lihat Jadwal &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
