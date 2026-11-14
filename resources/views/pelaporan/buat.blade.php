@extends('layouts.pengguna')

@section('pengguna-content')
<div class="bg-[#FCFAF8] min-h-screen text-[#3E293F] pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        {{-- 2. BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-xs text-[#746B77] py-3 mb-2" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="hover:text-[#3E293F] transition">Beranda</a>
            <svg class="w-3.5 h-3.5 text-[#746B77]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-[#746B77]">Pelaporan</span>
            <svg class="w-3.5 h-3.5 text-[#746B77]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-[#3E293F] font-semibold" aria-current="page">Buat laporan baru</span>
        </nav>

        {{-- 3. PAGE HEADER --}}
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-8">
            <div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#3E293F] tracking-tight">
                    Buat laporan
                </h1>
                <p class="text-xs sm:text-sm text-[#746B77] mt-2 max-w-2xl leading-relaxed">
                    Ceritakan yang kamu alami, dengan caramu sendiri. Ambil waktu yang kamu butuhkan.
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="{{ route('pelaporan.riwayat') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl border border-[#DCD5DD] bg-white hover:bg-[#EEE7F2]/40 text-xs font-semibold text-[#3E293F] shadow-xs transition-all duration-200">
                    <span>Riwayat laporan</span>
                    <svg class="w-4 h-4 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- 4. LAYOUT 2 KOLOM --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- FORM UTAMA (KOLOM KIRI ~ 8 cols / 2/3) --}}
            <div class="lg:col-span-8 bg-white rounded-3xl border border-[#DCD5DD] p-6 sm:p-10 shadow-sm" x-data="{ submitting: false }">
                
                @if($errors->any())
                    <div class="mb-8 bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs">
                        <p class="font-bold mb-1">Ada beberapa hal yang perlu kamu lengkapi:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pelaporan.store') }}" enctype="multipart/form-data" @submit="submitting = true" class="space-y-8">
                    @csrf

                    {{-- SECTION 01: Identitas / Cara Melapor --}}
                    <x-pelaporan.form-identitas />

                    <div class="border-t border-[#DCD5DD]/60"></div>

                    {{-- SECTION 02: Kronologi Kejadian --}}
                    <x-pelaporan.form-kronologi />

                    <div class="border-t border-[#DCD5DD]/60"></div>

                    {{-- SECTION 03: Bukti --}}
                    <x-pelaporan.form-bukti />

                    <div class="border-t border-[#DCD5DD]/60"></div>

                    {{-- INFO BOX --}}
                    <div class="bg-[#EEE7F2]/60 border border-[#DCD5DD] rounded-2xl p-5 flex items-start gap-3.5">
                        <div class="w-6 h-6 rounded-xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center flex-shrink-0 mt-0.5 shadow-inner">
                            <svg class="w-4 h-4 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-[#3E293F] leading-snug">Apa yang terjadi setelah kamu mengirim?</h4>
                            <p class="text-xs text-[#746B77] mt-1 leading-relaxed">
                                Kode pelacakan unik akan dibuat setelah laporan dikirim. Kamu dapat melihat kode dan memantau pembaruan status melalui Riwayat laporan.
                            </p>
                        </div>
                    </div>

                    {{-- FOOTER AKSI --}}
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-[#746B77] hover:text-[#3E293F] transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali ke beranda</span>
                        </a>

                        <button 
                            type="submit" 
                            :disabled="submitting"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-[#643B62] hover:bg-[#3E293F] text-white text-xs sm:text-sm font-semibold shadow-sm transition-all duration-200 active:scale-[0.98] disabled:opacity-75 disabled:cursor-not-allowed">
                            <span x-show="!submitting">Kirim laporan &rarr;</span>
                            <span x-show="submitting" class="inline-flex items-center gap-2" style="display: none;">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Mengirim laporan...</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- SIDEBAR (KOLOM KANAN ~ 4 cols / 1/3, STICKY top-24) --}}
            <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
                {{-- Card 1: Tips & Tenang --}}
                <x-pelaporan.sidebar-tips />

                {{-- Card 2: Tentang Anonim --}}
                <x-pelaporan.sidebar-anonim />

                {{-- Card 3: Pantau Langkahmu --}}
                <x-pelaporan.sidebar-riwayat />

                {{-- Disclaimer di bawah sidebar cards --}}
                <div class="px-1 pt-1 flex items-start gap-2.5 text-xs text-[#746B77] leading-relaxed">
                    <svg class="w-4 h-4 text-[#746B77] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-[11px] text-[#746B77]">
                        Ruang Puan memfasilitasi pelaporan dan pemantauan, bukan penanganan kasus langsung. Jika kamu berada dalam bahaya langsung, hubungi layanan darurat atau lembaga bantuan setempat.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection