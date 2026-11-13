@extends('layouts.pengguna')

@section('pengguna-content')
<div class="space-y-10 pb-16">
    
    <!-- Hero Banner Header -->
    <div class="relative rounded-3xl bg-gradient-to-br from-[#EEE7F2] via-white to-[#FCFAF8] border border-[#DCD5DD] p-8 sm:p-12 text-center max-w-5xl mx-auto shadow-sm overflow-hidden">
        <div class="absolute -right-12 -bottom-12 w-56 h-56 bg-[#643B62]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -top-12 w-56 h-56 bg-[#EEE7F2] rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white text-[#643B62] text-[11px] font-bold tracking-widest uppercase mb-4 shadow-2xs border border-[#DCD5DD]">
                💬 Ruang Dengar & Pendampingan Profesional
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#3E293F] mb-4 tracking-tight">Daftar Konselor</h1>
            <p class="text-xs sm:text-sm text-[#746B77] leading-relaxed">
                Silakan pilih psikolog atau konselor berlisensi untuk memulai sesi konsultasi privat yang aman, rahasia, dan bebas stigma.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold shadow-2xs">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($konsolors) && $konsolors->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-[#DCD5DD] max-w-xl mx-auto shadow-sm p-8">
                <div class="w-16 h-16 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-2xl mb-4 shadow-inner">
                    👥
                </div>
                <h3 class="font-serif font-bold text-[#3E293F] text-base">Belum Ada Konselor Tersedia</h3>
                <p class="text-xs text-[#746B77] mt-1.5 mb-2">Belum ada konselor yang tersedia atau disetujui saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($konsolors as $konselor)
                    <div class="group bg-white rounded-3xl overflow-hidden border border-[#DCD5DD] shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                        <div>
                            <!-- Foto / Avatar Konselor (Style Kartu Dokter) -->
                            <div class="w-full h-48 bg-[#EEE7F2]/60 relative overflow-hidden flex items-center justify-center border-b border-[#DCD5DD]/60">
                                @if($konselor->user && $konselor->user->foto_profil)
                                    <img src="{{ asset('storage/' . $konselor->user->foto_profil) }}" alt="{{ $konselor->user->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-20 h-20 rounded-2xl bg-[#643B62] text-white flex items-center justify-center font-serif font-bold text-3xl shadow-inner">
                                        {{ substr($konselor->user->nama ?? 'K', 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Detail Info Konselor -->
                            <div class="p-5 space-y-1.5">
                                <h3 class="font-serif font-bold text-[#3E293F] text-base truncate">
                                    <a href="{{ route('konsultasi.konselor.profil', $konselor->id) }}" class="hover:text-[#643B62] transition">{{ $konselor->user->nama ?? 'Konselor Profesional' }}</a>
                                </h3>
                                
                                <p class="text-xs text-[#746B77] font-medium">
                                    {{ !empty($konselor->spesialisasi) ? (is_array($konselor->spesialisasi) ? implode(', ', $konselor->spesialisasi) : $konselor->spesialisasi) : 'Psikolog Klinis' }}
                                </p>

                                <!-- Rating Bintang -->
                                <div class="flex items-center gap-1 text-xs pt-1">
                                    <div class="flex text-amber-400">
                                        <span>★</span><span>★</span><span>★</span><span>★</span><span class="text-[#DCD5DD]">★</span>
                                    </div>
                                    <span class="text-[#746B77] text-[11px] ml-1">(4.8)</span>
                                </div>

                                <!-- Pengalaman -->
                                <p class="text-[11px] text-[#746B77]">
                                    {{ $konselor->pengalaman ?? '5+' }} Tahun Pengalaman
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="p-5 pt-0">
                            <a href="{{ route('konsultasi.jadwal', $konselor->id) }}"
                               class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                                Lihat Jadwal &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection