@extends('layouts.app')

@section('header-nav')
    {{-- Custom navbar for pengguna beranda - rendered inside content --}}
    <header class="bg-[#FCFAF8]/95 backdrop-blur-md sticky top-0 z-40 border-b border-[#DCD5DD] shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('pengguna.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-2xl bg-[#643B62] text-white flex items-center justify-center font-bold text-sm shadow-inner group-hover:scale-105 transition">
                            RP
                        </div>
                        <div>
                            <span class="font-serif font-bold text-xl text-[#3E293F] tracking-tight block leading-tight">Ruang Puan</span>
                            <span class="text-[11px] text-[#746B77] italic block leading-tight">Ruang untuk didengar</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Pill Style) -->
                <nav class="hidden md:flex items-center space-x-1 bg-[#EEE7F2]/60 p-1 rounded-full border border-[#DCD5DD]">
                    <a href="{{ route('pengguna.dashboard') }}" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('pengguna.dashboard') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                        Beranda
                    </a>
                    <a href="{{ route('pelaporan.riwayat') }}" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('pelaporan.*') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                        Pelaporan
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('edukasi.*') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                        Edukasi
                    </a>
                    <a href="{{ route('konsultasi.index') }}" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('konsultasi.*') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                        Konsultasi
                    </a>
                </nav>

                <!-- User Profile Badge -->
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2.5 px-3 py-1.5 rounded-full bg-[#EEE7F2]/60 border border-[#DCD5DD]">
                        <div class="w-7 h-7 rounded-full bg-[#643B62] text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                            {{ strtoupper(substr(auth()->user()->nama ?? 'P', 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-[#3E293F]">
                            {{ auth()->user()->nama ?? 'Pengguna' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <main class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex-1">
        @yield('pengguna-content')
    </main>
@endsection