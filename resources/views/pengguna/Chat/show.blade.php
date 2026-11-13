@extends('layouts.pengguna')

@section('pengguna-content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#DCD5DD] mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('pengguna.riwayat-konsultasi') }}" class="text-xs font-semibold text-[#643B62] hover:underline mb-3 inline-flex items-center gap-1">
                &larr; Kembali ke Riwayat
            </a>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] mt-1">
                Chat dengan {{ $konsultasi->pemesanan->jadwalKonsultasi->konselor->user->nama ?? 'Konselor' }}
            </h1>
            <p class="text-xs text-[#746B77] mt-1">
                Konsultasi tanggal <span class="font-medium text-[#3E293F]">{{ \Carbon\Carbon::parse($konsultasi->tanggal_konsultasi)->translatedFormat('d F Y') }}</span>
            </p>
        </div>
        <div>
            @php
                $status = $konsultasi->status;
                $statusBadge = match($status) {
                    'selesai' => 'bg-green-100 text-green-700',
                    'batal' => 'bg-red-100 text-red-700',
                    default => 'bg-[#EEE7F2] text-[#643B62]',
                };
            @endphp
            <span class="text-xs px-3.5 py-1.5 rounded-full font-semibold {{ $statusBadge }}">
                Status: {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    {{-- Chat Box Area --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#DCD5DD] mb-6 min-h-[400px] max-h-[600px] overflow-y-auto flex flex-col space-y-4">
        @forelse ($konsultasi->pesans as $pesan)
            @php $isMine = $pesan->pengirim_id == auth()->id(); @endphp
            <div class="flex flex-col max-w-[80%] sm:max-w-[70%] {{ $isMine ? 'ml-auto items-end' : 'mr-auto items-start' }}">
                <span class="text-[10px] text-[#746B77] mb-1 px-1 font-medium">
                    {{ $pesan->pengirim->nama ?? 'Pengguna' }}
                </span>
                <div class="p-4 rounded-2xl text-xs sm:text-sm leading-relaxed shadow-2xs {{ $isMine ? 'bg-[#643B62] text-white rounded-br-xs' : 'bg-[#EEE7F2] text-[#3E293F] rounded-bl-xs' }}">
                    <p class="whitespace-pre-line">{{ $pesan->isi_pesan }}</p>
                </div>
                <span class="text-[10px] text-[#746B77]/80 mt-1 px-1">
                    {{ $pesan->waktu_kirim }}
                </span>
            </div>
        @empty
            <div class="text-center py-16 my-auto">
                <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-xl mb-3 shadow-inner">
                    💬
                </div>
                <p class="text-xs text-[#746B77]">Belum ada pesan. Silakan mulai percakapan di bawah.</p>
            </div>
        @endforelse
    </div>

    {{-- Form Box atau Status Berakhir --}}
    @if (!in_array($konsultasi->status, ['selesai', 'batal']))
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#DCD5DD]">
            <form action="{{ route('pengguna.chat.store', $konsultasi->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <textarea name="isi_pesan" rows="3" placeholder="Tulis pesan Anda..." required
                              class="w-full rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] focus:border-[#643B62] focus:ring-1 focus:ring-[#643B62] focus:outline-none px-4 py-3 text-xs sm:text-sm text-[#3E293F] placeholder-[#746B77]/50 shadow-inner transition resize-y">{{ old('isi_pesan') }}</textarea>
                    @error('isi_pesan')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs font-semibold shadow-sm transition flex items-center gap-2 active:scale-[0.98]">
                        <span>Kirim Pesan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-[#EEE7F2]/60 rounded-3xl p-6 text-center border border-[#DCD5DD]">
            <p class="text-xs font-medium text-[#746B77]">Konsultasi telah berakhir. Anda hanya dapat membaca percakapan di atas.</p>
        </div>
    @endif
</div>
@endsection