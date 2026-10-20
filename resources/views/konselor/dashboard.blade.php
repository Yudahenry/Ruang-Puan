@extends('layouts.konselor')

@section('konselor-content')
<div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 transition-shadow duration-200 hover:shadow-md">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-cream-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-berry-900 tracking-tight">Area Praktik Konselor</h1>
            <p class="text-sm text-ink-600 mt-1">Selamat datang, <span class="font-semibold text-lavender-600">{{ auth()->user()->nama }}</span>.</p>
        </div>
        
        @if(auth()->user()->konselor)
            <div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if(auth()->user()->konselor->status_verifikasi === 'disetujui') bg-success-100 text-success-600
                    @elseif(auth()->user()->konselor->status_verifikasi === 'ditolak') bg-danger-100 text-danger-600
                    @else bg-warning-100 text-warning-600 @endif">
                    Status: {{ ucfirst(auth()->user()->konselor->status_verifikasi) }}
                </span>
            </div>
        @endif
    </div>

    @if(auth()->user()->konselor && auth()->user()->konselor->status_verifikasi !== 'disetujui')
        <div class="mb-6 p-4 rounded-xl bg-warning-100/50 border border-warning-600/30 flex items-start justify-between">
            <div>
                <h4 class="text-xs font-bold text-warning-600 uppercase tracking-wider">Perhatian Verifikasi</h4>
                <p class="text-xs text-ink-900 mt-1">Akun Anda sedang dalam proses verifikasi dokumen STR/SIPP oleh tim admin.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="px-3 py-1.5 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                Lengkapi Dokumen &rarr;
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-lavender-200 text-lavender-600 flex items-center justify-center font-bold mb-4">
                    📅
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Jadwal Praktik Konsultasi</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Atur slot ketersediaan waktu konsultasi online Anda untuk klien.</p>
            </div>
            <button type="button" disabled class="inline-flex items-center justify-center px-4 py-2 bg-cream-200 text-ink-600 rounded-lg text-xs font-semibold cursor-not-allowed">
                Tersedia di Modul 4 (Konsultasi)
            </button>
        </div>

        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-berry-100 text-berry-700 flex items-center justify-center font-bold mb-4">
                    📄
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Dokumen & Profil Konselor</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Kelola nomor STR, SIPP, tarif per sesi, dan unggah berkas legalitas profesi.</p>
            </div>
            <a href="{{ route('profile.edit') }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                Buka Profil & Dokumen &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
