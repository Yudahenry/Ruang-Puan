<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Ruang Puan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-heading { font-family: 'Lora', Georgia, serif; font-weight: 400; }
        body { font-family: 'DM Sans', system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-[#faf9fb] text-[#3b2a44] antialiased">

<div class="min-h-screen flex flex-col lg:flex-row p-3 sm:p-4">

    {{-- PANEL KIRI --}}
    <div class="hidden lg:flex lg:w-1/2 bg-[#ece4ef] rounded-3xl p-10 xl:p-12 flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-14">
                <div class="w-11 h-11 rounded-xl bg-[#6b3b63] flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20c-4 0-7-2.5-7-6 3 0 5 1 7 3 2-2 4-3 7-3 0 3.5-3 6-7 6zM12 4c1.5 2 2.5 4 2.5 6S13.5 14 12 17c-1.5-3-2.5-5-2.5-7S10.5 6 12 4z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base leading-tight">Ruang Puan</p>
                    <p class="text-[10px] text-[#3b2a44]/60">Ruang untuk didengar.</p>
                </div>
            </div>

            <h2 class="font-heading text-5xl xl:text-6xl leading-[1.12] mb-5">Kamu tidak<br>sendiri.</h2>
            <p class="text-xs text-[#3b2a44]/70 max-w-xs leading-relaxed">
                Apa pun yang sedang kamu lalui, ada ruang untuk bercerita, belajar, dan melangkah bersama.
            </p>
        </div>

        <div class="mt-8">
            <div class="rounded-2xl overflow-hidden h-52 xl:h-60 bg-[#e0d3e5] mb-8">
                <img src="{{ asset('images/login-hero.png') }}" alt="Ilustrasi dua perempuan bercerita"
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'">
            </div>

            <p class="font-heading text-base mb-4">Untuk setiap langkahmu.</p>
            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0 text-[#6b3b63]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h6m-9 8l3-3h11a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v14z"/></svg>
                    </span>
                    <span><span class="block text-xs font-bold">Pelaporan</span><span class="block text-[11px] text-[#3b2a44]/60">Sampaikan pengalamanmu tanpa penghakiman.</span></span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0 text-[#6b3b63]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.25v13m0-13C10.8 5.5 9.2 5 7.5 5S4.2 5.5 3 6.25v13C4.2 18.5 5.8 18 7.5 18s3.3.5 4.5 1.25m0-13C13.2 5.5 14.8 5 16.5 5c1.7 0 3.3.5 4.5 1.25v13C19.8 18.5 18.2 18 16.5 18c-1.7 0-3.3.5-4.5 1.25"/></svg>
                    </span>
                    <span><span class="block text-xs font-bold">Edukasi</span><span class="block text-[11px] text-[#3b2a44]/60">Kenali hakmu dan temukan pengetahuan baru.</span></span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0 text-[#6b3b63]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-9 6l3-3h11a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14z"/></svg>
                    </span>
                    <span><span class="block text-xs font-bold">Konsultasi</span><span class="block text-[11px] text-[#3b2a44]/60">Bicarakan kebutuhanmu bersama konselor.</span></span>
                </li>
            </ul>
        </div>
    </div>

    {{-- PANEL KANAN (FORM) --}}
    <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 lg:px-16 xl:px-24 py-6"
         x-data="{
            email: '{{ old('email') }}',
            password: '',
            role: '{{ old('role', 'pengguna') }}',
            show: false,
            loading: false,
            emailError() {
                if (!this.email) return '';
                if (!this.email.includes('@') || !this.email.includes('.')) return 'Format email belum valid.';
                return '';
            }
         }">

        {{-- Bar atas --}}
        <div class="flex items-center justify-between">
            <div class="flex lg:hidden items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#6b3b63] flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20c-4 0-7-2.5-7-6 3 0 5 1 7 3 2-2 4-3 7-3 0 3.5-3 6-7 6zM12 4c1.5 2 2.5 4 2.5 6S13.5 14 12 17c-1.5-3-2.5-5-2.5-7S10.5 6 12 4z"/></svg>
                </div>
                <p class="font-bold text-sm">Ruang Puan</p>
            </div>
            <a href="#" class="ml-auto inline-flex items-center gap-1.5 text-[11px] text-[#6b3b63] hover:underline">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9.5a2.5 2.5 0 114 2c-.8.6-1.5 1-1.5 2M12 17h.01"/></svg>
                Butuh bantuan?
            </a>
        </div>

        <div class="flex-1 flex flex-col justify-center max-w-md w-full mx-auto py-10">
            <p class="text-[9px] tracking-[0.2em] font-bold text-[#6b3b63] mb-3">RUANG UNTUKMU</p>
            <h1 class="font-heading text-4xl sm:text-5xl leading-[1.12] mb-4">Selamat datang<br>kembali.</h1>
            <p class="text-xs text-[#3b2a44]/60 mb-8 max-w-xs leading-relaxed">
                Masuk untuk mengakses dukungan dan informasi yang kamu butuhkan.
            </p>

            @if(session('status'))
                <div class="mb-6 bg-[#ece4ef] border border-[#d9cfde] text-[#6b3b63] p-3.5 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-300 text-red-700 p-3.5 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" @submit="loading = true" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-[11px] font-bold mb-1.5">Email</label>
                    <input id="email" type="email" name="email" x-model="email" required autofocus autocomplete="username"
                           placeholder="Masukkan email kamu"
                           class="w-full rounded-lg border border-[#e3dbe7] bg-white px-3.5 py-3 text-xs text-[#3b2a44] placeholder-[#3b2a44]/40 focus:border-[#6b3b63] focus:ring-1 focus:ring-[#6b3b63] focus:outline-none transition">
                    <p x-show="emailError()" x-text="emailError()" x-cloak class="text-xs text-red-600 mt-1"></p>
                </div>

                <div>
                    <label for="password" class="block text-[11px] font-bold mb-1.5">Kata sandi</label>
                    <div class="relative">
                        <input id="password" :type="show ? 'text' : 'password'" name="password" x-model="password" required autocomplete="current-password"
                               placeholder="Masukkan kata sandi"
                               class="w-full rounded-lg border border-[#e3dbe7] bg-white px-3.5 py-3 pr-10 text-xs text-[#3b2a44] placeholder-[#3b2a44]/40 focus:border-[#6b3b63] focus:ring-1 focus:ring-[#6b3b63] focus:outline-none transition">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#3b2a44]/50 hover:text-[#3b2a44]" aria-label="Tampilkan kata sandi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-[11px] font-bold mb-1.5">Masuk sebagai</label>
                    <select id="role" name="role" x-model="role"
                            class="w-full rounded-lg border border-[#e3dbe7] bg-white px-3.5 py-3 text-xs text-[#3b2a44] focus:border-[#6b3b63] focus:ring-1 focus:ring-[#6b3b63] focus:outline-none transition">
                        <option value="pengguna">Pengguna / Pelapor</option>
                        <option value="konselor">Konselor / Psikolog</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-[#d9cfde] text-[#6b3b63] focus:ring-[#6b3b63]">
                        <span class="text-[11px] text-[#3b2a44]/70">Ingat saya</span>
                    </label>
                    <a href="#" class="text-[11px] font-bold text-[#3b2a44] hover:underline">Lupa kata sandi?</a>
                </div>

                <button type="submit" :disabled="loading"
                        class="w-full py-3 px-4 bg-[#6b3b63] hover:bg-[#582f51] text-white text-xs font-bold rounded-lg shadow-md shadow-[#6b3b63]/20 transition-all duration-200 active:scale-[0.98] disabled:opacity-70 flex items-center justify-center gap-2">
                    <span x-show="!loading" class="inline-flex items-center gap-2">
                        Masuk
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                    </span>
                    <span x-show="loading" x-cloak class="inline-flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>

                <p class="text-center text-[11px] text-[#3b2a44]/60 pt-1">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-[#3b2a44] underline underline-offset-2">Daftar di sini</a>
                </p>
            </form>
        </div>

        <p class="flex items-center justify-center gap-1.5 text-center text-[10px] text-[#3b2a44]/50">
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="9" rx="2"/><path stroke-linecap="round" d="M8 11V8a4 4 0 118 0v3"/></svg>
            Jaga ruang pribadimu. Jangan bagikan kata sandi kepada siapa pun.
        </p>
    </div>
</div>

</body>
</html>
