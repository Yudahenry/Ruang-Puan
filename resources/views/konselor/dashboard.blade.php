@extends('layouts.konselor')

@section('konselor-content')
<div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-8">
    <h1 class="text-3xl font-bold text-lavender-600 mb-2">Dashboard Konselor</h1>
    <p class="text-ink-600 mb-6">Kelola jadwal konsultasi dan sesi chat Anda dengan klien.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-lavender-600 text-lg mb-2">Jadwal Praktik</h3>
            <p class="text-sm text-ink-600 mb-4">Atur ketersediaan waktu dan slot jam konsultasi Anda.</p>
            <a href="#" class="inline-block px-4 py-2 bg-lavender-600 text-white rounded-lg text-sm font-medium hover:bg-lavender-400 transition">Kelola Jadwal</a>
        </div>
        <div class="bg-cream-50 border border-cream-200 rounded-xl p-6">
            <h3 class="font-semibold text-lavender-600 text-lg mb-2">Booking Masuk</h3>
            <p class="text-sm text-ink-600 mb-4">Lihat daftar pemesanan sesi konsultasi dari klien.</p>
            <a href="#" class="inline-block px-4 py-2 bg-berry-700 text-white rounded-lg text-sm font-medium hover:bg-berry-900 transition">Lihat Booking</a>
        </div>
    </div>
</div>
@endsection
