@extends('layouts.app')

@section('header-nav')
<header class="bg-berry-900 text-white shadow-sm border-b border-berry-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center space-x-6">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-white hover:text-rose-200 transition">
                Ruang Puan <span class="text-xs font-normal text-rose-300">| Pengguna</span>
            </a>
            <nav class="hidden md:flex space-x-4">
                <a href="#" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-berry-700 text-cream-100 transition">Beranda</a>
                <a href="#" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-berry-700 text-cream-100 transition">Pelaporan</a>
                <a href="#" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-berry-700 text-cream-100 transition">Edukasi</a>
                <a href="#" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-berry-700 text-cream-100 transition">Konsultasi</a>
                <a href="#" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-berry-700 text-cream-100 transition">Direktori</a>
            </nav>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-cream-100">Halo, {{ auth()->user()->nama ?? 'Pengguna' }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-berry-700 text-white transition font-medium">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>
@endsection

@section('content')
    @yield('pengguna-content')
@endsection
