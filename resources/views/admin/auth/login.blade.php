@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-8 sm:p-10 my-6 transition-shadow duration-200 hover:shadow-md" 
        x-data="{ 
            email: '{{ old('email', 'admin1@ruangpuan.com') }}', 
            password: '', 
            loading: false,
            emailError() {
                if (!this.email) return '';
                if (!this.email.includes('@') || !this.email.includes('.')) return 'Format email belum valid.';
                return '';
            }
        }">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto mb-4 font-bold text-lg shadow-inner">
                🛡️
            </div>
            <h1 class="text-2xl font-serif font-medium text-[#3E293F] tracking-tight">Login Administrator</h1>
            <p class="text-xs sm:text-sm text-[#6B5C62] mt-1.5">Silakan masuk menggunakan akun khusus admin.</p>
        </div>

        <!-- Error Alert -->
        @if($errors->any())
            <div class="mb-6 bg-[#F6DEDC] border border-[#B3261E]/30 text-[#B3261E] p-4 rounded-2xl text-xs sm:text-sm shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('admin.login.submit') }}" @submit="loading = true" class="space-y-5">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs sm:text-sm font-semibold text-[#3E293F] mb-1.5">Email Admin</label>
                <input id="email" type="email" name="email" x-model="email" required autofocus autocomplete="username"
                    class="w-full rounded-xl border-[#DCD5DD] bg-[#FCFAF8] focus:border-[#643B62] focus:ring-[#643B62] px-4 py-3 text-[#3E293F] border text-sm transition shadow-inner">
                <p x-text="emailError()" class="text-xs text-[#B3261E] mt-1.5" x-show="emailError()"></p>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-xs sm:text-sm font-semibold text-[#3E293F] mb-1.5">Kata Sandi</label>
                <input id="password" type="password" name="password" x-model="password" required autocomplete="current-password"
                    class="w-full rounded-xl border-[#DCD5DD] bg-[#FCFAF8] focus:border-[#643B62] focus:ring-[#643B62] px-4 py-3 text-[#3E293F] border text-sm transition shadow-inner">
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center justify-between text-sm pt-1">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-[#DCD5DD] text-[#643B62] focus:ring-[#643B62] w-4 h-4">
                    <span class="ml-2.5 text-[#6B5C62] text-xs">Ingat Saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" :disabled="loading" 
                    class="w-full py-3 px-4 bg-[#643B62] hover:bg-[#3E293F] text-white font-medium text-sm rounded-xl shadow-sm transition-all duration-200 active:scale-[0.98] flex items-center justify-center space-x-2">
                <span x-show="!loading">Masuk sebagai Admin</span>
                <span x-show="loading" class="inline-flex items-center space-x-2" style="display: none;">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memproses...</span>
                </span>
            </button>
        </form>
    </div>
</div>
@endsection