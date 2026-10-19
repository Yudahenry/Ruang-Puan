<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ruang Puan — Ruang Aman, Edukasi & Konsultasi Pemberdayaan Perempuan</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-cream-50 text-ink-900 font-sans antialiased min-h-screen flex flex-col selection:bg-berry-100 selection:text-berry-900" x-data="{ mobileMenuOpen: false }">
        <!-- Professional Navbar with Alpine.js Interactivity -->
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
                    <a href="#fitur" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-berry-700/80 text-cream-100 transition">Layanan</a>
                    <a href="#tentang" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-berry-700/80 text-cream-100 transition">Tentang Kami</a>
                    <a href="#statistik" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-berry-700/80 text-cream-100 transition">Dampak SDGs</a>
                </nav>

                <!-- Auth Buttons / Profile -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-berry-700 hover:from-berry-700 hover:to-berry-900 text-white font-medium text-sm shadow-md transition transform hover:-translate-y-0.5">
                            Dashboard Saya &rarr;
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
                <a href="#fitur" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-base font-medium hover:bg-berry-700 text-cream-100">Layanan</a>
                <a href="#tentang" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-base font-medium hover:bg-berry-700 text-cream-100">Tentang Kami</a>
                <a href="#statistik" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg text-base font-medium hover:bg-berry-700 text-cream-100">Dampak SDGs</a>
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

        <!-- Hero Section -->
        <main class="flex-1">
            <section class="relative overflow-hidden bg-gradient-to-b from-berry-900 via-berry-700 to-cream-50 text-white py-24 lg:py-32">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#F3D4E0_1px,transparent_1px)] [background-size:16px_16px]"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-berry-700/80 border border-berry-500 text-rose-200 text-xs font-semibold uppercase tracking-wider mb-6 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                        <span>Platform Aman & Terpercaya Puspita</span>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-6 max-w-4xl mx-auto leading-tight">
                        Ruang Aman & Berdaya untuk <span class="text-rose-300">Setiap Perempuan Indonesia</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-cream-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Layanan terpadu pelaporan kekerasan (bernama atau anonim), edukasi hak perempuan secara komprehensif, dan konsultasi psikologis privat bersama para ahli.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-rose-600 hover:bg-rose-500 text-white font-semibold rounded-2xl shadow-lg transition transform hover:-translate-y-1">
                            Mulai Konsultasi & Laporan &rarr;
                        </a>
                        <a href="#fitur" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-semibold rounded-2xl border border-white/20 transition">
                            Pelajari Fitur Kami
                        </a>
                    </div>
                </div>
            </section>

            <!-- Feature Highlights Section -->
            <section id="fitur" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-xs uppercase tracking-widest font-bold text-rose-600 mb-3">Tiga Layanan Utama</h2>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-berry-900 tracking-tight">Dirancang Khusus untuk Kebutuhan dan Keamanan Penyintas</h3>
                    <p class="text-ink-600 mt-4 text-base">Kami mengutamakan kerahasiaan, empati, dan akses mudah terhadap bantuan hukum maupun psikologis.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1: Pelaporan -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-cream-200 hover:shadow-md transition group">
                        <div class="w-14 h-14 rounded-2xl bg-berry-100 text-berry-700 flex items-center justify-center mb-6 group-hover:bg-berry-700 group-hover:text-white transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-berry-900 mb-3">Pelaporan Aman & Anonim</h4>
                        <p class="text-ink-600 text-sm leading-relaxed mb-6">
                            Buat laporan kasus kekerasan atau diskriminasi secara bernama maupun anonim. Dilengkapi kode pelacakan unik dan perlindungan ketat identitas (NFR-05).
                        </p>
                        <a href="{{ route('register') }}" class="text-berry-700 hover:text-rose-600 font-semibold text-sm inline-flex items-center space-x-1 group-hover:translate-x-1 transition">
                            <span>Buat Laporan</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <!-- Feature 2: Konsultasi -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-cream-200 hover:shadow-md transition group">
                        <div class="w-14 h-14 rounded-2xl bg-lavender-200 text-lavender-600 flex items-center justify-center mb-6 group-hover:bg-lavender-600 group-hover:text-white transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-berry-900 mb-3">Konsultasi Psikolog & Konselor</h4>
                        <p class="text-ink-600 text-sm leading-relaxed mb-6">
                            Pilih jadwal sesi konsultasi privat dengan psikolog berlisensi (STR/SIPP). Gunakan nama samaran (alias) demi kenyamanan dan ketenangan emosional Anda.
                        </p>
                        <a href="{{ route('register') }}" class="text-berry-700 hover:text-rose-600 font-semibold text-sm inline-flex items-center space-x-1 group-hover:translate-x-1 transition">
                            <span>Cari Konselor</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <!-- Feature 3: Edukasi -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-cream-200 hover:shadow-md transition group">
                        <div class="w-14 h-14 rounded-2xl bg-rose-200 text-rose-600 flex items-center justify-center mb-6 group-hover:bg-rose-600 group-hover:text-white transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-berry-900 mb-3">Edukasi & Direktori Layanan</h4>
                        <p class="text-ink-600 text-sm leading-relaxed mb-6">
                            Akses artikel hak perempuan, kesehatan reproduksi, serta direktori lengkap lembaga bantuan mitra seperti UPTD PPA, LBH, dan hotline SAPA 129.
                        </p>
                        <a href="{{ route('register') }}" class="text-berry-700 hover:text-rose-600 font-semibold text-sm inline-flex items-center space-x-1 group-hover:translate-x-1 transition">
                            <span>Jelajahi Edukasi</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- About & SDGs Section -->
            <section id="tentang" class="bg-cream-100 py-20 border-y border-cream-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="text-xs uppercase tracking-widest font-bold text-rose-600 mb-2 block">Tentang Ruang Puan</span>
                        <h3 class="text-3xl font-extrabold text-berry-900 tracking-tight mb-6">Mendukung Penuh Kesetaraan Gender & SDGs 5</h3>
                        <p class="text-ink-600 leading-relaxed mb-6">
                            Ruang Puan adalah proyek akademik kolaboratif yang didedikasikan untuk menghadirkan ekosistem digital yang ramah penyintas. Kami percaya bahwa setiap perempuan berhak atas rasa aman, keadilan hukum, dan akses pendampingan psikologis tanpa stigma.
                        </p>
                        <div class="grid grid-cols-2 gap-6 pt-4 border-t border-cream-200">
                            <div>
                                <h4 class="text-3xl font-extrabold text-berry-700">100%</h4>
                                <p class="text-sm text-ink-600 mt-1">Kerahasiaan data pelapor terlindungi.</p>
                            </div>
                            <div>
                                <h4 class="text-3xl font-extrabold text-rose-600">24/7</h4>
                                <p class="text-sm text-ink-600 mt-1">Akses informasi & direktori darurat.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-cream-200">
                        <h4 class="text-xl font-bold text-berry-900 mb-4">Fitur Unggulan Sistem</h4>
                        <ul class="space-y-4 text-sm text-ink-600">
                            <li class="flex items-start space-x-3">
                                <span class="w-5 h-5 rounded-full bg-success-100 text-success-600 flex items-center justify-center font-bold text-xs mt-0.5">✓</span>
                                <span>Multi-peran terintegrasi (Pengguna, Konselor terverifikasi STR/SIPP, dan Admin).</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="w-5 h-5 rounded-full bg-success-100 text-success-600 flex items-center justify-center font-bold text-xs mt-0.5">✓</span>
                                <span>Pemisahan ketat pemesanan dan pembayaran guna mencegah double-booking slot.</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="w-5 h-5 rounded-full bg-success-100 text-success-600 flex items-center justify-center font-bold text-xs mt-0.5">✓</span>
                                <span>Antarmuka tenang dan hangat dengan palet warna khusus penyintas (Berry & Cream).</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>

        <!-- Professional Footer -->
        <footer class="bg-berry-900 text-cream-100 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="space-y-3">
                    <h5 class="text-lg font-bold text-white">Ruang Puan</h5>
                    <p class="text-xs text-cream-100/70 leading-relaxed">
                        Platform web pelaporan, edukasi, dan konsultasi untuk mendukung kesetaraan gender dan perlindungan hak perempuan (SDGs 5).
                    </p>
                </div>
                <div>
                    <h6 class="text-sm font-semibold text-rose-200 mb-3">Layanan</h6>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('register') }}" class="hover:underline">Buat Laporan</a></li>
                        <li><a href="{{ route('register') }}" class="hover:underline">Cari Konselor</a></li>
                        <li><a href="{{ route('register') }}" class="hover:underline">Direktori Bantuan</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-sm font-semibold text-rose-200 mb-3">Darurat</h6>
                    <ul class="space-y-2 text-xs">
                        <li>Hotline SAPA: <span class="font-bold text-white">129</span></li>
                        <li>WhatsApp SAPA: <span class="font-bold text-white">0821-1111-1129</span></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-sm font-semibold text-rose-200 mb-3">Akademik & Tim</h6>
                    <p class="text-xs text-cream-100/70">Proyek Scrum MVP — 5 Anggota Tim Pengembang.</p>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-berry-700 text-center text-xs text-cream-100/60">
                &copy; {{ date('Y') }} Ruang Puan. Seluruh hak cipta dilindungi undang-undang.
            </div>
        </footer>
    </body>
</html>
