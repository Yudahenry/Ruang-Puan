@extends('layouts.app')

@section('header-nav')
<header class="bg-lavender-600 text-white shadow-sm border-b border-lavender-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center space-x-6">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-white hover:text-lavender-200 transition">
                Ruang Puan <span class="text-xs font-normal text-lavender-200">| Area Konselor</span>
            </a>
            <nav class="hidden md:flex space-x-2 text-sm">
                <a href="{{ route('konselor.dashboard') }}" class="px-3 py-1.5 rounded-lg font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('konselor.dashboard') ? 'bg-lavender-400 text-white shadow-sm' : 'hover:bg-lavender-400/60 text-cream-100' }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="px-3 py-1.5 rounded-lg font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('profile.edit') ? 'bg-lavender-400 text-white shadow-sm' : 'hover:bg-lavender-400/60 text-cream-100' }}">Dokumen & Profil</a>
            </nav>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('profile.edit') }}" class="text-xs text-lavender-100 hover:text-white transition flex items-center space-x-1.5">
                <span>👩‍⚕️</span>
                <span class="hidden sm:inline font-medium">{{ auth()->user()->nama ?? 'Konselor' }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-berry-900 hover:bg-berry-700 text-white transition-all duration-200 active:scale-[0.98] font-medium shadow-sm">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>
@endsection

@section('content')
    @yield('konselor-content')
@endsection
