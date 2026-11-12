@extends('layouts.app')

@section('header-nav')
@php
    $user = auth()->user();
    $counselorName = $user ? ($user->nama !== 'mclaren' ? $user->nama : 'Dewi L., M.Psi.') : 'Dewi L., M.Psi.';
    $parts = explode(' ', trim($counselorName));
    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
@endphp
<header class="bg-[#FCFAF8]/95 backdrop-blur-md sticky top-0 z-40 border-b border-[#DCD5DD] shadow-2xs" x-data="{ mobileMenuOpen: false, profileDropdown: false, notifOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        <!-- Brand Logo -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('konselor.dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-2xl bg-[#643B62] text-white flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4 21l3.39-.97C8.93 20.66 10.42 21 12 21c4.97 0 9-4.03 9-9s-4.03-9-9-9z"/>
                        <path d="M12 7v6"/>
                        <path d="M9 10h6"/>
                    </svg>
                </div>
                <div>
                    <span class="font-serif font-bold text-xl text-[#3E293F] tracking-tight block leading-tight">Ruang Puan</span>
                    <span class="text-[11px] text-[#746B77] italic block leading-tight">Ruang untuk didengar</span>
                </div>
            </a>
        </div>

        <!-- Center Navigation Menu (Pill style matching design) -->
        <nav class="hidden md:flex items-center space-x-1 bg-[#EEE7F2]/60 p-1 rounded-full border border-[#DCD5DD]">
            <a href="{{ route('konselor.dashboard') }}" 
               class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('konselor.dashboard') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                Beranda
            </a>
            <a href="{{ route('konselor.jadwal') }}" 
               class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('konselor.jadwal') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                Jadwal
            </a>
            <a href="{{ route('konselor.booking') }}" 
               class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('konselor.booking') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                Booking Masuk
            </a>
            <a href="{{ route('konselor.chat') }}" 
               class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('konselor.chat') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                Chat
            </a>
            <a href="{{ route('konselor.riwayat') }}" 
               class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 {{ request()->routeIs('konselor.riwayat') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">
                Riwayat
            </a>
        </nav>

        <!-- Right Side: Notification Bell & Counselor Profile -->
        <div class="flex items-center space-x-3">
            
            <!-- Notification Bell -->
            <div class="relative" @click.away="notifOpen = false">
                <button type="button" @click="notifOpen = !notifOpen" 
                        class="p-2.5 text-[#746B77] hover:text-[#3E293F] hover:bg-[#EEE7F2] rounded-full transition relative focus:outline-none"
                        title="Notifikasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <!-- Unread badge dot -->
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#643B62] rounded-full ring-2 ring-white"></span>
                </button>

                <!-- Notification Dropdown Panel -->
                <div x-show="notifOpen" x-transition.origin.top.right 
                     class="absolute right-0 mt-2 w-80 bg-white rounded-3xl shadow-xl border border-[#DCD5DD] py-3 z-50 text-xs"
                     style="display: none;">
                    <div class="px-4 py-2 border-b border-[#DCD5DD]/50 flex items-center justify-between">
                        <span class="font-bold text-[#3E293F]">Pemberitahuan Terbaru</span>
                        <span class="text-[10px] text-[#643B62] font-semibold bg-[#EEE7F2] px-2.5 py-0.5 rounded-full">3 Baru</span>
                    </div>
                    <div class="divide-y divide-[#DCD5DD]/40 max-h-72 overflow-y-auto">
                        <div class="p-3.5 hover:bg-[#FCFAF8] transition flex items-start space-x-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#643B62] mt-1 flex-shrink-0"></span>
                            <div>
                                <p class="text-[#3E293F] font-semibold">Booking baru dari bungapagi</p>
                                <p class="text-[#746B77] text-[11px] mt-0.5">Sabtu, 24 Okt · 10.00 WIB (Chat 60 menit)</p>
                                <span class="text-[10px] text-[#746B77]/80 mt-1 block">20 menit yang lalu</span>
                            </div>
                        </div>
                        <div class="p-3.5 hover:bg-[#FCFAF8] transition flex items-start space-x-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#643B62] mt-1 flex-shrink-0"></span>
                            <div>
                                <p class="text-[#3E293F] font-semibold">Pembayaran yudahenry terkonfirmasi</p>
                                <p class="text-[#746B77] text-[11px] mt-0.5">Sesi terjadwal hari ini pukul 15.00 WIB.</p>
                                <span class="text-[10px] text-[#746B77]/80 mt-1 block">45 menit yang lalu</span>
                            </div>
                        </div>
                        <div class="p-3.5 hover:bg-[#FCFAF8] transition flex items-start space-x-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#DCD5DD] mt-1 flex-shrink-0"></span>
                            <div>
                                <p class="text-[#3E293F] font-medium">Sesi ruangsenja dijadwalkan</p>
                                <p class="text-[#746B77] text-[11px] mt-0.5">Hari ini pukul 17.00 WIB.</p>
                                <span class="text-[10px] text-[#746B77]/80 mt-1 block">2 jam yang lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="w-px h-8 bg-[#DCD5DD]"></div>

            <!-- Counselor Profile Pill & Dropdown -->
            <div class="relative" @click.away="profileDropdown = false">
                <button type="button" @click="profileDropdown = !profileDropdown"
                        class="flex items-center space-x-2.5 p-1 sm:pr-3 rounded-full hover:bg-[#EEE7F2] transition focus:outline-none">
                    <div class="w-9 h-9 rounded-full bg-[#643B62] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                        {{ $initials ?: 'DL' }}
                    </div>
                    <div class="text-left hidden sm:block">
                        <div class="text-xs font-semibold text-[#3E293F] leading-tight truncate max-w-[110px]">{{ $counselorName }}</div>
                        <div class="text-[10px] text-[#746B77] leading-tight">Profil saya</div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-[#746B77] transition-transform duration-200 hidden sm:block" :class="{ 'rotate-180': profileDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Profile Dropdown Menu -->
                <div x-show="profileDropdown" x-transition.origin.top.right 
                     class="absolute right-0 mt-3 w-56 bg-white rounded-3xl shadow-xl border border-[#DCD5DD] py-2 z-50 text-xs"
                     style="display: none;">
                    <div class="px-4 py-3 border-b border-[#DCD5DD]/60">
                        <p class="font-bold text-[#3E293F]">{{ $counselorName }}</p>
                        <p class="text-[#746B77] text-[11px] truncate">{{ $user->email ?? 'konselor@ruangpuan.test' }}</p>
                        <span class="inline-block mt-1.5 px-2.5 py-0.5 bg-[#EEE7F2] text-[#643B62] rounded-full text-[10px] font-semibold">
                            ✓ Konselor Terverifikasi
                        </span>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-[#3E293F] hover:bg-[#FCFAF8] transition">
                            <span class="mr-2.5">👤</span> Kelola Profil & Dokumen
                        </a>
                        <a href="{{ route('konselor.jadwal') }}" class="flex items-center px-4 py-2.5 text-[#3E293F] hover:bg-[#FCFAF8] transition">
                            <span class="mr-2.5">📅</span> Atur Jadwal Praktik
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-[#3E293F] hover:bg-[#FCFAF8] transition">
                            <span class="mr-2.5">⚙️</span> Pengaturan Akun
                        </a>
                    </div>

                    <div class="border-t border-[#DCD5DD]/60 pt-1">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-red-600 hover:bg-red-50 font-semibold transition">
                                <span class="mr-2.5">🚪</span> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="md:hidden flex items-center">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-[#3E293F] hover:bg-[#EEE7F2] rounded-xl transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-b border-[#DCD5DD] px-6 py-4 space-y-2 shadow-lg">
        <a href="{{ route('konselor.dashboard') }}" class="block px-4 py-2.5 rounded-2xl text-xs font-semibold {{ request()->routeIs('konselor.dashboard') ? 'bg-[#EEE7F2] text-[#3E293F]' : 'text-[#746B77] hover:bg-[#FCFAF8]' }}">
            Beranda
        </a>
        <a href="{{ route('konselor.jadwal') }}" class="block px-4 py-2.5 rounded-2xl text-xs font-medium text-[#746B77] hover:bg-[#FCFAF8]">
            Jadwal Praktik
        </a>
        <a href="{{ route('konselor.booking') }}" class="block px-4 py-2.5 rounded-2xl text-xs font-medium text-[#746B77] hover:bg-[#FCFAF8]">
            Booking Masuk
        </a>
        <a href="{{ route('konselor.chat') }}" class="block px-4 py-2.5 rounded-2xl text-xs font-medium text-[#746B77] hover:bg-[#FCFAF8]">
            Chat Konsultasi
        </a>
        <a href="{{ route('konselor.riwayat') }}" class="block px-4 py-2.5 rounded-2xl text-xs font-medium text-[#746B77] hover:bg-[#FCFAF8]">
            Riwayat
        </a>
        <div class="pt-3 border-t border-[#DCD5DD]/60 flex flex-col space-y-2">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-xs text-[#3E293F] font-medium">
                Profil & Dokumen STR/SIPP
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="min-h-screen text-[#3E293F] flex flex-col justify-between">
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">
        @yield('konselor-content')
    </main>

    <!-- Footer Konselor Selaras dengan Desain Ruang Puan -->
    <footer class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-[#DCD5DD] flex flex-col md:flex-row items-center justify-between text-xs text-[#746B77] space-y-4 md:space-y-0 pb-10 mt-12">
        <div class="flex items-center space-x-2.5">
            <div class="w-8 h-8 rounded-2xl bg-[#643B62] flex items-center justify-center shadow-inner">
                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4 21l3.39-.97C8.93 20.66 10.42 21 12 21c4.97 0 9-4.03 9-9s-4.03-9-9-9z"/>
                </svg>
            </div>
            <span class="font-serif font-bold text-[#3E293F] text-sm">Ruang Puan</span>
        </div>
        <div class="italic text-[#746B77] text-center font-serif">
            "Ruang untuk didengar. Bekal untuk melangkah."
        </div>
        <div class="flex items-center space-x-6 text-xs text-[#746B77]">
            <a href="#" class="hover:text-[#3E293F] transition">Kebijakan privasi</a>
            <span>&middot;</span>
            <a href="#" class="hover:text-[#3E293F] transition">Pusat bantuan</a>
        </div>
    </footer>
</div>
@endsection