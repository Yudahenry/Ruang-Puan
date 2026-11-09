@extends('layouts.app')

@section('header-nav')
    {{-- Custom navbar for pengguna beranda - rendered inside content --}}
    <nav class="bg-white border-b border-cream-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('pengguna.dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-9 h-9 rounded-xl bg-berry-800 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                            RP
                        </div>
                        <span class="font-bold text-berry-900 text-lg tracking-tight">Ruang Puan</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('pengguna.dashboard') }}" class="text-xs font-semibold {{ request()->routeIs('pengguna.dashboard') ? 'text-berry-800 border-b-2 border-berry-800 pb-1' : 'text-ink-600 hover:text-berry-800' }}">
                        Beranda
                    </a>
                    <a href="{{ route('pelaporan.riwayat') }}" class="text-xs font-semibold {{ request()->routeIs('pelaporan.*') ? 'text-berry-800 border-b-2 border-berry-800 pb-1' : 'text-ink-600 hover:text-berry-800' }}">
                        Pelaporan
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="text-xs font-semibold {{ request()->routeIs('edukasi.*') ? 'text-berry-800 border-b-2 border-berry-800 pb-1' : 'text-ink-600 hover:text-berry-800' }}">
                        Edukasi
                    </a>
                    <!-- PASTIKAN ROUTE DI BAWAH INI KONSULTASI.INDEX, BUKAN EDUKASI -->
                    <a href="{{ route('konsultasi.index') }}" class="text-xs font-semibold {{ request()->routeIs('konsultasi.*') ? 'text-berry-800 border-b-2 border-berry-800 pb-1' : 'text-ink-600 hover:text-berry-800' }}">
                        Konsultasi
                    </a>
                </div>

                <!-- User Profile Dropdown / Actions -->
                <div class="flex items-center space-x-4">
                    <div class="dropdown relative">
                        <span class="text-xs font-medium text-ink-800">
                            {{ auth()->user()->nama ?? 'Pengguna' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <main class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @yield('pengguna-content')
    </main>
@endsection