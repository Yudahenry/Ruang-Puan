<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pulihkan Kata Sandi — Ruang Puan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-heading { font-family: 'Lora', Georgia, serif; }
        body { font-family: 'Inter', system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-[#FCFAF8] text-[#3E293F] antialiased flex items-center justify-center p-4 sm:p-6">

<div class="max-w-md w-full bg-white rounded-3xl border border-[#DCD5DD] p-8 sm:p-10 shadow-sm">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-11 h-11 rounded-2xl bg-[#643B62] flex items-center justify-center shadow-inner text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7h2a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2h2m0 0V5a3 3 0 116 0v2m-6 0h6"/>
            </svg>
        </div>
        <div>
            <p class="font-serif font-bold text-base leading-tight text-[#3E293F]">Ruang Puan</p>
            <p class="text-[10px] text-[#746B77]">Pemulihan Akun</p>
        </div>
    </div>

    <h1 class="font-heading text-2xl sm:text-3xl mb-3 text-[#3E293F]">Lupa kata sandi?</h1>
    <p class="text-xs text-[#746B77] mb-6 leading-relaxed">
        Masukkan alamat email terdaftar kamu, dan kami akan menyiapkan tautan untuk mengatur ulang kata sandi kamu.
    </p>

    @if (session('status'))
        <div class="mb-6 bg-[#EEE7F2] border border-[#DCD5DD] text-[#643B62] p-4 rounded-xl text-xs font-medium leading-relaxed">
            <p>{{ session('status') }}</p>
            @if (session('reset_url'))
                <a href="{{ session('reset_url') }}" class="mt-2.5 inline-flex items-center gap-1 font-bold underline text-[#3E293F] hover:text-[#643B62] transition">
                    Reset Kata Sandi Sekarang
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            @endif
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-[#F6DEDC] border border-[#B3261E]/30 text-[#B3261E] p-4 rounded-2xl text-xs shadow-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="block text-xs font-bold text-[#3E293F] mb-1.5">Email Terdaftar</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="nama@email.com"
                   class="w-full rounded-xl border border-[#DCD5DD] bg-white px-4 py-3 text-xs text-[#3E293F] placeholder-[#746B77]/50 focus:border-[#643B62] focus:ring-1 focus:ring-[#643B62] focus:outline-none transition shadow-inner">
        </div>

        <button type="submit"
                class="w-full py-3.5 px-4 bg-[#643B62] hover:bg-[#3E293F] text-white text-xs font-bold rounded-xl shadow-sm transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2 mt-2">
            Kirim Tautan Reset Sandi
        </button>

        <div class="text-center pt-4">
            <a href="{{ route('login') }}" class="text-xs font-bold text-[#643B62] hover:underline inline-flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke halaman masuk
            </a>
        </div>
    </form>
</div>

</body>
</html>