@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 my-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Tagihan Pembayaran Konsultasi</h1>
        <p class="text-xs text-ink-600 mt-1">Selesaikan pembayaran untuk mengonfirmasi jadwal konsultasi Anda.</p>
    </div>

    <div class="space-y-4 text-sm text-ink-700 bg-cream-50 p-5 rounded-xl border border-cream-200 mb-6">
        <div class="flex justify-between border-b border-cream-200 pb-2">
            <span class="font-semibold text-berry-900">Konselor</span>
            <span class="text-ink-900 font-medium">{{ $pemesanan->jadwal->konselor->user->nama ?? '-' }}</span>
        </div>
        <div class="flex justify-between border-b border-cream-200 pb-2">
            <span class="font-semibold text-berry-900">Jadwal Sesi</span>
            <span class="text-ink-900 font-medium">{{ $pemesanan->jadwal->tanggal ?? '-' }}</span>
        </div>
        <div class="flex justify-between border-b border-cream-200 pb-2">
            <span class="font-semibold text-berry-900">Status Pembayaran</span>
            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold 
                {{ $pemesanan->status_pembayaran === 'lunas' ? 'bg-success-100 text-success-600' : 'bg-warning-100 text-warning-600' }}">
                {{ ucfirst($pemesanan->status_pembayaran ?? 'pending') }}
            </span>
        </div>
        <div class="flex justify-between pt-1">
            <span class="font-bold text-berry-900 text-base">Total Biaya</span>
            <span class="text-berry-900 font-bold text-base">Rp {{ number_format($pemesanan->total_biaya ?? 150000, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($pemesanan->status_pembayaran !== 'lunas')
        <form action="{{ route('konsultasi.bayar', $pemesanan->id) }}" method="POST" class="space-y-4" id="formPembayaran">
            @csrf
            <div>
                <label for="metode_pembayaran" class="block text-sm font-semibold text-ink-900 mb-1">Pilih Metode Pembayaran</label>
                <select id="metode_pembayaran" name="metode_pembayaran" required class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm transition">
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>

            <!-- Bagian Form Transfer Bank -->
            <div id="sectionBank" class="space-y-3 hidden p-4 bg-cream-50 rounded-lg border border-cream-200">
                <div>
                    <label class="block text-xs font-semibold text-ink-900 mb-1">Jenis Bank</label>
                    <select name="jenis_bank" id="jenis_bank" class="w-full rounded-lg border-cream-200 bg-white px-3 py-1.5 text-sm">
                        <option value="">-- Pilih Bank --</option>
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BNI">BNI</option>
                        <option value="BRI">BRI</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-ink-900 mb-1">Nomor Rekening Pengirim</label>
                    <input type="text" name="no_rekening" id="no_rekening" placeholder="Masukkan nomor rekening Anda" class="w-full rounded-lg border-cream-200 bg-white px-3 py-1.5 text-sm">
                </div>
            </div>

            <!-- Bagian Form E-Wallet -->
            <div id="sectionEwallet" class="space-y-3 hidden p-4 bg-cream-50 rounded-lg border border-cream-200">
                <div>
                    <label class="block text-xs font-semibold text-ink-900 mb-1">Jenis E-Wallet</label>
                    <select name="jenis_ewallet" id="jenis_ewallet" class="w-full rounded-lg border-cream-200 bg-white px-3 py-1.5 text-sm">
                        <option value="">-- Pilih E-Wallet --</option>
                        <option value="GoPay">GoPay</option>
                        <option value="OVO">OVO</option>
                        <option value="Dana">Dana</option>
                        <option value="ShopeePay">ShopeePay</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-ink-900 mb-1">Nomor HP / Akun E-Wallet</label>
                    <input type="text" name="no_ewallet" id="no_ewallet" placeholder="Contoh: 081234567890" class="w-full rounded-lg border-cream-200 bg-white px-3 py-1.5 text-sm">
                </div>
            </div>

            <button type="submit" id="btnBayar" 
                class="w-full py-2.5 px-4 bg-berry-700 hover:bg-berry-900 text-white font-semibold rounded-lg shadow-sm transition-all duration-200 active:scale-[0.98]">
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
                const form = document.getElementById('formPembayaran');

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
            });
        </script>
    @else
        <div class="text-center py-4">
            <p class="text-success-600 font-semibold text-sm mb-4">Pembayaran untuk sesi konsultasi ini sudah lunas.</p>
            <a href="{{ route('konsultasi.index') }}" class="px-4 py-2 bg-cream-200 text-ink-700 rounded-lg text-xs font-semibold hover:bg-cream-300 transition">
                Kembali ke Daftar Konsultasi
            </a>
        </div>
    @endif
</div>
@endsection