<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Ruang Puan' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-cream-50 text-ink-900 font-sans antialiased min-h-screen flex flex-col selection:bg-berry-100 selection:text-berry-900">
        <!-- Master Header / Navbar slot -->
        @hasSection('header-nav')
            @yield('header-nav')
        @else
            <header class="bg-berry-900 text-white shadow-sm border-b border-berry-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-white hover:text-rose-200 transition">
                            Ruang Puan
                        </a>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-berry-700 text-rose-200 border border-berry-500">
                            MVP
                        </span>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-sm text-cream-100">Halo, {{ auth()->user()->nama ?? auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-berry-700 text-white transition font-medium">
                                    Keluar
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm px-3 py-1.5 rounded-lg text-cream-100 hover:bg-berry-700 transition font-medium">Masuk</a>
                            <a href="{{ route('register') }}" class="text-sm px-3.5 py-1.5 rounded-lg bg-rose-600 hover:bg-berry-500 text-white transition font-medium">Daftar</a>
                        @endauth
                    </div>
                </div>
            </header>
        @endif

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                <div class="bg-success-100 border border-success-600 text-success-600 px-4 py-3 rounded-xl text-sm shadow-sm" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                <div class="bg-danger-100 border border-danger-600 text-danger-600 px-4 py-3 rounded-xl text-sm shadow-sm" role="alert">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-cream-100 border-t border-cream-200 py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-ink-600">
                &copy; {{ date('Y') }} Ruang Puan. Mendukung Kesetaraan & Perlindungan Hak Perempuan (SDGs 5).
            </div>
        </footer>
    </body>
</html>
