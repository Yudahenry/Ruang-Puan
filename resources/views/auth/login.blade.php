@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 my-10 transition-shadow duration-200 hover:shadow-md" 
     x-data="{ 
         email: '{{ old('email') }}', 
         password: '', 
         loading: false,
         emailError() {
             if (!this.email) return '';
             if (!this.email.includes('@') || !this.email.includes('.')) return 'Format email belum valid.';
             return '';
         }
     }">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Masuk ke Ruang Puan</h1>
        <p class="text-sm text-ink-600 mt-1">Silakan masuk menggunakan akun terdaftar Anda.</p>
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

    <form method="POST" action="{{ route('login') }}" @submit="loading = true" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-ink-900 mb-1">Email</label>
            <input id="email" type="email" name="email" x-model="email" required autofocus autocomplete="username"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition">
            <p x-text="emailError()" class="text-xs text-danger-600 mt-1" x-show="emailError()"></p>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-ink-900 mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" x-model="password" required autocomplete="current-password"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition">
        </div>

        <div class="flex items-center justify-between text-sm pt-1">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-cream-200 text-berry-700 focus:ring-berry-500">
                <span class="ml-2 text-ink-600 text-xs">Ingat Saya</span>
            </label>
        </div>

        <button type="submit" :disabled="loading" 
                class="w-full py-2.5 px-4 bg-berry-700 hover:bg-berry-900 text-white font-semibold rounded-lg shadow-sm transition-all duration-200 active:scale-[0.98] flex items-center justify-center space-x-2">
            <span x-show="!loading">Masuk</span>
            <span x-show="loading" class="inline-flex items-center space-x-2" style="display: none;">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memproses...</span>
            </span>
        </button>

        <p class="text-center text-xs text-ink-600 pt-2">
            Belum punya akun? <a href="{{ route('register') }}" class="text-rose-600 hover:underline font-semibold">Daftar sekarang</a>
        </p>
    </form>
</div>
@endsection
