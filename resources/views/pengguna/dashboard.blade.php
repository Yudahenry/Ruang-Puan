@extends('layouts.pengguna')

@section('pengguna-content')
<div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-8">
    <h1 class="text-3xl font-bold text-berry-900 mb-2">Dashboard Pengguna</h1>
    <p class="text-ink-600 mb-6">Selamat datang di Ruang Puan. Anda login sebagai Pengguna / Pelapor.</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-berry-700 text-lg mb-2">Buat Laporan</h3>
            <p class="text-sm text-ink-600 mb-4">Laporkan kasus kekerasan atau diskriminasi secara aman, baik bernama maupun anonim.</p>
            <a href="#" class="inline-block px-4 py-2 bg-berry-700 text-white rounded-lg text-sm font-medium hover:bg-berry-900 transition">Buat Laporan</a>
        </div>
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-berry-700 text-lg mb-2">Edukasi & Hak</h3>
            <p class="text-sm text-ink-600 mb-4">Pelajari hak-hak perempuan, artikel kesehatan reproduksi, dan pencegahan.</p>
            <a href="#" class="inline-block px-4 py-2 bg-rose-600 text-white rounded-lg text-sm font-medium hover:bg-berry-700 transition">Baca Edukasi</a>
        </div>
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-berry-700 text-lg mb-2">Konsultasi Profesional</h3>
            <p class="text-sm text-ink-600 mb-4">Jadwalkan sesi konsultasi psikologis dengan konselor terverifikasi kami.</p>
            <a href="#" class="inline-block px-4 py-2 bg-lavender-600 text-white rounded-lg text-sm font-medium hover:bg-lavender-400 transition">Cari Konselor</a>
        </div>
    </div>
</div>
@endsection
