@extends('layouts.pengguna')

@section('pengguna-content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8">
        <!-- Header Profil Konselor -->
        <div class="mb-6 pb-6 border-b border-cream-200 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-berry-100 text-berry-700 flex items-center justify-center font-bold text-xl flex-shrink-0">
                {{ substr($konselor->user->nama ?? 'K', 0, 1) }}
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Pilih Jadwal Konsultasi</h1>
                <p class="text-sm text-ink-600 mt-1">
                    Bersama Konselor: <span class="font-semibold text-berry-700">{{ $konselor->user->nama ?? 'Konselor Profesional' }}</span> 
                    <span class="text-xs text-rose-600 ml-1">({{ $konselor->spesialisasi ?? 'Psikolog Klinis' }})</span>
                </p>
            </div>
            <div>
                <a href="{{ route('konsultasi.index') }}" class="inline-flex items-center text-xs font-semibold text-berry-700 hover:text-berry-900 transition">
                    &larr; Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form Pemilihan Slot Waktu -->
        @if($konselor->jadwalKonsultasis->isEmpty())
            <div class="text-center py-12 bg-cream-50 rounded-xl border border-cream-200">
                <p class="text-ink-600 text-sm mb-2">Belum ada jadwal waktu kosong yang tersedia dari konselor ini.</p>
                <a href="{{ route('konsultasi.index') }}" class="text-xs font-semibold text-berry-700 hover:underline">Pilih konselor lainnya &rarr;</a>
            </div>
        @else
            <form action="{{ route('konsultasi.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-berry-900 uppercase tracking-wider mb-3">Pilih Slot Jadwal Tersedia</label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($konselor->jadwalKonsultasis as $jadwal)
                                <label class="relative flex flex-col p-4 bg-cream-50/70 border border-cream-300 rounded-xl cursor-pointer hover:border-berry-700 transition-all group">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-bold text-berry-900">
                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d M Y') }}
                                        </span>
                                        <input type="radio" name="jadwal_id" value="{{ $jadwal->id }}" class="text-berry-700 focus:ring-berry-700" required>
                                    </div>
                                    <span class="text-xs text-ink-600">
                                        Pukul: <strong class="text-berry-900">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB</strong>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-cream-200">
                        <a href="{{ route('konsultasi.index') }}" class="px-4 py-2.5 bg-cream-200 text-ink-700 rounded-lg text-xs font-semibold hover:bg-cream-300 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all active:scale-[0.98]">
                            Konfirmasi Pemesanan Sesi &rarr;
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection