@extends('layouts.app')

@section('header-nav')
<header class="sticky top-0 z-40 bg-berry-900 text-white shadow-md border-b border-berry-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ url('/') }}" class="flex items-center space-x-2 group">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-berry-700 to-rose-600 flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.115 6.845l.209-.13a12.01 12.01 0 002.5-2.5m-11.45-6.65a4 4 0 11-7.5 3.5m7.5-3.5a4 4 0 10-7.5 3.5" />
                    </svg>
                </div>
                <span class="text-lg font-extrabold tracking-tight text-white group-hover:text-rose-200 transition">Ruang Puan</span>
                <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-rose-600 text-white">Admin</span>
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('profile.edit') }}" class="text-xs text-rose-200 hover:text-white transition flex items-center space-x-1.5">
                <span>👤</span>
                <span class="hidden sm:inline font-medium">{{ auth()->user()->nama ?? 'Administrator' }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-berry-700 hover:bg-rose-600 text-white font-medium transition-all duration-200 active:scale-[0.98]">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="flex flex-col md:flex-row gap-6 -mt-2">
    <!-- Admin Sidebar -->
    <aside class="w-full md:w-64 flex-shrink-0" x-data="{ openMenu: false }">
        <!-- Mobile Toggle Button -->
        <div class="md:hidden mb-4">
            <button @click="openMenu = !openMenu" type="button" 
                    class="w-full py-2.5 px-4 bg-berry-900 text-white rounded-xl flex items-center justify-between text-sm font-semibold shadow-sm">
                <span class="flex items-center space-x-2">
                    <span>☰</span>
                    <span>Menu Navigasi Admin</span>
                </span>
                <span x-text="openMenu ? '▲' : '▼'"></span>
            </button>
        </div>

        <!-- Sidebar Content -->
        <div :class="{ 'block': openMenu, 'hidden md:block': !openMenu }"
             class="bg-berry-900 rounded-xl p-4 shadow-sm border border-berry-800 text-cream-100 space-y-1.5 md:sticky md:top-24">
            
            <div class="px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-rose-300/80">
                Menu Utama
            </div>

            <!-- 1. Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.dashboard') ? 'bg-berry-700 text-white shadow-sm' : 'text-cream-100/80 hover:bg-berry-800 hover:text-white' }}">
                <span class="text-base">📊</span>
                <span>Dashboard</span>
            </a>

            <!-- 2. Kelola Laporan -->
            <a href="{{ route('admin.laporan.index') }}" 
               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.laporan.*') ? 'bg-berry-700 text-white shadow-sm' : 'text-cream-100/80 hover:bg-berry-800 hover:text-white' }}">
                <span class="text-base">📁</span>
                <span>Kelola Laporan</span>
            </a>

            <!-- 3. Kelola Edukasi -->
            <a href="{{ route('admin.edukasi.index') }}" 
               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.edukasi.*') ? 'bg-berry-700 text-white shadow-sm' : 'text-cream-100/80 hover:bg-berry-800 hover:text-white' }}">
                <span class="text-base">📚</span>
                <span>Kelola Edukasi</span>
            </a>

            <!-- 4. Direktori Layanan -->
            <a href="{{ route('admin.direktori.index') }}" 
               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.direktori.*') ? 'bg-berry-700 text-white shadow-sm' : 'text-cream-100/80 hover:bg-berry-800 hover:text-white' }}">
                <span class="text-base">🏛️</span>
                <span>Direktori Layanan</span>
            </a>

            <div class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-wider text-rose-300/80">
                Persetujuan & Akun
            </div>

            <!-- 5. Verifikasi Konselor -->
            <a href="{{ route('admin.konselor.index') }}" 
               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.konselor.*') ? 'bg-berry-700 text-white shadow-sm' : 'text-cream-100/80 hover:bg-berry-800 hover:text-white' }}">
                <span class="text-base">👩‍⚕️</span>
                <span>Verifikasi Konselor</span>
            </a>

            <!-- 6. Profil Saya -->
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('profile.edit') ? 'bg-berry-700 text-white shadow-sm' : 'text-cream-100/80 hover:bg-berry-800 hover:text-white' }}">
                <span class="text-base">⚙️</span>
                <span>Pengaturan Profil</span>
            </a>
        </div>
    </aside>

    <!-- Admin Content Body -->
    <main class="flex-1 min-w-0">
        @yield('admin-content')
    </main>
</div>
@endsection
