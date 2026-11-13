<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Ruang Puan') }} — Dashboard Pengguna</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|fraunces:400,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FCFAF8] text-[#3E293F] font-sans antialiased min-h-screen flex flex-col selection:bg-[#EEE7F2] selection:text-[#3E293F]"
          x-data="{ mobileMenuOpen: false, profileDropdown: false, notifOpen: false }">

        <!-- Navbar Pengguna Tunggal & Elegan -->
        <header class="bg-white border-b border-[#DCD5DD] sticky top-0 z-50 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('pengguna.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-2xl bg-[#3E293F] text-white flex items-center justify-center font-bold shadow-md group-hover:bg-[#643B62] transition">
                            RP
                        </div>
                        <div>
                            <span class="text-xl font-serif font-bold text-[#3E293F] tracking-tight block">Ruang Puan</span>
                            <span class="text-[10px] text-[#746B77] uppercase tracking-widest font-semibold">Ruang untuk didengar.</span>
                        </div>
                    </a>

                    <!-- Navigasi Desktop (Pill Style) -->
                    <nav class="hidden md:flex items-center space-x-1 bg-[#EEE7F2]/60 p-1.5 rounded-full border border-[#DCD5DD]">
                        <a href="{{ route('pengguna.dashboard') }}" 
                           class="px-5 py-2 rounded-full text-xs font-bold transition {{ request()->routeIs('pengguna.dashboard') ? 'bg-white text-[#3E293F] shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]' }}">
                            Beranda
                        </a>
                        <a href="{{ route('pelaporan.riwayat') }}" 
                           class="px-5 py-2 rounded-full text-xs font-bold transition {{ request()->routeIs('pelaporan.*') ? 'bg-white text-[#3E293F] shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]' }}">
                            Pelaporan
                        </a>
                        <a href="{{ route('edukasi.index') }}" 
                           class="px-5 py-2 rounded-full text-xs font-bold transition {{ request()->routeIs('edukasi.*') ? 'bg-white text-[#3E293F] shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]' }}">
                            Edukasi
                        </a>
                        <a href="{{ route('konsultasi.index') }}" 
                           class="px-5 py-2 rounded-full text-xs font-bold transition {{ request()->routeIs('konsultasi.*') ? 'bg-white text-[#3E293F] shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]' }}">
                            Konsultasi
                        </a>
                    </nav>
                </div>

                <!-- Right Action & Profile -->
                <div class="flex items-center space-x-4">
                    <!-- Notifikasi -->
                    <button class="w-10 h-10 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD] text-[#746B77] hover:text-[#3E293F] flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 p-1.5 rounded-2xl hover:bg-[#EEE7F2]/50 transition border border-transparent hover:border-[#DCD5DD]">
                            <div class="w-9 h-9 rounded-xl bg-[#643B62] text-white flex items-center justify-center font-bold text-xs shadow-inner">
                                {{ strtoupper(mb_substr(auth()->user()->nama ?? 'Y', 0, 2)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <span class="text-xs font-bold text-[#3E293F] block">{{ auth()->user()->nama ?? 'Yuda' }}</span>
                                <span class="text-[10px] text-[#746B77] block">Profil saya</span>
                            </div>
                            <svg class="w-4 h-4 text-[#746B77]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-3xl shadow-xl border border-[#DCD5DD] py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-xs font-semibold text-[#3E293F] hover:bg-[#EEE7F2]/60 transition">Kelola Profil Akun</a>
                            <div class="my-1 border-t border-[#DCD5DD]"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition">Keluar (Logout)</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('pengguna-content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-[#DCD5DD] py-8 mt-auto text-xs text-[#746B77]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} Ruang Puan. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center space-x-6">
                    <a href="#" class="hover:underline">Kebijakan privasi</a>
                    <a href="#" class="hover:underline">Pusat bantuan</a>
                </div>
            </div>
        </footer>
    </body>
</html>