@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-10">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-berry-900">Masuk ke Ruang Puan</h1>
        <p class="text-sm text-ink-600 mt-1">Silakan masuk menggunakan akun terdaftar Anda.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-danger-100 border border-danger-600 text-danger-600 p-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-ink-900 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-ink-900 mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-cream-200 text-berry-700 focus:ring-berry-500">
                <span class="ml-2 text-ink-600">Ingat Saya</span>
            </label>
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg shadow-sm transition">
            Masuk
        </button>

        <p class="text-center text-sm text-ink-600 mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-rose-600 hover:underline font-medium">Daftar di sini</a>
        </p>
    </form>
</div>
@endsection
