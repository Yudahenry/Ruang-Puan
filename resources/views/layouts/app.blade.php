<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Ruang Puan — Ruang Aman, Edukasi & Konsultasi Pemberdayaan Perempuan' }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|fraunces:400,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FCFAF8] text-[#3E293F] font-sans antialiased min-h-screen flex flex-col selection:bg-[#EEE7F2] selection:text-[#3E293F]" x-data="{ mobileMenuOpen: false }">

        <!-- Master Header / Navbar slot -->
        @hasSection('header-nav')
            @yield('header-nav')
        @else
            <header class="sticky top-0 z-50 bg-[#3E293F]/95 backdrop-blur-md text-white shadow-sm border-b border-[#DCD5DD]/20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                            <div class="w-10 h-10 rounded-2xl bg-[#643B62] flex items-center justify-center shadow-inner group-hover:scale-105 transition">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.115 6.845l.209-.13a12.01 12.01 0 002.5-2.5m-11.45-6.65a4 4 0 11-7.5 3.5m7.5-3.5a4 4 0 10-7.5 3.5" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xl font-serif font-bold tracking-tight text-white group-hover:text-[#EEE7F2] transition">Ruang Puan</span>
                                <span class="block text-[10px] uppercase tracking-widest text-[#EEE7F2]/70 font-semibold">SDGs 5 • Kesetaraan Gender</span>
                            </div>
                        </a>
                    </div>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center space-x-1 bg-white/5 p-1 rounded-full border border-white/10">
                        <a href="{{ url('/') }}#fitur" class="px-5 py-2 rounded-full text-xs font-semibold hover:bg-white/10 text-[#EEE7F2] transition">Layanan</a>
                        <a href="{{ route('edukasi.index') }}" class="px-5 py-2 rounded-full text-xs font-semibold hover:bg-white/10 text-[#EEE7F2] transition">Edukasi</a>
                        <a href="{{ route('direktori.index') }}" class="px-5 py-2 rounded-full text-xs font-semibold hover:bg-white/10 text-[#EEE7F2] transition">Direktori Layanan</a>
                    </nav>

                    <!-- Auth Buttons / Profile -->
                    <div class="hidden md:flex items-center space-x-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-2xl bg-[#643B62] hover:bg-[#3E293F] text-white font-semibold text-xs shadow-sm transition transform hover:-translate-y-0.5 border border-white/10">
                                Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-2xl text-xs font-semibold text-[#EEE7F2] hover:bg-white/10 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-2xl bg-[#643B62] hover:bg-[#3E293F] text-white font-semibold text-xs shadow-sm transition transform hover:-translate-y-0.5">
                                Daftar Akun
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2.5 rounded-xl text-[#EEE7F2] hover:bg-white/10 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu Dropdown -->
                <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-[#3E293F] border-b border-white/10 px-6 py-4 space-y-2">
                    <a href="{{ url('/') }}#fitur" @click="mobileMenuOpen = false" class="block px-4 py-2.5 rounded-xl text-xs font-semibold hover:bg-white/10 text-[#EEE7F2]">Layanan</a>
                    <a href="{{ route('edukasi.index') }}" @click="mobileMenuOpen = false" class="block px-4 py-2.5 rounded-xl text-xs font-semibold hover:bg-white/10 text-[#EEE7F2]">Edukasi</a>
                    <a href="{{ route('direktori.index') }}" @click="mobileMenuOpen = false" class="block px-4 py-2.5 rounded-xl text-xs font-semibold hover:bg-white/10 text-[#EEE7F2]">Direktori Layanan</a>
                    <div class="pt-4 border-t border-white/10 flex flex-col space-y-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-3 rounded-2xl bg-[#643B62] text-white font-semibold text-xs">Dashboard Saya</a>
                        @else
                            <a href="{{ route('login') }}" class="w-full text-center px-4 py-3 rounded-2xl bg-white/10 text-white font-semibold text-xs">Masuk</a>
                            <a href="{{ route('register') }}" class="w-full text-center px-4 py-3 rounded-2xl bg-[#643B62] text-white font-semibold text-xs">Daftar Akun</a>
                        @endauth
                    </div>
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="flex-1 @hasSection('header-nav') @else max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 @endif">
            @yield('content')
        </main>

        <!-- Professional Footer -->
        @hasSection('header-nav')
        @else
        <footer class="bg-[#3E293F] text-[#EEE7F2] py-12 mt-auto border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="space-y-3">
                    <h5 class="text-lg font-serif font-bold text-white">Ruang Puan</h5>
                    <p class="text-xs text-[#EEE7F2]/70 leading-relaxed">
                        Platform web pelaporan, edukasi, dan konsultasi untuk mendukung kesetaraan gender dan perlindungan hak perempuan (SDGs 5).
                    </p>
                </div>
                <div>
                    <h6 class="text-xs font-bold uppercase tracking-wider text-[#EEE7F2] mb-3">Layanan Utama</h6>
                    <ul class="space-y-2 text-xs text-[#EEE7F2]/80">
                        <li><a href="{{ route('pelaporan.buat') }}" class="hover:text-white transition">Buat Laporan Kasus</a></li>
                        <li><a href="{{ route('edukasi.index') }}" class="hover:text-white transition">Pusat Edukasi & Artikel</a></li>
                        <li><a href="{{ route('direktori.index') }}" class="hover:text-white transition">Direktori Lembaga Bantuan</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-xs font-bold uppercase tracking-wider text-[#EEE7F2] mb-3">Kontak Darurat</h6>
                    <ul class="space-y-2 text-xs text-[#EEE7F2]/80">
                        <li>Hotline SAPA: <span class="font-bold text-white">129</span></li>
                        <li>WhatsApp SAPA: <span class="font-bold text-white">0821-1111-1129</span></li>
                        <li>UPTD PPA DKI: <span class="font-bold text-white">0813-8000-8000</span></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-xs font-bold uppercase tracking-wider text-[#EEE7F2] mb-3">Akademik & Tim</h6>
                    <p class="text-xs text-[#EEE7F2]/70 leading-relaxed">Proyek Scrum MVP — Didedikasikan untuk Pelindungan & Pemberdayaan Perempuan.</p>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-white/10 text-center text-xs text-[#EEE7F2]/60">
                &copy; {{ date('Y') }} Ruang Puan. Seluruh hak cipta dilindungi undang-undang.
            </div>
        </footer>
        @endif
    </body>
</html>