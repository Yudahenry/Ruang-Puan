@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-8">
    <h1 class="text-3xl font-bold text-berry-900 mb-2">Panel Administrasi</h1>
    <p class="text-ink-600 mb-6">Pusat kendali operasional, verifikasi konselor, dan manajemen konten Ruang Puan.</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-berry-700 text-lg mb-2">Verifikasi Konselor</h3>
            <p class="text-sm text-ink-600 mb-4">Tinjau dokumen STR/SIPP dan setujui atau tolak pengajuan akun konselor.</p>
            <a href="#" class="inline-block px-4 py-2 bg-berry-700 text-white rounded-lg text-sm font-medium hover:bg-berry-900 transition">Tinjau Pengajuan</a>
        </div>
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-berry-700 text-lg mb-2">Kelola Laporan</h3>
            <p class="text-sm text-ink-600 mb-4">Pantau laporan masuk, tanggapi, dan teruskan ke lembaga bantuan.</p>
            <a href="#" class="inline-block px-4 py-2 bg-rose-600 text-white rounded-lg text-sm font-medium hover:bg-berry-700 transition">Kelola Laporan</a>
        </div>
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-berry-700 text-lg mb-2">Kelola Edukasi</h3>
            <p class="text-sm text-ink-600 mb-4">Tambah dan perbarui artikel edukasi serta kategori hukum/reproduksi.</p>
            <a href="#" class="inline-block px-4 py-2 bg-lavender-600 text-white rounded-lg text-sm font-medium hover:bg-lavender-400 transition">Kelola Materi</a>
        </div>
    </div>
</div>
@endsection
