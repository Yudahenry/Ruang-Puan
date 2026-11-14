<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ruang Puan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased overflow-hidden">
    
    <!-- WRAPPER UTAMA: Mengunci layar penuh setinggi 100vh tanpa scroll luar -->
    <div class="flex h-screen w-screen overflow-hidden">

        <!-- SIDEBAR: Diam di kiri, tingginya full, menu di dalamnya bisa di-scroll kalau panjang -->
        <aside class="w-64 bg-[#643B62] text-white flex flex-col h-full shrink-0 shadow-lg">
            <!-- Logo / Header Sidebar -->
            <div class="p-5 font-bold text-lg border-b border-purple-800 flex items-center justify-between shrink-0">
                <span>Ruang Puan</span>
                <span class="text-xs bg-purple-900 px-2 py-0.5 rounded text-purple-200">ADMIN</span>
            </div>

            <!-- Menu Navigasi (Bisa di-scroll jika menu banyak) -->
            <nav class="flex-1 p-4 space-y-1.5 text-sm overflow-y-auto">
                <p class="text-xs font-semibold text-purple-300 uppercase tracking-wider mb-2">Menu Utama</p>
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-purple-800 font-semibold' : '' }}">Dashboard</a>
                <a href="{{ route('admin.laporan.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-800 transition {{ request()->routeIs('admin.laporan.*') ? 'bg-purple-800 font-semibold' : '' }}">Kelola Laporan</a>
                <a href="{{ route('admin.edukasi.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-800 transition {{ request()->routeIs('admin.edukasi.*') ? 'bg-purple-800 font-semibold' : '' }}">Kelola Edukasi</a>
                <a href="{{ route('admin.direktori.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-800 transition {{ request()->routeIs('admin.direktori.*') ? 'bg-purple-800 font-semibold' : '' }}">Direktori Layanan</a>
                
                <p class="text-xs font-semibold text-purple-300 uppercase tracking-wider mt-6 mb-2">Persetujuan & Akun</p>
                <a href="{{ route('admin.konselor.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-800 transition {{ request()->routeIs('admin.konselor.*') ? 'bg-purple-800 font-semibold' : '' }}">Verifikasi Konselor</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-800 transition {{ request()->routeIs('admin.users.*') ? 'bg-purple-800 font-semibold' : '' }}">Kelola Akun Pengguna</a>
            </nav>

            <!-- Tombol Keluar di Bawah Sidebar -->
            <div class="p-4 border-t border-purple-800 shrink-0">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-200 hover:bg-purple-800 rounded-lg transition">Keluar</button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA DI KANAN -->
        <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-gray-50">
            <!-- Header Atas (Tetap di atas, tidak ikut scroll) -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 border-b shrink-0 z-10">
                <span class="text-sm font-medium text-gray-600">Panel Administrasi Sistem</span>
                <span class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</span>
            </header>

            <!-- Area Konten Utama (HANYA BAGIAN INI YANG BISA DI-SCROLL KE BAWAH) -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>

    </div>
</body>
</html>