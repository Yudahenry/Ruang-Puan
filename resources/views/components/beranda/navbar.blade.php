{{-- Navbar: Sticky pill-shaped bar matching PDF design --}}
<nav class="sticky top-4 z-50 bg-[#FCFAF8]/90 backdrop-blur-md shadow-sm rounded-full max-w-7xl mx-auto px-6 lg:px-8 h-16 flex items-center justify-between mb-6 transition-all duration-300 border border-[#DCD5DD]" x-data="{ profileOpen: false }">
    {{-- Kiri: Logo + Brand --}}
    <div class="flex items-center space-x-3">
        <a href="{{ route('pengguna.dashboard') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-full bg-[#643B62] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition">
                <svg class="w-5 h-5 text-[#EEE7F2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <span class="text-lg font-bold tracking-tight text-[#3E293F] group-hover:text-[#643B62] transition font-serif">Ruang Puan</span>
                <span class="block text-[10px] text-[#746B77] font-medium leading-tight">Ruang untuk didengar.</span>
            </div>
        </a>
    </div>

    {{-- Tengah: Nav Links dalam pill --}}
    <div class="hidden md:flex items-center space-x-1 bg-[#EEE7F2]/60 p-1 rounded-full border border-[#DCD5DD]">
        <a href="{{ route('pengguna.dashboard') }}" class="px-5 py-2 rounded-full text-sm transition-all duration-200 {{ request()->routeIs('pengguna.dashboard') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">Beranda</a>
        <a href="{{ route('pelaporan.buat') }}" class="px-5 py-2 rounded-full text-sm transition-all duration-200 {{ request()->routeIs('pelaporan.*') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">Pelaporan</a>
        <a href="{{ route('edukasi.index') }}" class="px-5 py-2 rounded-full text-sm transition-all duration-200 {{ request()->routeIs('edukasi.*') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">Edukasi</a>
        <a href="{{ route('direktori.index') }}" class="px-5 py-2 rounded-full text-sm transition-all duration-200 {{ request()->routeIs('direktori.*') ? 'bg-white text-[#3E293F] font-medium shadow-xs' : 'text-[#746B77] hover:text-[#3E293F] hover:bg-white/60' }}">Konsultasi</a>
    </div>

    {{-- Kanan: Notifikasi + Profile --}}
    <div class="flex items-center space-x-3">
        {{-- Notification Bell --}}
        <button class="relative p-2.5 rounded-full bg-[#EEE7F2] hover:bg-[#DCD5DD] text-[#643B62] transition" title="Notifikasi">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>

        {{-- Divider --}}
        <div class="w-px h-8 bg-[#DCD5DD]"></div>

        {{-- Profile Dropdown --}}
        <div class="relative" x-data="{ profileOpen: false }">
            <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 p-1 rounded-full hover:bg-[#EEE7F2] transition">
                <div class="w-9 h-9 rounded-full bg-[#643B62] text-white font-bold flex items-center justify-center text-sm shadow-sm">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'P', 0, 2)) }}
                </div>
                <div class="hidden lg:block text-left">
                    <div class="text-xs font-semibold text-[#3E293F] truncate max-w-[100px]">{{ auth()->user()->nama ?? 'Pengguna' }}</div>
                    <div class="text-[10px] text-[#746B77]">Profil saya</div>
                </div>
                <svg class="w-4 h-4 text-[#746B77] hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="profileOpen" @click.away="profileOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-[#DCD5DD] py-2 z-50">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-[#3E293F] hover:bg-[#FCFAF8] transition">
                    <svg class="w-4 h-4 mr-3 text-[#746B77]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Profil Saya
                </a>
                <a href="{{ route('pelaporan.riwayat') }}" class="flex items-center px-4 py-2.5 text-sm text-[#3E293F] hover:bg-[#FCFAF8] transition">
                    <svg class="w-4 h-4 mr-3 text-[#746B77]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Riwayat Saya
                </a>
                <div class="border-t border-[#DCD5DD]/50 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>