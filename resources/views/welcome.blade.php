<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Ruang Puan — Ruang Aman untuk Didengar, Dukungan untuk Setiap Perempuan</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-cream-50 text-ink-900 font-sans antialiased min-h-screen flex flex-col selection:bg-berry-100 selection:text-berry-900"
          x-data="{ scrolled: false, mobileMenuOpen: false }"
          @scroll.window="scrolled = (window.pageYOffset > 30)">
        
        <!-- Toast Flash Notifications -->
        @if(session('success'))
            <x-toast type="success" :message="session('success')" />
        @endif
        @if(session('error'))
            <x-toast type="error" :message="session('error')" />
        @endif

        <!-- Floating Dynamic Navbar -->
        <header :class="scrolled ? 'bg-berry-900/95 backdrop-blur-md shadow-md py-3.5 border-b border-berry-700' : 'bg-transparent py-5 border-b border-white/10'"
                class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-lg bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-sm group-hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.115 6.845l.209-.13a12.01 12.01 0 002.5-2.5m-11.45-6.65a4 4 0 11-7.5 3.5m7.5-3.5a4 4 0 10-7.5 3.5" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold tracking-tight text-white group-hover:text-rose-200 transition-colors duration-200">Ruang Puan</span>
                        <span class="block text-[9px] uppercase tracking-widest text-rose-200 font-bold">SDGs 5 • Kesetaraan Gender</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1 text-sm font-medium">
                    <a href="#fitur" class="px-3.5 py-2 rounded-lg text-cream-100/90 hover:text-white hover:bg-white/10 transition-all duration-200">Layanan</a>
                    <a href="{{ route('edukasi.index') }}" class="px-3.5 py-2 rounded-lg text-cream-100/90 hover:text-white hover:bg-white/10 transition-all duration-200">Edukasi</a>
                    <a href="{{ route('direktori.index') }}" class="px-3.5 py-2 rounded-lg text-cream-100/90 hover:text-white hover:bg-white/10 transition-all duration-200">Direktori Bantuan</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-lg bg-white text-berry-700 hover:bg-cream-100 font-bold text-sm shadow-sm transition-all duration-200 active:scale-[0.98]">
                            Dashboard Saya &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-cream-100 hover:text-white hover:bg-white/10 transition-all duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-lg bg-white text-berry-700 hover:bg-cream-100 font-bold text-sm shadow-sm transition-all duration-200 active:scale-[0.98]">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-cream-100 hover:bg-white/10 transition" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer with Alpine Fade & Scale -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2 scale-98"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                 class="md:hidden bg-berry-900 border-b border-berry-700 px-4 pt-3 pb-6 space-y-2">
                <a href="#fitur" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-sm font-medium text-cream-100 hover:bg-berry-800">Layanan</a>
                <a href="{{ route('edukasi.index') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-sm font-medium text-cream-100 hover:bg-berry-800">Edukasi</a>
                <a href="{{ route('direktori.index') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-sm font-medium text-cream-100 hover:bg-berry-800">Direktori Bantuan</a>
                <div class="pt-3 border-t border-berry-700/80 flex flex-col space-y-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-2.5 rounded-lg bg-white text-berry-700 font-bold text-sm shadow-sm">Dashboard Saya</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 rounded-lg bg-berry-800 text-white font-medium text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="w-full text-center px-4 py-2.5 rounded-lg bg-white text-berry-700 font-bold text-sm shadow-sm">Daftar Akun</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- 1. Hero Section full-width, gradient berry→rose -->
            <section class="relative overflow-hidden bg-gradient-to-r from-berry-700 via-berry-600 to-rose-600 text-white pt-36 pb-24 lg:pt-44 lg:pb-32">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#F3D4E0_1px,transparent_1px)] [background-size:20px_20px]"></div>
                
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center"
                     x-data="{ show: false }" 
                     x-init="setTimeout(() => show = true, 50)"
                     :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     class="transition-all duration-300 ease-out">
                    
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-rose-200 text-xs font-semibold uppercase tracking-wider mb-6 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-300 animate-pulse"></span>
                        <span>Ruang Aman & Bebas Stigma</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-6 max-w-4xl mx-auto leading-tight text-white">
                        Ruang Aman untuk Didengar, <span class="text-rose-200">Dukungan untuk Setiap Perempuan</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-cream-100/90 mb-10 max-w-2xl mx-auto leading-relaxed font-normal">
                        Platform terintegrasi yang menghadirkan layanan pelaporan kekerasan (bernama/anonim), edukasi hak perempuan, serta konsultasi privat bersama psikolog berlisensi.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <!-- Solid Putih CTA -->
                        <a href="{{ route('register') }}" 
                           class="w-full sm:w-auto px-8 py-3.5 bg-white text-berry-700 hover:bg-cream-100 hover:shadow-xl font-bold rounded-lg transition-all duration-200 active:scale-[0.98] shadow-md text-center">
                            Mulai Sekarang &rarr;
                        </a>
                        <!-- Outline CTA -->
                        <a href="#fitur" 
                           class="w-full sm:w-auto px-8 py-3.5 border-2 border-white/80 hover:bg-white/10 text-white font-semibold rounded-lg transition-all duration-200 active:scale-[0.98] text-center">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
            </section>

            <!-- 2. Section Kepercayaan (3 Badge Singkat dengan Ikon) -->
            <section class="bg-cream-100 py-12 border-y border-cream-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6"
                         x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 100)"
                         :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                         class="transition-all duration-300 ease-out">
                        
                        <!-- Badge 1 -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-cream-200 flex items-center space-x-4 transition-shadow duration-200 hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-berry-100 text-berry-700 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-berry-900 text-base">Data Terenkripsi</h4>
                                <p class="text-xs text-ink-600 mt-0.5 leading-relaxed">Kerahasiaan informasi dan dokumen bukti laporan tersimpan aman.</p>
                            </div>
                        </div>

                        <!-- Badge 2 -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-cream-200 flex items-center space-x-4 transition-shadow duration-200 hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-lavender-200 text-lavender-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-berry-900 text-base">Konselor Terverifikasi</h4>
                                <p class="text-xs text-ink-600 mt-0.5 leading-relaxed">Psikolog dan konselor memiliki legalitas STR & SIPP resmi.</p>
                            </div>
                        </div>

                        <!-- Badge 3 -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-cream-200 flex items-center space-x-4 transition-shadow duration-200 hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-rose-200 text-rose-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-berry-900 text-base">Pelaporan Anonim</h4>
                                <p class="text-xs text-ink-600 mt-0.5 leading-relaxed">Pilihan perlindungan identitas pelapor dari siapapun (NFR-05).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Section 3 Kartu Fitur (Pelaporan, Edukasi, Konsultasi) dengan Hover Lift -->
            <section id="fitur" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
                     x-data="{ show: false }" 
                     x-init="setTimeout(() => show = true, 150)"
                     :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     class="transition-all duration-300 ease-out">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs uppercase tracking-widest font-bold text-rose-600 mb-2 block">Layanan Terintegrasi</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-berry-900 tracking-tight">Tiga Pilar Utama Ruang Puan</h2>
                    <p class="text-ink-600 mt-3 text-base leading-relaxed">
                        Pendekatan holistik untuk penanganan kasus, pencegahan kekerasan, serta pemulihan psikologis penyintas.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Kartu 1: Pelaporan -->
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-cream-200 hover:-translate-y-1.5 hover:shadow-xl transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="w-14 h-14 rounded-lg bg-berry-100 text-berry-700 flex items-center justify-center mb-6 group-hover:bg-berry-700 group-hover:text-white transition-colors duration-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-berry-900 mb-3 tracking-tight">Pelaporan Aman & Tanggap</h3>
                            <p class="text-sm text-ink-600 leading-relaxed mb-6">
                                Laporkan kasus kekerasan secara bernama maupun anonim. Dilengkapi kode pelacakan transparan dan unggah bukti pendukung terenkripsi.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-cream-200">
                            <a href="{{ route('pelaporan.buat') }}" 
                               class="inline-flex items-center space-x-2 text-sm font-semibold text-berry-700 hover:text-rose-600 group-hover:translate-x-1 transition-all duration-200">
                                <span>Buat Laporan Sekarang</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Kartu 2: Edukasi -->
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-cream-200 hover:-translate-y-1.5 hover:shadow-xl transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="w-14 h-14 rounded-lg bg-rose-200 text-rose-600 flex items-center justify-center mb-6 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-berry-900 mb-3 tracking-tight">Pusat Edukasi & Pengetahuan</h3>
                            <p class="text-sm text-ink-600 leading-relaxed mb-6">
                                Akses materi terpercaya seputar hak hukum perempuan, kesehatan reproduksi, serta strategi mitigasi risiko kekerasan.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-cream-200">
                            <a href="{{ route('edukasi.index') }}" 
                               class="inline-flex items-center space-x-2 text-sm font-semibold text-berry-700 hover:text-rose-600 group-hover:translate-x-1 transition-all duration-200">
                                <span>Jelajahi Artikel Edukasi</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Kartu 3: Konsultasi -->
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-cream-200 hover:-translate-y-1.5 hover:shadow-xl transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="w-14 h-14 rounded-lg bg-lavender-200 text-lavender-600 flex items-center justify-center mb-6 group-hover:bg-lavender-600 group-hover:text-white transition-colors duration-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-berry-900 mb-3 tracking-tight">Konsultasi Privat Profesional</h3>
                            <p class="text-sm text-ink-600 leading-relaxed mb-6">
                                Temukan psikolog dan konselor tersertifikasi untuk pendampingan mental berkala melalui sesi chat terjadwal yang aman dan nyaman.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-cream-200">
                            <a href="{{ route('register') }}" 
                               class="inline-flex items-center space-x-2 text-sm font-semibold text-berry-700 hover:text-rose-600 group-hover:translate-x-1 transition-all duration-200">
                                <span>Jadwalkan Konsultasi</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- 4. Footer Sederhana dengan Akses Cepat ke Direktori Layanan Bantuan (Tanpa Login) -->
        <footer class="bg-berry-900 text-cream-100 py-12 mt-auto border-t border-berry-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <!-- Kolom 1 -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 rounded-md bg-rose-600 flex items-center justify-center text-white font-bold text-xs">
                                RP
                            </div>
                            <span class="text-lg font-bold text-white">Ruang Puan</span>
                        </div>
                        <p class="text-xs text-cream-100/70 leading-relaxed">
                            Mendukung Tujuan Pembangunan Berkelanjutan (SDGs 5) untuk kesetaraan gender dan perlindungan perempuan.
                        </p>
                    </div>

                    <!-- Kolom 2: Akses Cepat Direktori Layanan Bantuan (Publik / Darurat) -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-rose-300 mb-3">Direktori Layanan Bantuan</h4>
                        <ul class="space-y-2 text-xs">
                            <li>
                                <a href="{{ route('direktori.index', ['jenis' => 'hotline']) }}" class="text-cream-100 hover:text-white hover:underline transition">
                                    Hotline Nasional SAPA 129
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('direktori.index', ['jenis' => 'uptd_ppa']) }}" class="text-cream-100 hover:text-white hover:underline transition">
                                    UPTD PPA Wilayah
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('direktori.index', ['jenis' => 'lbh']) }}" class="text-cream-100 hover:text-white hover:underline transition">
                                    Lembaga Bantuan Hukum (LBH)
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('direktori.index', ['jenis' => 'rumah_aman']) }}" class="text-cream-100 hover:text-white hover:underline transition">
                                    Rumah Aman Penyintas
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Kolom 3: Kontak Darurat -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-rose-300 mb-3">Kontak Darurat 24 Jam</h4>
                        <ul class="space-y-2 text-xs text-cream-100/80">
                            <li>Telepon Hotline: <span class="font-bold text-white">129</span></li>
                            <li>WhatsApp Hotline: <span class="font-bold text-white">0821-1111-1129</span></li>
                            <li>LBH APIK: <span class="font-bold text-white">021-87793395</span></li>
                        </ul>
                    </div>

                    <!-- Kolom 4: Navigasi Cepat -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-rose-300 mb-3">Akses Cepat</h4>
                        <ul class="space-y-2 text-xs">
                            <li><a href="{{ route('pelaporan.buat') }}" class="text-cream-100 hover:text-white hover:underline transition">Form Laporan Kasus</a></li>
                            <li><a href="{{ route('edukasi.index') }}" class="text-cream-100 hover:text-white hover:underline transition">Artikel Edukasi</a></li>
                            <li><a href="{{ route('login') }}" class="text-cream-100 hover:text-white hover:underline transition">Masuk Akun</a></li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-berry-800 text-center text-xs text-cream-100/60">
                    &copy; {{ date('Y') }} Ruang Puan. Hak Cipta Dilindungi. Proyek Digital Responsif Penyintas.
                </div>
            </div>
        </footer>
    </body>
</html>
