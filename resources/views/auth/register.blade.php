@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 my-8 transition-shadow duration-200 hover:shadow-md" 
     x-data="{ 
         nama: '{{ old('nama') }}',
         email: '{{ old('email') }}', 
         role: '{{ old('role', 'pengguna') }}',
         password: '', 
         password_confirmation: '',
         loading: false,
         emailError() {
             if (!this.email) return '';
             if (!this.email.includes('@') || !this.email.includes('.')) return 'Format email belum valid.';
             return '';
         },
         passwordError() {
             if (!this.password) return '';
             if (this.password.length < 8) return 'Kata sandi minimal 8 karakter.';
             return '';
         },
         confirmError() {
             if (!this.password_confirmation) return '';
             if (this.password !== this.password_confirmation) return 'Konfirmasi kata sandi tidak cocok.';
             return '';
         }
     }">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Pendaftaran Akun</h1>
        <p class="text-xs text-ink-600 mt-1">Bergabung dengan Ruang Puan untuk pelaporan & konsultasi aman.</p>
    </div>

    @if($errors->any())
        <div class="mb-5 bg-danger-100 border border-danger-600 text-danger-600 p-3.5 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" @submit="loading = true" class="space-y-4">
        @csrf

        <div>
            <label for="nama" class="block text-sm font-semibold text-ink-900 mb-1">Nama Lengkap</label>
            <input id="nama" type="text" name="nama" x-model="nama" required autofocus
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm transition">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-ink-900 mb-1">Email</label>
            <input id="email" type="email" name="email" x-model="email" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm transition">
            <p x-text="emailError()" class="text-xs text-danger-600 mt-1" x-show="emailError()"></p>
        </div>

        <div>
            <label for="role" class="block text-sm font-semibold text-ink-900 mb-1">Daftar Sebagai</label>
            <select id="role" name="role" x-model="role"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm transition">
                <option value="pengguna">Pengguna / Pelapor</option>
                <option value="konselor">Konselor / Psikolog</option>
            </select>
        </div>

        <div>
            <label for="alias" class="block text-sm font-semibold text-ink-900 mb-1">Nama Samaran / Alias (Opsional)</label>
            <input id="alias" type="text" name="alias" value="{{ old('alias') }}"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm transition">
            <p class="text-[11px] text-ink-600 mt-1">Digunakan untuk menjaga privasi saat sesi konsultasi.</p>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-ink-900 mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" x-model="password" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm transition">
            <p x-text="passwordError()" class="text-xs text-danger-600 mt-1" x-show="passwordError()"></p>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-ink-900 mb-1">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2 text-ink-900 border text-sm transition">
            <p x-text="confirmError()" class="text-xs text-danger-600 mt-1" x-show="confirmError()"></p>
        </div>

        <button type="submit" :disabled="loading" 
                class="w-full py-2.5 px-4 bg-berry-700 hover:bg-berry-900 text-white font-semibold rounded-lg shadow-sm transition-all duration-200 active:scale-[0.98] flex items-center justify-center space-x-2">
            <span x-show="!loading">Daftar Sekarang</span>
            <span x-show="loading" class="inline-flex items-center space-x-2" style="display: none;">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memproses...</span>
            </span>
        </button>

        <p class="text-center text-xs text-ink-600 pt-1">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-rose-600 hover:underline font-semibold">Masuk di sini</a>
        </p>
    </form>
</div>
@endsection
