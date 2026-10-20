<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Ruang Puan — Ruang Aman, Edukasi & Konsultasi Pemberdayaan Perempuan' }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-cream-50 text-ink-900 font-sans antialiased min-h-screen flex flex-col selection:bg-berry-100 selection:text-berry-900" x-data="{ mobileMenuOpen: false }">
        
        <!-- Toast Notifications -->
        @if(session('success'))
            <x-toast type="success" :message="session('success')" />
        @endif
        @if(session('error'))
            <x-toast type="error" :message="session('error')" />
        @endif

        <!-- Master Header / Navbar slot -->
        @hasSection('header-nav')
            @yield('header-nav')
        @else
            <header class="sticky top-0 z-50 bg-berry-900/95 backdrop-blur-md text-white shadow-md border-b border-berry-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}" class="flex items-center space-x-2 group">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-berry-700 to-rose-600 flex items-center justify-center shadow-md group-hover:scale-105 transition">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.115 6.845l.209-.13a12.01 12.01 0 002.5-2.5m-11.45-6.65a4 4 0 11-7.5 3.5m7.5-3.5a4 4 0 10-7.5 3.5" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-2xl font-extrabold tracking-tight text-white group-hover:text-rose-200 transition">Ruang Puan</span>
                                <span class="block text-[10px] uppercase tracking-widest text-rose-300 font-semibold">SDGs 5 • Kesetaraan Gender</span>
                            </div>
                        </a>
                    </div>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center space-x-1">
                        <a href="{{ url('/') }}#fitur" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-berry-700/80 text-cream-100 transition">Layanan</a>
                        <a href="{{ route('edukasi.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-berry-700/80 text-cream-100 transition">Edukasi</a>
                        <a href="{{ route('direktori.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-berry-700/80 text-cream-100 transition">Direktori Layanan</a>
                    </nav>

                    <!-- Auth Buttons / Profile -->
                    <div class="hidden md:flex items-center space-x-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-berry-700 hover:from-berry-700 hover:to-berry-900 text-white font-medium text-sm shadow-md transition transform hover:-translate-y-0.5">
                                Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-cream-100 hover:bg-berry-700 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-medium text-sm shadow-md transition transform hover:-translate-y-0.5">
                                Daftar Akun
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-cream-100 hover:bg-berry-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu Dropdown -->
                <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-berry-900 border-b border-berry-700 px-4 pt-2 pb-6 space-y-2">
                    <a href="{{ url('/') }}#fitur" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-base font-medium hover:bg-berry-700 text-cream-100">Layanan</a>
                    <a href="{{ route('edukasi.index') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-base font-medium hover:bg-berry-700 text-cream-100">Edukasi</a>
                    <a href="{{ route('direktori.index') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-base font-medium hover:bg-berry-700 text-cream-100">Direktori Layanan</a>
                    <div class="pt-4 border-t border-berry-700 flex flex-col space-y-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-2.5 rounded-xl bg-rose-600 text-white font-medium text-sm">Dashboard Saya</a>
                        @else
                            <a href="{{ route('login') }}" class="w-full text-center px-4 py-2.5 rounded-xl bg-berry-700 text-white font-medium text-sm">Masuk</a>
                            <a href="{{ route('register') }}" class="w-full text-center px-4 py-2.5 rounded-xl bg-rose-600 text-white font-medium text-sm">Daftar Akun</a>
                        @endauth
                    </div>
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <!-- Professional Footer -->
        <footer class="bg-berry-900 text-cream-100 py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="space-y-3">
                    <h5 class="text-lg font-bold text-white">Ruang Puan</h5>
                    <p class="text-xs text-cream-100/70 leading-relaxed">
                        Platform web pelaporan, edukasi, dan konsultasi untuk mendukung kesetaraan gender dan perlindungan hak perempuan (SDGs 5).
                    </p>
                </div>
                <div>
                    <h6 class="text-sm font-semibold text-rose-200 mb-3">Layanan Utama</h6>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('pelaporan.buat') }}" class="hover:underline">Buat Laporan Kasus</a></li>
                        <li><a href="{{ route('edukasi.index') }}" class="hover:underline">Pusat Edukasi & Artikel</a></li>
                        <li><a href="{{ route('direktori.index') }}" class="hover:underline">Direktori Lembaga Bantuan</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-sm font-semibold text-rose-200 mb-3">Kontak Darurat</h6>
                    <ul class="space-y-2 text-xs">
                        <li>Hotline SAPA: <span class="font-bold text-white">129</span></li>
                        <li>WhatsApp SAPA: <span class="font-bold text-white">0821-1111-1129</span></li>
                        <li>UPTD PPA DKI: <span class="font-bold text-white">0813-8000-8000</span></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-sm font-semibold text-rose-200 mb-3">Akademik & Tim</h6>
                    <p class="text-xs text-cream-100/70">Proyek Scrum MVP — Didedikasikan untuk Pelindungan & Pemberdayaan Perempuan.</p>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-berry-700 text-center text-xs text-cream-100/60">
                &copy; {{ date('Y') }} Ruang Puan. Seluruh hak cipta dilindungi undang-undang.
            </div>
        </footer>
    </body>
</html>
