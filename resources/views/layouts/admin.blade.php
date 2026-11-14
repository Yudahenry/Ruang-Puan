<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ruang Puan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">

        <!-- SIDEBAR DI KIRI -->
        <aside class="w-64 bg-[#4A1D33] text-white flex flex-col shadow-md">
            <div class="p-5 font-bold text-lg border-b border-purple-900 flex items-center space-x-2">
                <span>Ruang Puan</span>
                <span class="text-xs bg-purple-800 px-2 py-0.5 rounded">ADMIN</span>
            </div>

            <nav class="flex-1 p-4 space-y-2 text-sm">
                <p class="text-xs font-semibold text-purple-300 uppercase tracking-wider mb-2">Menu Utama</p>
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-900 transition {{ request()->routeIs('admin.dashboard') ? 'bg-purple-900 font-semibold' : '' }}">Dashboard</a>
                <a href="{{ route('admin.laporan.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-900 transition {{ request()->routeIs('admin.laporan.*') ? 'bg-purple-900 font-semibold' : '' }}">Kelola Laporan</a>
                <a href="{{ route('admin.edukasi.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-900 transition {{ request()->routeIs('admin.edukasi.*') ? 'bg-purple-900 font-semibold' : '' }}">Kelola Edukasi</a>
                <a href="{{ route('admin.direktori.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-900 transition {{ request()->routeIs('admin.direktori.*') ? 'bg-purple-900 font-semibold' : '' }}">Direktori Layanan</a>
                
                <p class="text-xs font-semibold text-purple-300 uppercase tracking-wider mt-6 mb-2">Persetujuan & Akun</p>
                <a href="{{ route('admin.konselor.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-900 transition {{ request()->routeIs('admin.konselor.*') ? 'bg-purple-900 font-semibold' : '' }}">Verifikasi Konselor</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg hover:bg-purple-900 transition {{ request()->routeIs('admin.users.*') ? 'bg-purple-900 font-semibold' : '' }}">Kelola Akun Pengguna</a>
            </nav>

            <div class="p-4 border-t border-purple-900">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-200 hover:bg-purple-900 rounded-lg transition">Keluar</button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA DI KANAN -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 border-b">
                <span class="text-sm font-medium text-gray-600">Panel Administrasi Sistem</span>
                <span class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</span>
            </header>

            <main class="flex-1 overflow-y-auto">
                @yield('content')
                @yield('admin-content')
            </main>
        </div>

    </div>
</body>
</html>