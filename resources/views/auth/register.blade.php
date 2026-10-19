@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-10" x-data="{ role: '{{ old('role', 'pengguna') }}' }">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-berry-900">Pendaftaran Akun</h1>
        <p class="text-sm text-ink-600 mt-1">Bergabung dengan Ruang Puan untuk pelaporan & konsultasi aman.</p>
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

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="nama" class="block text-sm font-medium text-ink-900 mb-1">Nama Lengkap</label>
            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-ink-900 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-ink-900 mb-1">Daftar Sebagai</label>
            <select id="role" name="role" x-model="role"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
                <option value="pengguna">Pengguna / Pelapor</option>
                <option value="konselor">Konselor / Psikolog</option>
            </select>
        </div>

        <div>
            <label for="alias" class="block text-sm font-medium text-ink-900 mb-1">Nama Samaran / Alias (Opsional)</label>
            <input id="alias" type="text" name="alias" value="{{ old('alias') }}"
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
            <p class="text-xs text-ink-600 mt-1">Digunakan untuk menjaga privasi saat sesi konsultasi.</p>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-ink-900 mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-ink-900 mb-1">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg shadow-sm transition">
            Daftar Sekarang
        </button>

        <p class="text-center text-sm text-ink-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-rose-600 hover:underline font-medium">Masuk di sini</a>
        </p>
    </form>
</div>
@endsection
