@extends('layouts.app')

@section('header-nav')
<header class="bg-berry-900 text-white shadow-sm border-b border-berry-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center space-x-6">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-white hover:text-rose-200 transition">
                Ruang Puan <span class="text-xs font-normal text-rose-300">| Pengguna</span>
            </a>
            <nav class="hidden md:flex space-x-2 text-sm">
                <a href="{{ route('pengguna.dashboard') }}" class="px-3 py-1.5 rounded-lg font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('pengguna.dashboard') ? 'bg-berry-700 text-white shadow-sm' : 'hover:bg-berry-700/60 text-cream-100' }}">Beranda</a>
                <a href="{{ route('pelaporan.buat') }}" class="px-3 py-1.5 rounded-lg font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('pelaporan.buat') ? 'bg-berry-700 text-white shadow-sm' : 'hover:bg-berry-700/60 text-cream-100' }}">Buat Laporan</a>
                <a href="{{ route('pelaporan.riwayat') }}" class="px-3 py-1.5 rounded-lg font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('pelaporan.riwayat') ? 'bg-berry-700 text-white shadow-sm' : 'hover:bg-berry-700/60 text-cream-100' }}">Riwayat Laporan</a>
                <a href="{{ route('edukasi.index') }}" class="px-3 py-1.5 rounded-lg font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('edukasi.*') ? 'bg-berry-700 text-white shadow-sm' : 'hover:bg-berry-700/60 text-cream-100' }}">Edukasi</a>
                <a href="{{ route('direktori.index') }}" class="px-3 py-1.5 rounded-lg font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('direktori.*') ? 'bg-berry-700 text-white shadow-sm' : 'hover:bg-berry-700/60 text-cream-100' }}">Direktori Layanan</a>
            </nav>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('profile.edit') }}" class="text-xs text-cream-100 hover:text-rose-200 transition font-medium flex items-center space-x-1">
                <span>👤</span>
                <span class="hidden sm:inline">{{ auth()->user()->nama ?? 'Pengguna' }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-berry-700 text-white transition-all duration-200 active:scale-[0.98] font-medium shadow-sm">
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
