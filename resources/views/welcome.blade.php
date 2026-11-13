<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Ruang Puan — Ruang Aman untuk Didengar, Dukungan untuk Setiap Perempuan</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|fraunces:400,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FCFAF8] text-[#3E293F] font-sans antialiased min-h-screen flex flex-col selection:bg-[#EEE7F2] selection:text-[#3E293F]"
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
        <header :class="scrolled ? 'bg-[#3E293F]/95 backdrop-blur-md shadow-md py-4 border-b border-[#DCD5DD]/20' : 'bg-transparent py-6'"
                class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-inner group-hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.115 6.845l.209-.13a12.01 12.01 0 002.5-2.5m-11.45-6.65a4 4 0 11-7.5 3.5m7.5-3.5a4 4 0 10-7.5 3.5" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-2xl font-serif font-bold tracking-tight text-white group-hover:text-[#EEE7F2] transition-colors duration-200">Ruang Puan</span>
                        <span class="block text-[10px] uppercase tracking-widest text-[#EEE7F2]/80 font-semibold">SDGs 5 • Kesetaraan Gender</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1.5 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/15 text-xs font-semibold">
                    <a href="#fitur" class="px-4 py-2 rounded-full text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">Layanan</a>
                    <a href="{{ route('edukasi.index') }}" class="px-4 py-2 rounded-full text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">Edukasi</a>
                    <a href="{{ route('direktori.index') }}" class="px-4 py-2 rounded-full text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">Direktori Bantuan</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-2xl bg-white text-[#643B62] hover:bg-[#EEE7F2] font-semibold text-xs shadow-sm transition-all duration-200 active:scale-[0.98]">
                            Dashboard Saya &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-3 rounded-2xl text-xs font-semibold text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 rounded-2xl bg-white text-[#643B62] hover:bg-[#EEE7F2] font-semibold text-xs shadow-sm transition-all duration-200 active:scale-[0.98]">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2.5 rounded-2xl text-white bg-white/10 hover:bg-white/20 transition" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2 scale-98"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                 class="md:hidden bg-[#3E293F] border-b border-white/10 px-6 pt-4 pb-6 space-y-3 shadow-xl">
                <a href="#fitur" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-2xl text-xs font-semibold text-white hover:bg-white/10">Layanan</a>
                <a href="{{ route('edukasi.index') }}" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-2xl text-xs font-semibold text-white hover:bg-white/10">Edukasi</a>
                <a href="{{ route('direktori.index') }}" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-2xl text-xs font-semibold text-white hover:bg-white/10">Direktori Bantuan</a>
                <div class="pt-4 border-t border-white/10 flex flex-col space-y-2.5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-3 rounded-2xl bg-white text-[#643B62] font-semibold text-xs shadow-sm">Dashboard Saya</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-3 rounded-2xl bg-white/10 text-white font-semibold text-xs">Masuk</a>
                        <a href="{{ route('register') }}" class="w-full text-center px-4 py-3 rounded-2xl bg-white text-[#643B62] font-semibold text-xs shadow-sm">Daftar Akun</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Hero Section -->
            <section class="relative overflow-hidden bg-[#3E293F] text-white pt-40 pb-28 lg:pt-48 lg:pb-36 rounded-b-[3rem] shadow-md">
                <!-- Decorative Glow Backgrounds -->
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#643B62]/40 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-1/2 -right-24 w-96 h-96 bg-[#643B62]/30 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#EEE7F2_1px,transparent_1px)] [background-size:24px_24px]"></div>
                
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center"
                     x-data="{ show: false }" 
                     x-init="setTimeout(() => show = true, 50)"
                     :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     class="transition-all duration-500 ease-out">
                    
                    <div class="inline-flex items-center space-x-2.5 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[#EEE7F2] text-xs font-semibold uppercase tracking-widest mb-8 shadow-inner">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Ruang Aman & Bebas Stigma • Berbasis SDGs 5</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-serif font-bold tracking-tight mb-6 mx-auto leading-[1.15] text-white">
                        Ruang Aman untuk Didengar, <span class="text-[#EEE7F2]/90 block mt-2 font-normal italic">Dukungan untuk Setiap Perempuan</span>
                    </h1>

                    <p class="text-sm sm:text-base lg:text-lg text-[#EEE7F2]/85 mb-12 max-w-2xl mx-auto leading-relaxed font-normal">
                        Platform terintegrasi yang menghadirkan layanan pelaporan kekerasan (bernama/anonim), edukasi hak perempuan, serta konsultasi privat bersama psikolog berlisensi.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" 
                           class="w-full sm:w-auto px-8 py-4 bg-white text-[#3E293F] hover:bg-[#EEE7F2] hover:shadow-lg font-semibold rounded-2xl transition-all duration-200 active:scale-[0.98] shadow-md text-xs sm:text-sm">
                            Mulai Konsultasi & Pelaporan &rarr;
                        </a>
                        <a href="#fitur" 
                           class="w-full sm:w-auto px-8 py-4 border border-white/25 hover:bg-white/10 text-white font-semibold rounded-2xl transition-all duration-200 active:scale-[0.98] text-xs sm:text-sm backdrop-blur-xs">
                            Kenali Layanan Kami
                        </a>
                    </div>
                </div>
            </section>

            <!-- Section Kepercayaan & Statistik Ringkas -->
            <section class="relative -mt-12 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 z-20 mb-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6"
                     x-data="{ show: false }" 
                     x-init="setTimeout(() => show = true, 100)"
                     :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     class="transition-all duration-500 ease-out">
                    
                    <!-- Kartu Fitur 1 -->
                    <div class="bg-white rounded-3xl p-7 shadow-sm border border-[#DCD5DD] flex items-start space-x-4 transition-all duration-200 hover:shadow-md">
                        <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center flex-shrink-0 text-xl font-bold shadow-inner">
                            🔒
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-[#3E293F] text-base mb-1">Data Terenkripsi</h4>
                            <p class="text-xs text-[#746B77] leading-relaxed">Kerahasiaan informasi dan dokumen bukti laporan tersimpan sangat aman.</p>
                        </div>
                    </div>

                    <!-- Kartu Fitur 2 -->
                    <div class="bg-white rounded-3xl p-7 shadow-sm border border-[#DCD5DD] flex items-start space-x-4 transition-all duration-200 hover:shadow-md">
                        <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center flex-shrink-0 text-xl font-bold shadow-inner">
                            👩‍⚕️
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-[#3E293F] text-base mb-1">Konselor Terverifikasi</h4>
                            <p class="text-xs text-[#746B77] leading-relaxed">Psikolog dan konselor memiliki legalitas STR & SIPP profesional.</p>
                        </div>
                    </div>

                    <!-- Kartu Fitur 3 -->
                    <div class="bg-white rounded-3xl p-7 shadow-sm border border-[#DCD5DD] flex items-start space-x-4 transition-all duration-200 hover:shadow-md">
                        <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center flex-shrink-0 text-xl font-bold shadow-inner">
                            🛡️
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-[#3E293F] text-base mb-1">Pelaporan Anonim</h4>
                            <p class="text-xs text-[#746B77] leading-relaxed">Pilihan perlindungan identitas total bagi pelapor dan penyintas.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3 Pilar Utama Fitur -->
            <section id="fitur" class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16"
                     x-data="{ show: false }" 
                     x-init="setTimeout(() => show = true, 150)"
                     :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     class="transition-all duration-500 ease-out">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-[11px] uppercase tracking-widest font-bold text-[#643B62] bg-[#EEE7F2] px-3.5 py-1.5 rounded-full inline-block mb-3">Layanan Terintegrasi</span>
                    <h2 class="text-3xl sm:text-4xl font-serif font-bold text-[#3E293F] tracking-tight">Tiga Pilar Utama Ruang Puan</h2>
                    <p class="text-[#746B77] mt-3 text-xs sm:text-sm leading-relaxed">
                        Pendekatan holistik untuk penanganan kasus, edukasi pencegahan kekerasan, serta pemulihan psikologis yang aman.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Kartu 1: Pelaporan -->
                    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-[#DCD5DD] hover:-translate-y-1.5 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="w-16 h-16 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mb-6 group-hover:bg-[#643B62] group-hover:text-white transition-colors duration-200 text-2xl font-bold shadow-inner">
                                📋
                            </div>
                            <h3 class="text-xl font-serif font-bold text-[#3E293F] mb-3 tracking-tight">Pelaporan Aman & Tanggap</h3>
                            <p class="text-xs sm:text-sm text-[#746B77] leading-relaxed mb-8">
                                Laporkan kasus kekerasan secara bernama maupun anonim. Dilengkapi kode pelacakan transparan dan unggah bukti pendukung terenkripsi.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-[#DCD5DD]/50">
                            <a href="{{ route('pelaporan.buat') }}" 
                               class="inline-flex items-center space-x-2 text-xs font-bold text-[#643B62] hover:text-[#3E293F] group-hover:translate-x-1 transition-all duration-200">
                                <span>Buat Laporan Sekarang</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Kartu 2: Edukasi -->
                    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-[#DCD5DD] hover:-translate-y-1.5 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="w-16 h-16 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mb-6 group-hover:bg-[#643B62] group-hover:text-white transition-colors duration-200 text-2xl font-bold shadow-inner">
                                📚
                            </div>
                            <h3 class="text-xl font-serif font-bold text-[#3E293F] mb-3 tracking-tight">Pusat Edukasi & Pengetahuan</h3>
                            <p class="text-xs sm:text-sm text-[#746B77] leading-relaxed mb-8">
                                Akses materi terpercaya seputar hak hukum perempuan, kesehatan reproduksi, serta strategi mitigasi risiko kekerasan secara mandiri.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-[#DCD5DD]/50">
                            <a href="{{ route('edukasi.index') }}" 
                               class="inline-flex items-center space-x-2 text-xs font-bold text-[#643B62] hover:text-[#3E293F] group-hover:translate-x-1 transition-all duration-200">
                                <span>Jelajahi Artikel Edukasi</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Kartu 3: Konsultasi -->
                    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-[#DCD5DD] hover:-translate-y-1.5 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="w-16 h-16 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mb-6 group-hover:bg-[#643B62] group-hover:text-white transition-colors duration-200 text-2xl font-bold shadow-inner">
                                💬
                            </div>
                            <h3 class="text-xl font-serif font-bold text-[#3E293F] mb-3 tracking-tight">Konsultasi Privat Profesional</h3>
                            <p class="text-xs sm:text-sm text-[#746B77] leading-relaxed mb-8">
                                Temukan psikolog dan konselor tersertifikasi untuk pendampingan mental berkala melalui sesi chat terjadwal yang aman dan nyaman.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-[#DCD5DD]/50">
                            <a href="{{ route('konsultasi.index') }}" 
                               class="inline-flex items-center space-x-2 text-xs font-bold text-[#643B62] hover:text-[#3E293F] group-hover:translate-x-1 transition-all duration-200">
                                <span>Jadwalkan Konsultasi</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-[#3E293F] text-[#EEE7F2] py-16 mt-auto border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                    <!-- Kolom 1 -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-2xl bg-[#643B62] flex items-center justify-center text-white font-bold text-xs shadow-inner">
                                RP
                            </div>
                            <span class="text-lg font-serif font-bold text-white">Ruang Puan</span>
                        </div>
                        <p class="text-xs text-[#EEE7F2]/70 leading-relaxed">
                            Mendukung Tujuan Pembangunan Berkelanjutan (SDGs 5) untuk kesetaraan gender, keadilan, dan perlindungan perempuan.
                        </p>
                    </div>

                    <!-- Kolom 2 -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Direktori Layanan Bantuan</h4>
                        <ul class="space-y-2.5 text-xs text-[#EEE7F2]/80">
                            <li><a href="{{ route('direktori.index', ['jenis' => 'hotline']) }}" class="hover:text-white hover:underline transition">Hotline Nasional SAPA 129</a></li>
                            <li><a href="{{ route('direktori.index', ['jenis' => 'uptd_ppa']) }}" class="hover:text-white hover:underline transition">UPTD PPA Wilayah</a></li>
                            <li><a href="{{ route('direktori.index', ['jenis' => 'lbh']) }}" class="hover:text-white hover:underline transition">Lembaga Bantuan Hukum (LBH)</a></li>
                            <li><a href="{{ route('direktori.index', ['jenis' => 'rumah_aman']) }}" class="hover:text-white hover:underline transition">Rumah Aman Penyintas</a></li>
                        </ul>
                    </div>

                    <!-- Kolom 3 -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Kontak Darurat 24 Jam</h4>
                        <ul class="space-y-2.5 text-xs text-[#EEE7F2]/80">
                            <li>Telepon Hotline: <span class="font-bold text-white">129</span></li>
                            <li>WhatsApp Hotline: <span class="font-bold text-white">0821-1111-1129</span></li>
                            <li>LBH APIK: <span class="font-bold text-white">021-87793395</span></li>
                        </ul>
                    </div>

                    <!-- Kolom 4 -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Akses Cepat</h4>
                        <ul class="space-y-2.5 text-xs text-[#EEE7F2]/80">
                            <li><a href="{{ route('pelaporan.buat') }}" class="hover:text-white hover:underline transition">Form Laporan Kasus</a></li>
                            <li><a href="{{ route('edukasi.index') }}" class="hover:text-white hover:underline transition">Artikel Edukasi</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white hover:underline transition">Masuk Akun</a></li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-white/10 text-center text-xs text-[#EEE7F2]/50">
                    &copy; {{ date('Y') }} Ruang Puan. Hak Cipta Dilindungi. Proyek Digital Responsif Penyintas.
                </div>
            </div>
        </footer>
    </body>
</html>