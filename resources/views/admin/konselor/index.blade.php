@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 transition-shadow duration-200 hover:shadow-md">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Verifikasi Konselor</h1>
            <p class="text-sm text-ink-600 mt-1">Tinjau dokumen legalitas STR & SIPP calon konselor sebelum memberikan izin praktik.</p>
        </div>
        <div class="flex items-center space-x-2 bg-cream-50 p-1.5 rounded-lg border border-cream-200">
            <a href="{{ route('admin.konselor.index', ['status' => 'menunggu']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ $status === 'menunggu' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900' }}">
                Menunggu Verifikasi
            </a>
            <a href="{{ route('admin.konselor.index', ['status' => 'disetujui']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ $status === 'disetujui' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900' }}">
                Disetujui
            </a>
            <a href="{{ route('admin.konselor.index', ['status' => 'ditolak']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ $status === 'ditolak' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900' }}">
                Ditolak
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-cream-100 text-ink-900 border-b border-cream-200 text-xs font-semibold uppercase tracking-wider">
                    <th class="p-3.5">Nama & Email</th>
                    <th class="p-3.5">Legalitas (STR/SIPP)</th>
                    <th class="p-3.5">Bidang Keahlian</th>
                    <th class="p-3.5">Dokumen</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cream-200">
                @forelse($konselors as $konselor)
                    <tr class="hover:bg-cream-50/60 transition-colors duration-150">
                        <td class="p-3.5">
                            <span class="font-bold text-berry-900 block">{{ $konselor->user->nama ?? '-' }}</span>
                            <span class="text-xs text-ink-600">{{ $konselor->user->email ?? '-' }}</span>
                        </td>
                        <td class="p-3.5 text-xs text-ink-900">
                            <div>STR: <span class="font-mono font-medium">{{ $konselor->no_str ?? 'Belum diisi' }}</span></div>
                            <div>SIPP: <span class="font-mono font-medium">{{ $konselor->no_sipp ?? 'Belum diisi' }}</span></div>
                        </td>
                        <td class="p-3.5 text-xs text-ink-900">
                            {{ $konselor->bidang_keahlian ?? 'Umum' }}
                        </td>
                        <td class="p-3.5">
                            @if($konselor->dokumen_verifikasi)
                                <a href="{{ asset('storage/' . $konselor->dokumen_verifikasi) }}" target="_blank" 
                                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-cream-100 hover:bg-cream-200 text-berry-700 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <span>Lihat File</span>
                                </a>
                            @else
                                <span class="text-xs text-ink-600 italic">Belum unggah</span>
                            @endif
                        </td>
                        <td class="p-3.5">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($konselor->status_verifikasi === 'disetujui') bg-success-100 text-success-600
                                @elseif($konselor->status_verifikasi === 'ditolak') bg-danger-100 text-danger-600
                                @else bg-warning-100 text-warning-600 @endif">
                                {{ ucfirst($konselor->status_verifikasi) }}
                            </span>
                            @if($konselor->alasan_penolakan)
                                <p class="text-[11px] text-danger-600 mt-1 max-w-xs">{{ $konselor->alasan_penolakan }}</p>
                            @endif
                        </td>
                        <td class="p-3.5 text-right space-x-2 whitespace-nowrap">
                            <!-- Tombol View Detail Data & Dokumen -->
                            <button type="button" 
                                    onclick="openDetailModal({{ json_encode([
                                        'nama' => $konselor->user->nama ?? '-',
                                        'email' => $konselor->user->email ?? '-',
                                        'no_str' => $konselor->no_str ?? 'Belum diisi',
                                        'no_sipp' => $konselor->no_sipp ?? 'Belum diisi',
                                        'bidang_keahlian' => $konselor->bidang_keahlian ?? 'Umum',
                                        'status_verifikasi' => ucfirst($konselor->status_verifikasi),
                                        'dokumen_url' => $konselor->dokumen_verifikasi ? asset('storage/' . $konselor->dokumen_verifikasi) : null
                                    ]) }})"
                                    class="px-3 py-1.5 bg-cream-200 hover:bg-cream-300 text-berry-900 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                                View
                            </button>

                            @if($konselor->status_verifikasi !== 'disetujui')
                                <form method="POST" action="{{ route('admin.konselor.verifikasi', $konselor->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1.5 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                                        Setujui
                                    </button>
                                </form>
                            @endif

                            @if($konselor->status_verifikasi !== 'ditolak')
                                <button type="button"
                                        @click="$dispatch('open-confirm-modal', { 
                                            url: '{{ route('admin.konselor.tolak', $konselor->id) }}', 
                                            title: 'Tolak Pengajuan Konselor', 
                                            message: 'Masukkan alasan penolakan dokumen agar konselor dapat memperbaikinya.', 
                                            confirmText: 'Tolak Pengajuan', 
                                            withReason: true 
                                        })"
                                        class="px-3 py-1.5 border border-danger-600/40 text-danger-600 hover:bg-danger-100/50 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                                    Tolak
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-ink-600 text-sm">
                            Tidak ada data konselor dengan status "{{ $status }}".
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $konselors->links() }}
    </div>
