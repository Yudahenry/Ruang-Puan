@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 transition-shadow duration-200 hover:shadow-md">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-berry-900 tracking-tight">Panel Administrasi Ruang Puan</h1>
        <p class="text-sm text-ink-600 mt-1">Pusat kendali operasional, verifikasi konselor, manajemen laporan, dan direktori bantuan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- 1. Verifikasi Konselor -->
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-berry-100 text-berry-700 flex items-center justify-center font-bold mb-4">
                    👩‍⚕️
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Verifikasi Konselor</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Tinjau dokumen legalitas STR/SIPP calon konselor dan berikan persetujuan akun.</p>
            </div>
            <a href="{{ route('admin.konselor.index') }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                Tinjau Pengajuan &rarr;
            </a>
        </div>

        <!-- 2. Kelola Laporan -->
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-rose-200 text-rose-600 flex items-center justify-center font-bold mb-4">
                    📁
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Kelola Laporan</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Pantau laporan masuk dari penyintas, perbarui status, dan berikan tanggapan penanganan.</p>
            </div>
            <a href="{{ route('admin.laporan.index') }}" 
               class="inline-flex items-center justify-center px-4 py-2 border border-rose-600/40 text-rose-600 hover:bg-rose-200/50 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                Buka Laporan &rarr;
            </a>
        </div>

        <!-- 3. Kelola Edukasi -->
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 flex flex-col justify-between transition-shadow duration-200 hover:shadow-md">
            <div>
                <div class="w-10 h-10 rounded-lg bg-lavender-200 text-lavender-600 flex items-center justify-center font-bold mb-4">
                    📚
                </div>
                <h3 class="font-bold text-berry-900 text-lg mb-2">Kelola Edukasi</h3>
                <p class="text-xs text-ink-600 mb-6 leading-relaxed">Publikasikan artikel, modul pencegahan kekerasan, dan kategori edukasi perempuan.</p>
            </div>
            <a href="{{ route('admin.edukasi.index') }}" 
               class="inline-flex items-center justify-center px-4 py-2 border border-lavender-600/40 text-lavender-600 hover:bg-lavender-200/50 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                Kelola Artikel &rarr;
            </a>
        </div>

        <!-- 4. Direktori Layanan -->
        <div class="bg-cream-50/70 border border-cream-200 rounded-xl p-6 md:col-span-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 transition-shadow duration-200 hover:shadow-md">
            <div>
                <h3 class="font-bold text-berry-900 text-lg mb-1">Direktori Lembaga Bantuan</h3>
                <p class="text-xs text-ink-600 leading-relaxed">Tambah, ubah, atau hapus data lembaga mitra hotline, UPTD PPA, dan LBH wilayah.</p>
            </div>
            <a href="{{ route('admin.direktori.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 bg-berry-900 hover:bg-berry-700 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]">
                Kelola Direktori Layanan &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
