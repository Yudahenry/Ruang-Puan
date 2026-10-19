@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow-sm border border-cream-200 p-8 my-10 text-center">
    <h1 class="text-2xl font-bold text-berry-900 mb-3">Verifikasi Email Anda</h1>
    <p class="text-sm text-ink-600 mb-6">
        Terima kasih telah mendaftar! Sebelum mulai, silakan verifikasi alamat email Anda melalui tautan yang baru saja kami kirimkan.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 bg-success-100 border border-success-600 text-success-600 p-3 rounded-xl text-sm">
            Tautan verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    <div class="flex items-center justify-between mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="py-2 px-4 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm transition">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-ink-600 hover:text-berry-700 underline">
                Keluar
            </button>
        </form>
    </div>
</div>
@endsection
