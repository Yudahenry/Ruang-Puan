@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Tombol Atas: Kembali & Cetak PDF -->
    <div class="mb-6 flex items-center justify-between">
        @php
            $isKonselor = auth()->check() && auth()->user()->role === 'konselor';
        @endphp

        <a href="{{ $isKonselor ? route('konselor.booking') : route('konsultasi.index') }}" 
           class="text-xs font-semibold text-[#643B62] hover:underline inline-flex items-center gap-1">
            &larr; Kembali ke {{ $isKonselor ? 'Booking Masuk' : 'Daftar Konsultasi' }}
        </a>

        <button onclick="window.print()" class="px-4 py-2 bg-[#643B62] text-white rounded-xl text-xs font-semibold shadow-sm hover:bg-[#4E2D4C] transition inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Simpan PDF
        </button>
    </div>

    <!-- Kotak Utama Invoice -->
    <div class="bg-white rounded-3xl border border-[#DCD5DD] p-8 sm:p-10 shadow-sm relative overflow-hidden">
        
        <!-- Header Invoice -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-[#DCD5DD]/60 gap-4">
            <div>
                <span class="px-3 py-1 bg-[#EEE7F2] text-[#643B62] rounded-full text-[10px] font-bold tracking-wider uppercase">
                    INVOICE PEMESANAN
                </span>
                <h1 class="text-2xl font-serif font-bold text-[#3E293F] mt-2">Ruang Puan</h1>
                <p class="text-xs text-[#746B77]">Ruang untuk didengar · Layanan Konsultasi</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-xs text-[#746B77] block">Nomor Invoice</span>
                <span class="font-mono font-bold text-base text-[#3E293F]">INV-{{ str_pad($pemesanan->id ?? 1, 5, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[11px] text-[#746B77] block mt-1">Tanggal Pemesanan: {{ optional($pemesanan->created_at)->format('d M Y, H:i') ?? now()->format('d M Y') }} WIB</span>
            </div>
        </div>

        <!-- Info Klien & Konselor -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 my-6">
            <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD]/40">
                <span class="text-[11px] font-bold text-[#746B77] uppercase tracking-wider block mb-1">Ditagihkan Kepada</span>
                <p class="font-bold text-[#3E293F] text-sm">{{ $pemesanan->user->nama ?? $pemesanan->user->name ?? 'Klien' }}</p>
                <p class="text-xs text-[#746B77]">{{ $pemesanan->user->email ?? '-' }}</p>
            </div>
            <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD]/40">
                <span class="text-[11px] font-bold text-[#746B77] uppercase tracking-wider block mb-1">Detail Konselor</span>
                <p class="font-bold text-[#3E293F] text-sm">{{ optional($pemesanan->jadwal->konselor->user)->nama ?? optional($pemesanan->jadwal->konselor)->nama ?? 'Konselor' }}</p>
                <p class="text-xs text-[#746B77]">Metode Pembayaran: {{ $pemesanan->metode_pembayaran ?? 'Transfer Bank / E-Wallet' }}</p>
            </div>
        </div>

        <!-- Tabel Rincian Layanan -->
        <div class="mt-6 border border-[#DCD5DD]/60 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#EEE7F2]/60 text-[#3E293F] text-xs font-bold border-b border-[#DCD5DD]/60">
                        <th class="py-3 px-4">DESKRIPSI LAYANAN</th>
                        <th class="py-3 px-4">JADWAL KONSULTASI</th>
                        <th class="py-3 px-4 text-right">BIAYA</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-[#3E293F] divide-y divide-[#DCD5DD]/40">
                    <tr>
                        <td class="py-4 px-4">
                            <span class="font-bold block">Sesi Konsultasi Privat</span>
                            <span class="text-[#746B77] text-[11px]">Konselor: {{ optional($pemesanan->jadwal->konselor->user)->nama ?? 'Konselor' }}</span>
                        </td>
                        <td class="py-4 px-4 text-[#746B77]">
                            @if($pemesanan->jadwal)
                                {{ \Carbon\Carbon::parse($pemesanan->jadwal->tanggal)->translatedFormat('l, d F Y') }}<br>
                                Pukul {{ \Carbon\Carbon::parse($pemesanan->jadwal->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($pemesanan->jadwal->jam_selesai)->format('H:i') }} WIB
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-4 px-4 text-right font-semibold">
                            Rp {{ number_format($pemesanan->total_biaya ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Status & Total Pembayaran -->
        <div class="mt-6 pt-6 border-t border-[#DCD5DD]/60 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs text-[#746B77] block">Status Pemesanan:</span>
                <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold 
                    {{ strtolower($pemesanan->status_pembayaran ?? $pemesanan->status) === 'lunas' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ ucfirst($pemesanan->status_pembayaran ?? $pemesanan->status) }}
                </span>
            </div>
            <div class="text-left sm:text-right w-full sm:w-auto">
                <span class="text-xs text-[#746B77] block">Total Pembayaran</span>
                <span class="text-2xl font-serif font-bold text-[#643B62]">
                    Rp {{ number_format($pemesanan->total_biaya ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>

    </div>

    <!-- Jika belum lunas, tampilkan form pembayaran di bawah invoice -->
    @if($pemesanan->status_pembayaran !== 'lunas')
        <div class="mt-8 bg-white rounded-3xl border border-[#DCD5DD] p-8 shadow-sm">
            <h3 class="text-lg font-bold text-[#3E293F] mb-4">Selesaikan Pembayaran</h3>
            <form action="{{ route('konsultasi.bayar', $pemesanan->id) }}" method="POST" class="space-y-4" id="formPembayaran">
                @csrf
                <div>
                    <label for="metode_pembayaran" class="block text-xs font-semibold text-[#3E293F] mb-1">Pilih Metode Pembayaran</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required class="w-full rounded-xl border-[#DCD5DD] bg-[#FCFAF8] focus:border-[#643B62] focus:ring-[#643B62] px-4 py-2.5 text-xs text-[#3E293F] border transition">
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                </div>

                <!-- Bagian Form Transfer Bank -->
                <div id="sectionBank" class="space-y-3 hidden p-4 bg-[#FCFAF8] rounded-2xl border border-[#DCD5DD]/60">
                    <div>
                        <label class="block text-[11px] font-semibold text-[#3E293F] mb-1">Jenis Bank</label>
                        <select name="jenis_bank" id="jenis_bank" class="w-full rounded-xl border-[#DCD5DD] bg-white px-3 py-2 text-xs">
                            <option value="">-- Pilih Bank --</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#3E293F] mb-1">Nomor Rekening Pengirim</label>
                        <input type="text" name="no_rekening" id="no_rekening" placeholder="Masukkan nomor rekening Anda" class="w-full rounded-xl border-[#DCD5DD] bg-white px-3 py-2 text-xs">
                    </div>
                </div>

                <!-- Bagian Form E-Wallet -->
                <div id="sectionEwallet" class="space-y-3 hidden p-4 bg-[#FCFAF8] rounded-2xl border border-[#DCD5DD]/60">
                    <div>
                        <label class="block text-[11px] font-semibold text-[#3E293F] mb-1">Jenis E-Wallet</label>
                        <select name="jenis_ewallet" id="jenis_ewallet" class="w-full rounded-xl border-[#DCD5DD] bg-white px-3 py-2 text-xs">
                            <option value="">-- Pilih E-Wallet --</option>
                            <option value="GoPay">GoPay</option>
                            <option value="OVO">OVO</option>
                            <option value="Dana">Dana</option>
                            <option value="ShopeePay">ShopeePay</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#3E293F] mb-1">Nomor HP / Akun E-Wallet</label>
                        <input type="text" name="no_ewallet" id="no_ewallet" placeholder="Contoh: 081234567890" class="w-full rounded-xl border-[#DCD5DD] bg-white px-3 py-2 text-xs">
                    </div>
                </div>

                <button type="submit" id="btnBayar" 
                    class="w-full py-3 px-4 bg-[#643B62] hover:bg-[#4E2D4C] text-white font-semibold rounded-xl shadow-sm transition-all duration-200 text-xs">
                    Bayar Sekarang
                </button>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const metodeSelect = document.getElementById('metode_pembayaran');
                    const sectionBank = document.getElementById('sectionBank');
                    const sectionEwallet = document.getElementById('sectionEwallet');
                    const jenisBank = document.getElementById('jenis_bank');
                    const noRekening = document.getElementById('no_rekening');
                    const jenisEwallet = document.getElementById('jenis_ewallet');
                    const noEwallet = document.getElementById('no_ewallet');

                    if (metodeSelect) {
                        metodeSelect.addEventListener('change', function () {
                            const val = this.value;
                            sectionBank.classList.add('hidden');
                            sectionEwallet.classList.add('hidden');

                            if (val === 'Transfer Bank') {
                                sectionBank.classList.remove('hidden');
                                jenisBank.setAttribute('required', 'required');
                                noRekening.setAttribute('required', 'required');
                                jenisEwallet.removeAttribute('required');
                                noEwallet.removeAttribute('required');
                            } else if (val === 'E-Wallet') {
                                sectionEwallet.classList.remove('hidden');
                                jenisEwallet.setAttribute('required', 'required');
                                noEwallet.setAttribute('required', 'required');
                                jenisBank.removeAttribute('required');
                                noRekening.removeAttribute('required');
                            } else {
                                jenisBank.removeAttribute('required');
                                noRekening.removeAttribute('required');
                                jenisEwallet.removeAttribute('required');
                                noEwallet.removeAttribute('required');
                            }
                        });
                    }
                });
            </script>
        </div>
    @endif

</div>
@endsection