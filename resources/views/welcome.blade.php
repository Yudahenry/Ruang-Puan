<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ruang Puan — Mendukung Kesetaraan & Perlindungan Hak Perempuan</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-cream-50 text-ink-900 font-sans antialiased min-h-screen flex flex-col selection:bg-berry-100 selection:text-berry-900">
        <header class="bg-berry-900 text-white shadow-sm border-b border-berry-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-white hover:text-rose-200 transition">
                        Ruang Puan
                    </a>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-berry-700 text-rose-200 border border-berry-500">
                        SDGs 5
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm px-3 py-1.5 rounded-lg bg-berry-700 hover:bg-berry-500 text-white transition font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm px-3 py-1.5 rounded-lg text-cream-100 hover:bg-berry-700 transition font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm px-3.5 py-1.5 rounded-lg bg-rose-600 hover:bg-berry-500 text-white transition font-medium">Daftar</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-16 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-10 max-w-2xl text-center">
                <h1 class="text-4xl font-bold text-berry-900 mb-4 tracking-tight">Ruang Aman & Terpercaya untuk Pelindungan dan Pemberdayaan Perempuan</h1>
                <p class="text-ink-600 mb-8 leading-relaxed">
                    Platform terintegrasi untuk layanan pelaporan kekerasan (bernama/anonim), edukasi hak perempuan, serta sesi konsultasi profesional dengan psikolog dan konselor tersertifikasi.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-6 py-3 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-xl shadow-sm transition">
                        Mulai Bergabung
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3 bg-cream-100 hover:bg-cream-200 text-ink-900 font-medium rounded-xl border border-cream-200 transition">
                        Masuk ke Akun
                    </a>
                </div>
            </div>
        </main>

        <footer class="bg-cream-100 border-t border-cream-200 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-ink-600">
                &copy; {{ date('Y') }} Ruang Puan. Mendukung Kesetaraan & Perlindungan Hak Perempuan (SDGs 5).
            </div>
        </footer>
    </body>
</html>
