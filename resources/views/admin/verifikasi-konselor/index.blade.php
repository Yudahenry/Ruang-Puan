<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Konselor - Ruang Puan</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8F5F6] text-gray-800 min-h-screen">

    <!-- Header / Navbar Sesuai Tema Ruang Puan -->
    <header class="bg-[#4A1E2C] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-white/10 p-2 rounded-lg">
                    <span class="text-xl font-bold tracking-wide">Ruang Puan</span>
                </div>
                <span class="text-xs text-pink-200 tracking-wider uppercase border-l border-white/20 pl-3">Admin Dashboard</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm bg-[#6B2D40] px-4 py-1.5 rounded-full text-pink-100 font-medium">Halo, Admin</span>
                <a href="/" class="text-sm hover:text-pink-200 transition">Beranda Utama</a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-6 py-10">
        
        <!-- Page Title Card -->
        <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#4A1E2C]">Verifikasi Akun Konselor</h1>
                <p class="text-sm text-gray-500 mt-1">Periksa kelengkapan dokumen STR/SIPP konselor yang mendaftar pada platform Ruang Puan.</p>
            </div>
            <div class="bg-purple-50 text-purple-700 px-4 py-2 rounded-xl text-xs font-semibold border border-purple-100">
                Modul Administrasi (FR-23)
            </div>
        </div>

        <!-- Notification Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <span class="text-xs font-bold uppercase">Berhasil</span>
            </div>
        @endif

        <!-- Table Card Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-[#4A1E2C]">Daftar Konselor Menunggu Verifikasi</h2>
                <span class="text-xs bg-amber-50 text-amber-700 px-3 py-1 rounded-full font-semibold border border-amber-200">
                    Pending: {{ isset($konselors) ? $konselors->count() : 0 }} Akun
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/75 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-6">Nama & Email Konselor</th>
                            <th class="py-4 px-6">Spesifikasi Keahlian</th>
                            <th class="py-4 px-6">No. STR / SIPP</th>
                            <th class="py-4 px-6">Dokumen Verifikasi</th>
                            <th class="py-4 px-6 text-center">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($konselors as $konselor)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900">{{ $konselor->user->name ?? 'Tanpa Nama' }}</div>
                                    <div class="text-xs text-gray-500">{{ $konselor->user->email ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6 text-gray-700 font-medium">
                                    {{ $konselor->spesifikasi }}
                                </td>
                                <td class="py-4 px-6 text-gray-600 font-mono text-xs">
                                    {{ $konselor->nomor_lisensi }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($konselor->dokumen_verifikasi)
                                        <a href="{{ asset('storage/' . $konselor->dokumen_verifikasi) }}" target="_blank" class="inline-flex items-center space-x-1.5 text-xs bg-purple-50 text-purple-700 hover:bg-purple-100 px-3 py-2 rounded-xl font-semibold border border-purple-200 transition">
                                            <span>📄</span>
                                            <span>Lihat Dokumen</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center justify-center space-x-2">
                                        <!-- Form Setujui -->
                                        <form action="{{ route('admin.konselor.update', $konselor->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_verifikasi" value="approved">
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-4 py-2 rounded-xl font-semibold shadow-sm transition">
                                                Setujui
                                            </button>
                                        </form>

                                        <!-- Form Tolak -->
                                        <form action="{{ route('admin.konselor.update', $konselor->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak verifikasi konselor ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_verifikasi" value="rejected">
                                            <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs px-4 py-2 rounded-xl font-semibold shadow-sm transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <span class="text-4xl">📂</span>
                                        <p class="text-sm font-medium text-gray-600">Belum ada data pendaftaran konselor yang menunggu verifikasi.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>