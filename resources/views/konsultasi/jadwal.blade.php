@extends('layouts.pengguna')

@section('pengguna-content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-6 sm:p-10">
        
        <!-- Header Profil Konselor -->
        <div class="mb-8 pb-6 border-b border-[#DCD5DD]/70 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-serif font-bold text-xl flex-shrink-0 shadow-inner">
                    {{ substr($konselor->user->nama ?? 'K', 0, 1) }}
                </div>
                <div>
                    <span class="text-[10px] uppercase tracking-widest font-bold text-[#643B62] bg-[#EEE7F2] px-2.5 py-0.5 rounded-full">
                        {{ is_array($konselor->spesialisasi) ? implode(', ', $konselor->spesialisasi) : ($konselor->spesialisasi ?? 'Psikolog Klinis') }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] tracking-tight mt-1.5">
                        {{ $konselor->user->nama ?? 'Konselor Profesional' }}
                    </h1>
                </div>
            </div>
            <div>
                <a href="{{ route('konsultasi.index') }}" class="inline-flex items-center text-xs font-semibold text-[#643B62] hover:text-[#3E293F] transition bg-[#EEE7F2]/50 hover:bg-[#EEE7F2] px-4 py-2 rounded-xl">
                    &larr; Pilih Konselor Lain
                </a>
            </div>
        </div>

        <!-- Form Pemilihan Slot Waktu -->
        @if($konselor->jadwalKonsultasis->isEmpty())
            <div class="text-center py-16 bg-[#FCFAF8] rounded-3xl border border-[#DCD5DD] max-w-lg mx-auto p-6">
                <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-xl mb-3 shadow-inner">
                    📅
                </div>
                <h3 class="text-sm font-bold text-[#3E293F] mb-1">Belum Ada Jadwal Tersedia</h3>
                <p class="text-xs text-[#746B77] mb-4">Belum ada slot waktu kosong yang dipublikasikan oleh konselor ini saat ini.</p>
                <a href="{{ route('konsultasi.index') }}" class="inline-flex items-center px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold transition">
                    Lihat daftar konselor lainnya &rarr;
                </a>
            </div>
        @else
            <form action="{{ route('konsultasi.store') }}" method="POST" x-data="{ selectedSlot: null }">
                @csrf

                <div class="space-y-6">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-xs font-bold text-[#3E293F] uppercase tracking-wider">Pilih Slot Waktu Sesi</label>
                            <span class="text-[11px] text-[#746B77]">Silakan klik salah satu jadwal di bawah</span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($konselor->jadwalKonsultasis as $jadwal)
                                <label @click="selectedSlot = '{{ $jadwal->id }}'"
                                       :class="selectedSlot === '{{ $jadwal->id }}' ? 'border-[#643B62] bg-[#EEE7F2]/40 ring-1 ring-[#643B62]' : 'border-[#DCD5DD] bg-[#FCFAF8] hover:border-[#746B77]/50'"
                                       class="relative flex flex-col p-4 rounded-2xl border cursor-pointer transition-all duration-200 shadow-2xs group">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-bold text-[#3E293F]">
                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d M Y') }}
                                        </span>
                                        <input type="radio" name="jadwal_id" value="{{ $jadwal->id }}" class="text-[#643B62] focus:ring-[#643B62] w-4 h-4" required>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-[#746B77] mt-1">
                                        <svg class="w-3.5 h-3.5 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="font-medium text-[#3E293F]">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Informasi Biaya & Sesi -->
                    <div class="bg-[#EEE7F2]/50 border border-[#DCD5DD] rounded-2xl p-4 flex items-center justify-between text-xs text-[#3E293F]">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#643B62] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Durasi sesi konsultasi: <strong>60 menit</strong> (melalui chat privat aman).</span>
                        </div>
                        <span class="font-bold text-[#643B62]">Rp150.000</span>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#DCD5DD]/60">
                        <a href="{{ route('konsultasi.index') }}" class="px-5 py-3 bg-[#EEE7F2] text-[#3E293F] rounded-2xl text-xs font-semibold hover:bg-[#DCD5DD] transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-7 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition-all active:scale-[0.98] flex items-center gap-2">
                            <span>Konfirmasi Pemesanan Sesi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection