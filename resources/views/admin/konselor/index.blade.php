@extends('layouts.admin')

@section('content')
<div class="p-6 sm:p-8 space-y-6">

    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-serif font-bold text-[#3E293F] tracking-tight">Verifikasi Akun Konselor</h1>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1">Tinjau profil dan dokumen legalitas (STR & SIPP) calon konselor sebelum menyetujui izin praktik.</p>
        </div>

        <!-- Filter Status Tab -->
        <div class="inline-flex items-center p-1.5 bg-[#EEE7F2]/70 rounded-2xl border border-[#DCD5DD] text-xs font-semibold">
            <a href="{{ route('admin.konselor.index', ['status' => 'menunggu']) }}" 
               class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'menunggu' ? 'bg-[#643B62] text-white shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]' }}">
                Menunggu Verifikasi
            </a>
            <a href="{{ route('admin.konselor.index', ['status' => 'disetujui']) }}" 
               class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'disetujui' ? 'bg-[#643B62] text-white shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]' }}">
                Disetujui
            </a>
            <a href="{{ route('admin.konselor.index', ['status' => 'ditolak']) }}" 
               class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'ditolak' ? 'bg-[#643B62] text-white shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]' }}">
                Ditolak
            </a>
        </div>
    </div>

    <!-- Alert Sukses / Error -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs sm:text-sm font-semibold shadow-2xs flex items-center gap-2">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-[#F6DEDC] border border-[#B3261E]/30 text-[#B3261E] rounded-2xl text-xs sm:text-sm shadow-2xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabel Daftar Konselor -->
    <div class="bg-white rounded-3xl shadow-sm border border-[#DCD5DD] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-[#FCFAF8] text-[#3E293F] border-b border-[#DCD5DD] text-xs font-bold uppercase tracking-wider">
                        <th class="p-4 sm:px-6">Konselor</th>
                        <th class="p-4 sm:px-6">Spesialisasi / Keahlian</th>
                        <th class="p-4 sm:px-6">Legalitas (STR/SIPP)</th>
                        <th class="p-4 sm:px-6">Dokumen</th>
                        <th class="p-4 sm:px-6">Status Verifikasi</th>
                        <th class="p-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD5DD]/60">
                    @forelse($konselors as $konselor)
                        <tr class="hover:bg-[#FCFAF8]/80 transition-colors duration-150">
                            <!-- Nama & Email -->
                            <td class="p-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center font-bold text-sm shadow-inner shrink-0">
                                        {{ strtoupper(substr($konselor->user->nama ?? 'K', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-[#3E293F] block leading-tight">{{ $konselor->user->nama ?? '-' }}</span>
                                        <span class="text-[11px] text-[#746B77]">{{ $konselor->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Spesialisasi -->
                            <td class="p-4 sm:px-6 text-xs text-[#3E293F]">
                                @if(!empty($konselor->spesialisasi))
                                    <span class="inline-block px-2.5 py-1 rounded-full bg-[#EEE7F2] text-[#643B62] text-[11px] font-semibold">
                                        {{ is_array($konselor->spesialisasi) ? implode(', ', $konselor->spesialisasi) : $konselor->spesialisasi }}
                                    </span>
                                @else
                                    <span class="text-[#746B77]">{{ $konselor->bidang_keahlian ?? 'Psikolog Klinis' }}</span>
                                @endif
                            </td>

                            <!-- Legalitas STR / SIPP -->
                            <td class="p-4 sm:px-6 text-xs text-[#3E293F]">
                                <div>STR: <span class="font-mono text-[#746B77]">{{ $konselor->no_str ?? '-' }}</span></div>
                                <div>SIPP: <span class="font-mono text-[#746B77]">{{ $konselor->no_sipp ?? '-' }}</span></div>
                            </td>

                            <!-- Dokumen Bukti Legalitas -->
                            <td class="p-4 sm:px-6">
                                @if($konselor->dokumen_verifikasi)
                                    <a href="{{ asset('storage/' . $konselor->dokumen_verifikasi) }}" target="_blank" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#643B62] rounded-xl text-xs font-semibold transition active:scale-[0.98]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        <span>Lihat Berkas</span>
                                    </a>
                                @else
                                    <span class="text-xs text-[#746B77] italic">Belum unggah</span>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="p-4 sm:px-6">
                                @if($konselor->status_verifikasi === 'disetujui')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Disetujui
                                    </span>
                                @elseif($konselor->status_verifikasi === 'ditolak')
                                    <div>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> Ditolak
                                        </span>
                                        @if($konselor->alasan_penolakan)
                                            <p class="text-[11px] text-rose-600 mt-1 max-w-xs leading-tight">{{ $konselor->alasan_penolakan }}</p>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                    </span>
                                @endif
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="p-4 sm:px-6 text-right space-x-2 whitespace-nowrap">
                                <!-- Tombol Modal Detail -->
                                <button type="button" 
                                        onclick="openDetailModal({{ json_encode([
                                            'nama' => $konselor->user->nama ?? '-',
                                            'email' => $konselor->user->email ?? '-',
                                            'no_str' => $konselor->no_str ?? 'Belum diisi',
                                            'no_sipp' => $konselor->no_sipp ?? 'Belum diisi',
                                            'bidang_keahlian' => !empty($konselor->spesialisasi) ? (is_array($konselor->spesialisasi) ? implode(', ', $konselor->spesialisasi) : $konselor->spesialisasi) : ($konselor->bidang_keahlian ?? 'Umum'),
                                            'status_verifikasi' => ucfirst($konselor->status_verifikasi),
                                            'dokumen_url' => $konselor->dokumen_verifikasi ? asset('storage/' . $konselor->dokumen_verifikasi) : null
                                        ]) }})"
                                        class="px-3.5 py-1.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-semibold transition active:scale-[0.98]">
                                    Detail
                                </button>

                                <!-- Tombol Setujui -->
                                @if($konselor->status_verifikasi !== 'disetujui')
                                    <form method="POST" action="{{ route('admin.konselor.verifikasi', $konselor->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui akun konselor ini?')"
                                                class="px-3.5 py-1.5 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold shadow-sm transition active:scale-[0.98]">
                                            Setujui
                                        </button>
                                    </form>
                                @endif

                                <!-- Tombol Tolak -->
                                @if($konselor->status_verifikasi !== 'ditolak')
                                    <button type="button"
                                            @click="$dispatch('open-confirm-modal', { 
                                                url: '{{ route('admin.konselor.tolak', $konselor->id) }}', 
                                                title: 'Tolak Pengajuan Konselor', 
                                                message: 'Masukkan alasan penolakan dokumen agar calon konselor dapat memperbaikinya.', 
                                                confirmText: 'Tolak Pengajuan', 
                                                withReason: true 
                                            })"
                                            class="px-3.5 py-1.5 border border-rose-300 text-rose-700 hover:bg-rose-50 rounded-xl text-xs font-semibold transition active:scale-[0.98]">
                                        Tolak
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-[#746B77] text-xs sm:text-sm">
                                <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto text-xl mb-3 shadow-inner">
                                    📋
                                </div>
                                Tidak ada data calon konselor dengan status <span class="font-bold">"{{ $status }}"</span>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($konselors->hasPages())
            <div class="p-4 border-t border-[#DCD5DD]/60">
                {{ $konselors->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Pop-up Detail Konselor -->
<div id="modalDetailKonselor" class="fixed inset-0 z-50 flex items-center justify-center bg-[#3E293F]/50 backdrop-blur-xs hidden p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto border border-[#DCD5DD]">
        <div class="flex justify-between items-center pb-4 border-b border-[#DCD5DD]/70 mb-5">
            <h3 class="text-lg font-serif font-bold text-[#3E293F]">Detail Berkas & Profil Konselor</h3>
            <button type="button" onclick="closeDetailModal()" class="text-[#746B77] hover:text-[#3E293F] text-base font-bold p-1">✕</button>
        </div>

        <div class="space-y-4 text-xs">
            <div>
                <span class="block font-bold text-[#3E293F] uppercase tracking-wider text-[10px]">Nama Lengkap</span>
                <p id="det-nama" class="mt-1 text-sm text-[#3E293F] font-semibold">-</p>
            </div>
            <div>
                <span class="block font-bold text-[#3E293F] uppercase tracking-wider text-[10px]">Alamat Email</span>
                <p id="det-email" class="mt-1 text-sm text-[#746B77] font-medium">-</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block font-bold text-[#3E293F] uppercase tracking-wider text-[10px]">Nomor STR</span>
                    <p id="det-str" class="mt-1 text-sm font-mono text-[#3E293F]">-</p>
                </div>
                <div>
                    <span class="block font-bold text-[#3E293F] uppercase tracking-wider text-[10px]">Nomor SIPP</span>
                    <p id="det-sipp" class="mt-1 text-sm font-mono text-[#3E293F]">-</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block font-bold text-[#3E293F] uppercase tracking-wider text-[10px]">Bidang / Spesialisasi</span>
                    <p id="det-keahlian" class="mt-1 text-sm text-[#3E293F] font-medium">-</p>
                </div>
                <div>
                    <span class="block font-bold text-[#3E293F] uppercase tracking-wider text-[10px]">Status Verifikasi</span>
                    <p id="det-status" class="mt-1 text-sm font-bold text-[#643B62]">-</p>
                </div>
            </div>
            <div>
                <span class="block font-bold text-[#3E293F] uppercase tracking-wider text-[10px] mb-2">Dokumen Legalitas (STR / SIPP)</span>
                <div id="det-dokumen-wrapper" class="p-4 bg-[#FCFAF8] rounded-2xl border border-[#DCD5DD] text-center">
                    <!-- Dynamic Document Link -->
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[#DCD5DD]/70 text-right">
            <button type="button" onclick="closeDetailModal()" class="px-5 py-2.5 bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#3E293F] rounded-xl text-xs font-bold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openDetailModal(data) {
    document.getElementById('det-nama').innerText = data.nama;
    document.getElementById('det-email').innerText = data.email;
    document.getElementById('det-str').innerText = data.no_str;
    document.getElementById('det-sipp').innerText = data.no_sipp;
    document.getElementById('det-keahlian').innerText = data.bidang_keahlian;
    document.getElementById('det-status').innerText = data.status_verifikasi;

    const docWrapper = document.getElementById('det-dokumen-wrapper');
    if (data.dokumen_url) {
        docWrapper.innerHTML = `
            <a href="${data.dokumen_url}" target="_blank" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-xl text-xs font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                <span>Lihat Dokumen Legalitas (PDF/Gambar)</span>
            </a>
        `;
    } else {
        docWrapper.innerHTML = `<span class="text-xs text-[#746B77] italic">Belum mengunggah dokumen verifikasi.</span>`;
    }

    document.getElementById('modalDetailKonselor').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('modalDetailKonselor').classList.add('hidden');
}
</script>

<x-modal-confirm />
@endsection