</div>

<!-- Modal Pop-up Detail Data & Dokumen Konselor -->
<div id="modalDetailKonselor" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden p-4">
    <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl relative max-h-[90vh] overflow-y-auto border border-cream-200">
        <div class="flex justify-between items-center pb-4 border-b border-cream-200 mb-4">
            <h3 class="text-lg font-bold text-berry-900">Detail Data & Dokumen Konselor</h3>
            <button type="button" onclick="closeDetailModal()" class="text-ink-500 hover:text-ink-800 text-sm font-bold p-1">✕</button>
        </div>

        <div class="space-y-4 text-xs text-ink-700">
            <div>
                <span class="block font-semibold text-berry-900">Nama Lengkap</span>
                <p id="det-nama" class="mt-1 text-sm text-ink-900 font-medium">-</p>
            </div>
            <div>
                <span class="block font-semibold text-berry-900">Alamat Email</span>
                <p id="det-email" class="mt-1 text-sm text-ink-900 font-medium">-</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block font-semibold text-berry-900">Nomor STR</span>
                    <p id="det-str" class="mt-1 text-sm font-mono text-ink-900">-</p>
                </div>
                <div>
                    <span class="block font-semibold text-berry-900">Nomor SIPP</span>
                    <p id="det-sipp" class="mt-1 text-sm font-mono text-ink-900">-</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block font-semibold text-berry-900">Bidang Keahlian</span>
                    <p id="det-keahlian" class="mt-1 text-sm text-ink-900">-</p>
                </div>
                <div>
                    <span class="block font-semibold text-berry-900">Status Verifikasi</span>
                    <p id="det-status" class="mt-1 text-sm font-semibold">-</p>
                </div>
            </div>
            <div>
                <span class="block font-semibold text-berry-900 mb-1.5">Dokumen Legalitas (STR / SIPP)</span>
                <div id="det-dokumen-wrapper" class="p-4 bg-cream-50 rounded-xl border border-cream-200 text-center">
                    <!-- Dynamic Document Link -->
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-cream-200 text-right">
            <button type="button" onclick="closeDetailModal()" class="px-4 py-2 bg-cream-200 hover:bg-cream-300 text-ink-700 rounded-lg text-xs font-semibold transition">
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
               class="inline-flex items-center space-x-2 px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                <span>Lihat Dokumen Legalitas (PDF/Foto)</span>
            </a>
        `;
    } else {
        docWrapper.innerHTML = `<span class="text-xs text-ink-600 italic">Belum mengunggah dokumen verifikasi.</span>`;
    }

    document.getElementById('modalDetailKonselor').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('modalDetailKonselor').classList.add('hidden');
}
</script>

<x-modal-confirm />
@endsection