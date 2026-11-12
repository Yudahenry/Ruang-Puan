@extends('layouts.pengguna')

@section('pengguna-content')
<div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-6 sm:p-10 my-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-6 border-b border-[#DCD5DD]">
        <div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F]">Riwayat Laporan Saya</h1>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1">Daftar laporan yang pernah Anda ajukan beserta status penanganannya.</p>
        </div>
        <div>
            <a href="{{ route('pelaporan.buat') }}" class="px-5 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white font-semibold rounded-2xl text-xs sm:text-sm shadow-sm transition-all duration-200 active:scale-[0.98] inline-flex items-center gap-1.5">
                <span>+ Buat Laporan Baru</span>
            </a>
        </div>
    </div>

    @if($laporans->isEmpty())
        <div class="text-center py-16 bg-[#FCFAF8] rounded-3xl border border-[#DCD5DD] max-w-lg mx-auto p-6 shadow-2xs">
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-xl mb-3 shadow-inner">
                📂
            </div>
            <p class="text-xs font-bold text-[#3E293F] mb-1">Belum Ada Laporan</p>
            <p class="text-xs text-[#746B77] mb-4">Belum ada laporan yang Anda buat saat ini.</p>
            <a href="{{ route('pelaporan.buat') }}" class="inline-flex items-center px-4 py-2.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold transition">
                Buat laporan pertama Anda di sini &rarr;
            </a>
        </div>
    @else
        <div class="overflow-x-auto rounded-2xl border border-[#DCD5DD] shadow-2xs">
            <table class="w-full text-left border-collapse text-xs sm:text-sm text-[#3E293F]">
                <thead>
                    <tr class="bg-[#EEE7F2]/60 text-[#3E293F] border-b border-[#DCD5DD]">
                        <th class="p-4 font-bold">Kode Pelacakan</th>
                        <th class="p-4 font-bold">Jenis Kasus</th>
                        <th class="p-4 font-bold">Tanggal</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD5DD]/50">
                    @foreach($laporans as $laporan)
                        <tr class="hover:bg-[#FCFAF8] transition">
                            <td class="p-4 font-mono font-bold text-[#643B62]">{{ $laporan->kode_pelacakan }}</td>
                            <td class="p-4 capitalize font-medium text-[#3E293F]">{{ str_replace('_', ' ', $laporan->jenis_kasus) }}</td>
                            <td class="p-4 text-[#746B77]">{{ $laporan->created_at?->format('d M Y H:i') }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-semibold tracking-wide
                                    @if($laporan->status === 'selesai') bg-emerald-100 text-emerald-800
                                    @elseif($laporan->status === 'ditolak' || $laporan->status === 'ditutup') bg-rose-100 text-rose-800
                                    @else bg-amber-100 text-amber-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('pelaporan.lacak', $laporan->kode_pelacakan) }}" class="px-3.5 py-2 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-semibold transition shadow-2xs">
                                    Lacak / Detail &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            {{ $laporans->links() }}
        </div>
    @endif
</div>
@endsection