@extends('layouts.konselor')

@section('konselor-content')
<div x-data="{
    activeFilter: '6bulan',
    chatModalOpen: {{ request('modal') === 'chat' ? 'true' : 'false' }},
    detailModalOpen: false,
    tinjauModalOpen: false,
    semuaBookingModalOpen: {{ request('tab') === 'booking' ? 'true' : 'false' }},
    selectedBooking: {
        id: 1,
        klien: 'bungapagi',
        diajukan: 'Diajukan 20 menit lalu',
        jadwal: 'Sabtu, 24 Okt · 10.00–11.00 WIB',
        layanan: 'Chat · 60 menit',
        keluhan: 'Kecemasan menghadapi lingkungan kantor baru dan kendala komunikasi asertif.',
        tarif: 'Rp 150.000'
    },
    selectedSesi: {
        klien: 'yudahenry',
        hari_tanggal: 'Jumat, 23 Oktober 2026',
        waktu: '15.00–16.00 WIB',
        durasi: '60 menit',
        metode: 'Sesi melalui chat',
        status_pembayaran: 'Pembayaran dikonfirmasi',
        topik: 'Konsultasi lanjutan: Manajemen stres, regulasi emosi & pemulihan burnout.'
    },
    chatMessages: [
        { id: 1, sender: 'konselor', text: 'Halo yudahenry, selamat sore. Bagaimana kabarmu hari ini?', time: '15:00' },
        { id: 2, sender: 'klien', text: 'Selamat sore Bu Dewi. Hari ini agak overwhelmed dengan deadline kantor, jadi ingin mendiskusikan teknik relaksasi yang sempat kita bahas kemarin.', time: '15:02' },
        { id: 3, sender: 'konselor', text: 'Terima kasih sudah meluangkan waktu untuk hadir. Tarik napas perlahan dulu, kita akan urai satu per satu dari beban yang paling terasa berat ya.', time: '15:03' }
    ],
    newChatMessage: '',
    sendChatMessage() {
        if (!this.newChatMessage.trim()) return;
        const now = new Date();
        const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        this.chatMessages.push({
            id: Date.now(),
            sender: 'konselor',
            text: this.newChatMessage,
            time: timeStr
        });
        this.newChatMessage = '';
        this.$nextTick(() => {
            const container = document.getElementById('chat-scroll-area');
            if (container) container.scrollTop = container.scrollHeight;
        });

        setTimeout(() => {
            this.chatMessages.push({
                id: Date.now() + 1,
                sender: 'klien',
                text: 'Baik Bu, saya sangat menghargai bimbingannya.',
                time: timeStr
            });
            this.$nextTick(() => {
                const container = document.getElementById('chat-scroll-area');
                if (container) container.scrollTop = container.scrollHeight;
            });
        }, 1200);
    },
    openTinjau(booking) {
        this.selectedBooking = booking;
        this.tinjauModalOpen = true;
    },
    openDetailSesi(sesi) {
        this.selectedSesi = sesi;
        this.detailModalOpen = true;
    }
}" class="space-y-8">

    {{-- Alert Notifikasi Sukses --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-[#EAF0E4] border border-[#D0DFC6] text-[#2F4F32] text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-2">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-xs text-[#2F4F32] hover:underline">Tutup</button>
        </div>
    @endif

    {{-- 1. HEADER SECTION (Greeting & Verification Pill) --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 pt-2">
        <div>
            <span class="text-[11px] font-semibold tracking-widest uppercase text-sage-600 block mb-1">
                SELAMAT DATANG KEMBALI
            </span>
            <h1 class="font-fraunces font-bold text-3xl sm:text-4xl text-sage-900 tracking-tight leading-tight">
                Halo, {{ $greetingName ?? 'Bu Dewi' }}.
            </h1>
            <p class="text-xs sm:text-sm text-ink-600 mt-1">
                Ini ringkasan sesi dan permintaan hari ini.
            </p>
        </div>

        <div class="self-start sm:self-auto">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-[#EAF0E4] text-[#2F4F32] border border-[#D5E2CC] text-xs font-semibold shadow-xs">
                <svg class="w-3.5 h-3.5 text-[#2F4F32]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="9 12 11 14 15 10"></polyline>
                </svg>
                <span>Terverifikasi</span>
            </div>
        </div>
    </div>

    {{-- 2. 4 METRIC STAT CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Card 1: Sesi Hari Ini -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)] transition hover:shadow-md flex flex-col justify-between min-h-[125px]">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-semibold text-3xl sm:text-4xl text-ink-900 tracking-tight block leading-none">
                        {{ $stats['sesi_hari_ini'] ?? 2 }}
                    </span>
                    <span class="text-xs text-ink-500 mt-2 block font-normal">
                        Sesi hari ini
                    </span>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#F0F3EB] text-sage-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="16" y1="2" x2="16" y2="6" stroke-width="1.8" stroke-linecap="round"/>
                        <line x1="8" y1="2" x2="8" y2="6" stroke-width="1.8" stroke-linecap="round"/>
                        <line x1="3" y1="10" x2="21" y2="10" stroke-width="1.8"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Booking Menunggu -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)] transition hover:shadow-md flex flex-col justify-between min-h-[125px]">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-semibold text-3xl sm:text-4xl text-ink-900 tracking-tight block leading-none">
                        {{ $stats['booking_menunggu'] ?? 3 }}
                    </span>
                    <span class="text-xs text-ink-500 mt-2 block font-normal">
                        Booking menunggu
                    </span>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#F0F3EB] text-sage-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="1.8"/>
                        <polyline points="12 6 12 12 16 14" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Sesi Selesai Bulan Ini -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)] transition hover:shadow-md flex flex-col justify-between min-h-[125px]">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-semibold text-3xl sm:text-4xl text-ink-900 tracking-tight block leading-none">
                        {{ $stats['sesi_selesai_bulan_ini'] ?? 18 }}
                    </span>
                    <span class="text-xs text-ink-500 mt-2 block font-normal">
                        Sesi selesai bulan ini
                    </span>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#F0F3EB] text-sage-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Sesi -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)] transition hover:shadow-md flex flex-col justify-between min-h-[125px]">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-semibold text-3xl sm:text-4xl text-ink-900 tracking-tight block leading-none">
                        {{ $stats['total_sesi'] ?? 64 }}
                    </span>
                    <span class="text-xs text-ink-500 mt-2 block font-normal">
                        Total sesi
                    </span>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#F0F3EB] text-sage-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- 3. MAIN CONTENT: 2 COLUMNS (Left: Sesi Berikutnya & Jadwal Hari Ini | Right: Booking Menunggu) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- LEFT COLUMN: Sesi Berikutnya & Jadwal Hari Ini -->
        <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
            
            <!-- Card: Sesi Berikutnya -->
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)] transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <h2 class="font-fraunces font-bold text-xl text-ink-900">
                        Sesi berikutnya
                    </h2>
                    <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-[#EAF0E4] text-[#2F4F32] border border-[#D5E2CC] text-xs font-semibold">
                        <svg class="w-3.5 h-3.5 text-[#2F4F32]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="9 12 11 14 15 10"></polyline>
                        </svg>
                        <span>{{ $sesiBerikutnya['status_pembayaran'] ?? 'Pembayaran dikonfirmasi' }}</span>
                    </div>
                </div>

                <div class="mt-6 flex items-start space-x-4 sm:space-x-5">
                    <!-- Date badge -->
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-[#E8EDE0] border border-[#DCE4D4] rounded-2xl flex flex-col items-center justify-center flex-shrink-0 shadow-inner">
                        <span class="text-[10px] sm:text-xs font-bold text-sage-700 uppercase tracking-widest leading-none">
                            {{ $sesiBerikutnya['tanggal_badge']['bulan'] ?? 'OKT' }}
                        </span>
                        <span class="text-2xl sm:text-3xl font-bold text-sage-900 leading-none mt-1">
                            {{ $sesiBerikutnya['tanggal_badge']['hari'] ?? '23' }}
                        </span>
                    </div>

                    <!-- Client & Session Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-base sm:text-lg text-ink-900 truncate">
                            {{ $sesiBerikutnya['klien'] ?? 'yudahenry' }}
                        </h3>
                        <p class="text-xs text-ink-500 mt-1 font-normal">
                            {{ $sesiBerikutnya['hari_tanggal'] ?? 'Jumat, 23 Oktober 2026' }} · {{ $sesiBerikutnya['waktu'] ?? '15.00–16.00 WIB' }}
                        </p>
                        <div class="flex items-center space-x-1.5 text-xs text-ink-600 mt-2">
                            <svg class="w-3.5 h-3.5 text-ink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span>{{ $sesiBerikutnya['metode'] ?? 'Sesi melalui chat' }} · {{ $sesiBerikutnya['durasi'] ?? '60 menit' }}</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-cream-200/80 my-5"></div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <button type="button" @click="chatModalOpen = true" 
                            class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-full bg-sage-900 hover:bg-[#1E2B21] text-white text-xs font-semibold shadow-sm transition active:scale-[0.98] cursor-pointer">
                        <span>Masuk ke chat</span>
                        <span>&rarr;</span>
                    </button>
                    
                    <button type="button" @click="openDetailSesi({{ json_encode($sesiBerikutnya) }})"
                            class="inline-flex items-center px-5 py-2.5 rounded-full bg-white hover:bg-cream-100 text-ink-700 border border-cream-300 text-xs font-semibold transition active:scale-[0.98] cursor-pointer">
                        Lihat detail
                    </button>
                </div>
            </div>

            <!-- Card: Jadwal Hari Ini -->
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)] transition hover:shadow-md">
                <div class="flex items-center justify-between pb-4">
                    <div>
                        <h2 class="font-fraunces font-bold text-xl text-ink-900">
                            Jadwal hari ini
                        </h2>
                        <p class="text-xs text-ink-500 mt-0.5">
                            Jumat, 23 Oktober 2026 · {{ count($jadwalHariIni) }} sesi
                        </p>
                    </div>

                    <a href="{{ route('konselor.jadwal') }}" class="inline-flex items-center space-x-1 text-xs font-semibold text-ink-800 hover:text-sage-700 transition">
                        <span>Lihat jadwal</span>
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                </div>

                <!-- Schedule List -->
                <div class="space-y-4 pt-2">
                    @foreach($jadwalHariIni as $jadwal)
                        <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl hover:bg-cream-50/70 transition border border-transparent hover:border-cream-200/60 cursor-pointer"
                             @click="openDetailSesi({ klien: '{{ $jadwal['klien'] }}', waktu: '{{ $jadwal['jam'] }} {{ $jadwal['durasi'] }}', metode: '{{ $jadwal['layanan'] }}', status_pembayaran: 'Terkonfirmasi', hari_tanggal: 'Jumat, 23 Oktober 2026' })">
                            
                            <!-- Left: Time -->
                            <div class="w-24 sm:w-28 flex-shrink-0">
                                <span class="font-bold text-sm text-ink-900 block leading-tight">
                                    {{ $jadwal['jam'] }}
                                </span>
                                <span class="text-[11px] text-ink-400 block mt-0.5">
                                    {{ $jadwal['durasi'] }}
                                </span>
                            </div>

                            <!-- Vertical Line Indicator -->
                            <div class="w-1 {{ $jadwal['is_next'] ? 'bg-sage-900' : 'bg-cream-300' }} self-stretch rounded-full mx-3 sm:mx-5 flex-shrink-0"></div>

                            <!-- Middle: Client & Type -->
                            <div class="flex-1 min-w-0">
                                <span class="font-bold text-sm text-ink-900 block truncate leading-tight">
                                    {{ $jadwal['klien'] }}
                                </span>
                                <span class="text-xs text-ink-500 block mt-0.5 truncate">
                                    {{ $jadwal['layanan'] }}
                                </span>
                            </div>

                            <!-- Right: Status Badge -->
                            <div class="ml-3 flex-shrink-0">
                                @if($jadwal['is_next'])
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-[#EAF0E4] text-[#2F4F32] border border-[#D5E2CC]">
                                        {{ $jadwal['status'] }}
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-cream-100 text-ink-600 border border-cream-200">
                                        {{ $jadwal['status'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: Booking Menunggu -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)] transition hover:shadow-md flex flex-col justify-between h-full">
                
                <div>
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <h2 class="font-fraunces font-bold text-xl text-ink-900">
                                Booking menunggu
                            </h2>
                            <span class="w-6 h-6 rounded-full bg-[#EAF0E4] text-xs font-bold text-sage-800 flex items-center justify-center">
                                {{ count($bookingMenunggu) }}
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-ink-500 mt-1 pb-4 border-b border-cream-100">
                        Ada yang menantikan pendampinganmu.
                    </p>

                    <!-- Booking Items -->
                    <div class="divide-y divide-cream-100/80">
                        @foreach($bookingMenunggu as $booking)
                            <div class="py-4 first:pt-4 last:pb-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-sm text-ink-900">
                                        {{ $booking['klien'] }}
                                    </span>
                                    <span class="text-[11px] text-ink-400">
                                        {{ $booking['diajukan'] }}
                                    </span>
                                </div>

                                <div class="mt-1 flex items-center space-x-1.5 text-xs text-ink-600">
                                    <svg class="w-3.5 h-3.5 text-ink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <line x1="16" y1="2" x2="16" y2="6" stroke-width="1.8" stroke-linecap="round"/>
                                        <line x1="8" y1="2" x2="8" y2="6" stroke-width="1.8" stroke-linecap="round"/>
                                        <line x1="3" y1="10" x2="21" y2="10" stroke-width="1.8"/>
                                    </svg>
                                    <span>{{ $booking['jadwal'] }}</span>
                                </div>

                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-ink-500">
                                        {{ $booking['layanan'] }}
                                    </span>
                                    <button type="button" @click="openTinjau({{ json_encode($booking) }})"
                                            class="inline-flex items-center space-x-1 text-xs font-semibold text-ink-900 hover:text-sage-700 transition cursor-pointer">
                                        <span>Tinjau</span>
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="7" y1="17" x2="17" y2="7"></line>
                                            <polyline points="7 7 17 7 17 17"></polyline>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Card Footer Link -->
                <div class="pt-5 mt-4 border-t border-cream-100 text-center">
                    <button type="button" @click="semuaBookingModalOpen = true"
                            class="inline-flex items-center space-x-1 text-xs font-semibold text-ink-800 hover:text-sage-900 transition cursor-pointer">
                        <span>Lihat semua booking</span>
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

    </div>

    {{-- 4. BOTTOM SECTION: PERFORMA KAMU (ANALYTICS & CHARTS) --}}
    <div class="mt-10">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-4">
            <div>
                <span class="text-[11px] font-semibold tracking-widest uppercase text-sage-600 block mb-1">
                    ANALISIS
                </span>
                <h2 class="font-fraunces font-bold text-2xl sm:text-3xl text-sage-900 tracking-tight leading-tight">
                    Performa kamu
                </h2>
                <p class="text-xs sm:text-sm text-ink-600 mt-1">
                    Pantau pola sesi, hari tersibuk, dan penggunaan slot untuk meningkatkan kualitas pendampingan.
                </p>
            </div>

            <!-- 6 bulan | 3 bulan Toggle Pill (Interactive Alpine.js) -->
            <div class="inline-flex items-center bg-[#EAF0E4] p-1 rounded-full text-xs font-medium border border-[#D5E2CC] self-start sm:self-auto">
                <button type="button" 
                        @click="activeFilter = '6bulan'" 
                        :class="activeFilter === '6bulan' ? 'bg-white text-ink-900 font-semibold shadow-xs' : 'text-ink-600 hover:text-ink-900'"
                        class="px-4 py-1.5 rounded-full transition-all duration-200 cursor-pointer">
                    6 bulan
                </button>
                <span class="text-ink-400 px-1">|</span>
                <button type="button" 
                        @click="activeFilter = '3bulan'" 
                        :class="activeFilter === '3bulan' ? 'bg-white text-ink-900 font-semibold shadow-xs' : 'text-ink-600 hover:text-ink-900'"
                        class="px-4 py-1.5 rounded-full transition-all duration-200 cursor-pointer">
                    3 bulan
                </button>
            </div>
        </div>

        <!-- Analytics Card Container with 3 Columns -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-cream-200 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 divide-y md:divide-y-0 md:divide-x divide-cream-200/80">
                
                <!-- Col 1: Sesi per bulan -->
                <div class="flex flex-col justify-between pt-4 md:pt-0">
                    <div>
                        <h3 class="font-fraunces font-semibold text-base text-ink-900 mb-6">
                            Sesi per bulan
                        </h3>

                        <!-- 6 Bulan View -->
                        <div x-show="activeFilter === '6bulan'" x-transition class="h-44 flex items-end justify-between px-2 pt-6 pb-2 border-b border-cream-200 relative">
                            @foreach($performaData['sesi_per_bulan_6'] as $item)
                                @php
                                    $heightPercent = round(($item['jumlah'] / 18) * 100);
                                @endphp
                                <div class="flex flex-col items-center flex-1 mx-1 group relative">
                                    <!-- Tooltip / Label for Active Bar (Okt: 18 sesi) -->
                                    @if(!empty($item['tooltip']))
                                        <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-sage-900 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full whitespace-nowrap shadow-xs z-10">
                                            {{ $item['tooltip'] }}
                                        </div>
                                    @else
                                        <span class="text-[10px] text-ink-600 font-semibold mb-1 group-hover:text-sage-900 transition">
                                            {{ $item['jumlah'] }}
                                        </span>
                                    @endif

                                    <!-- Bar -->
                                    <div class="w-full max-w-[28px] rounded-t-md transition-all duration-300 {{ $item['is_active'] ? 'bg-sage-900 shadow-sm' : 'bg-[#D6DFC9] hover:bg-sage-300' }}"
                                         style="height: {{ $heightPercent }}%;">
                                    </div>
                                    
                                    <!-- Month Label -->
                                    <span class="text-[11px] font-medium text-ink-500 mt-2">
                                        {{ $item['bulan'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <!-- 3 Bulan View -->
                        <div x-show="activeFilter === '3bulan'" x-transition class="h-44 flex items-end justify-around px-4 pt-6 pb-2 border-b border-cream-200 relative" style="display: none;">
                            @foreach($performaData['sesi_per_bulan_3'] as $item)
                                @php
                                    $heightPercent = round(($item['jumlah'] / 18) * 100);
                                @endphp
                                <div class="flex flex-col items-center w-16 group relative">
                                    @if(!empty($item['tooltip']))
                                        <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-sage-900 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full whitespace-nowrap shadow-xs z-10">
                                            {{ $item['tooltip'] }}
                                        </div>
                                    @else
                                        <span class="text-[10px] text-ink-600 font-semibold mb-1 group-hover:text-sage-900 transition">
                                            {{ $item['jumlah'] }}
                                        </span>
                                    @endif

                                    <div class="w-full max-w-[32px] rounded-t-md transition-all duration-300 {{ $item['is_active'] ? 'bg-sage-900 shadow-sm' : 'bg-[#D6DFC9] hover:bg-sage-300' }}"
                                         style="height: {{ $heightPercent }}%;">
                                    </div>
                                    <span class="text-[11px] font-medium text-ink-500 mt-2">
                                        {{ $item['bulan'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <p class="text-xs text-ink-500 mt-5 pt-1">
                        Sesi naik 12,5% dibanding bulan lalu.
                    </p>
                </div>

                <!-- Col 2: Hari tersibuk -->
                <div class="flex flex-col justify-between pt-6 md:pt-0 md:pl-8">
                    <div>
                        <h3 class="font-fraunces font-semibold text-base text-ink-900 mb-6">
                            Hari tersibuk
                        </h3>

                        <div class="h-44 flex items-end justify-between px-1 pt-6 pb-2 border-b border-cream-200 relative">
                            @foreach($performaData['hari_tersibuk'] as $item)
                                @php
                                    $heightPercent = round(($item['jumlah'] / 8) * 100);
                                @endphp
                                <div class="flex flex-col items-center flex-1 mx-1 group relative">
                                    <span class="text-[10px] font-semibold {{ $item['is_active'] ? 'text-sage-900' : 'text-ink-500' }} mb-1">
                                        {{ $item['jumlah'] }}
                                    </span>

                                    <!-- Bar -->
                                    <div class="w-full max-w-[24px] rounded-t-md transition-all duration-300 {{ $item['is_active'] ? 'bg-sage-900 shadow-sm' : 'bg-[#D6DFC9] hover:bg-sage-300' }}"
                                         style="height: {{ $heightPercent }}%;">
                                    </div>

                                    <!-- Day Label -->
                                    <span class="text-[11px] font-medium text-ink-500 mt-2">
                                        {{ $item['hari'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <p class="text-xs text-ink-500 mt-5 pt-1">
                        Jumat paling padat dengan 8 sesi.
                    </p>
                </div>

                <!-- Col 3: Slot terisi -->
                <div class="flex flex-col justify-between pt-6 md:pt-0 md:pl-8">
                    <div>
                        <h3 class="font-fraunces font-semibold text-base text-ink-900 mb-6">
                            Slot terisi
                        </h3>

                        <div class="space-y-4 pt-1">
                            @foreach($performaData['slot_terisi'] as $slot)
                                <div>
                                    <div class="flex items-center justify-between text-xs mb-1.5">
                                        <span class="text-ink-700 font-medium">{{ $slot['minggu'] }}</span>
                                        <span class="text-ink-900 font-bold">{{ $slot['persentase'] }}%</span>
                                    </div>
                                    <div class="w-full bg-[#EAF0E4] h-2.5 rounded-full overflow-hidden">
                                        <div class="bg-sage-900 h-full rounded-full transition-all duration-500" 
                                             style="width: {{ $slot['persentase'] }}%;">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <p class="text-xs text-ink-500 mt-5 pt-1">
                        Minggu 4 mencapai 85% slot terisi.
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL 1: CHAT KONSULTASI AKTIF DENGAN KLIEN (yudahenry) --}}
    {{-- ========================================================================= --}}
    <div x-show="chatModalOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-ink-900/40 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
         style="display: none;">
        
        <div @click.away="chatModalOpen = false" 
             class="bg-white rounded-3xl shadow-2xl border border-cream-200 w-full max-w-2xl overflow-hidden flex flex-col h-[600px] max-h-[90vh]">
            
            <!-- Chat Header -->
            <div class="px-6 py-4 bg-[#FAFBF7] border-b border-cream-200 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-[#E5EADF] text-sage-900 font-bold flex items-center justify-center text-sm shadow-inner">
                        Y
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="font-bold text-sm sm:text-base text-ink-900">yudahenry</h3>
                            <span class="w-2 h-2 rounded-full bg-success-600"></span>
                            <span class="text-[11px] text-success-600 font-semibold">Aktif</span>
                        </div>
                        <p class="text-[11px] text-ink-500">Konsultasi Chat · Sesi 60 menit (Jumat, 23 Okt 15.00 WIB)</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="button" @click="chatModalOpen = false" class="p-2 text-ink-400 hover:text-ink-700 rounded-full hover:bg-cream-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Chat Messages Scroll Area -->
            <div id="chat-scroll-area" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-4 bg-cream-50/40">
                <div class="text-center my-2">
                    <span class="px-3 py-1 bg-cream-100 text-ink-500 rounded-full text-[10px] font-medium">
                        Sesi konsultasi dimulai hari ini pukul 15.00 WIB
                    </span>
                </div>

                <template x-for="msg in chatMessages" :key="msg.id">
                    <div :class="msg.sender === 'konselor' ? 'flex justify-end' : 'flex justify-start'">
                        <div :class="msg.sender === 'konselor' ? 'bg-sage-900 text-white rounded-2xl rounded-tr-xs' : 'bg-white text-ink-900 rounded-2xl rounded-tl-xs border border-cream-200'"
                             class="max-w-[80%] p-3.5 shadow-xs text-xs sm:text-sm">
                            <p x-text="msg.text" class="leading-relaxed"></p>
                            <span :class="msg.sender === 'konselor' ? 'text-sage-200' : 'text-ink-400'"
                                  x-text="msg.time" class="block text-[10px] text-right mt-1.5"></span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Quick Template Responses -->
            <div class="px-4 py-2 bg-white border-t border-cream-100 flex items-center space-x-2 overflow-x-auto text-[11px]">
                <span class="text-ink-400 whitespace-nowrap">Respon cepat:</span>
                <button type="button" @click="newChatMessage = 'Boleh ceritakan apa yang membuatmu paling cemas hari ini?'" class="px-2.5 py-1 bg-[#EAF0E4] hover:bg-[#DCE4D6] text-sage-900 rounded-full whitespace-nowrap transition cursor-pointer">
                    Tanya pemicu cemas
                </button>
                <button type="button" @click="newChatMessage = 'Mari kita lakukan latihan pernapasan 4-7-8 sejenak bersama-sama ya.'" class="px-2.5 py-1 bg-[#EAF0E4] hover:bg-[#DCE4D6] text-sage-900 rounded-full whitespace-nowrap transition cursor-pointer">
                    Latihan pernapasan
                </button>
            </div>

            <!-- Chat Input Area -->
            <form @submit.prevent="sendChatMessage()" class="p-3 sm:p-4 bg-white border-t border-cream-200 flex items-center space-x-2">
                <input type="text" x-model="newChatMessage" 
                       placeholder="Ketik pesan pendampingan untuk yudahenry..." 
                       class="flex-1 bg-cream-50 border border-cream-200 rounded-full px-4 py-2.5 text-xs focus:outline-none focus:border-sage-700 focus:ring-1 focus:ring-sage-700 text-ink-900">
                
                <button type="submit" 
                        class="p-2.5 bg-sage-900 hover:bg-[#1E2B21] text-white rounded-full transition shadow-sm flex items-center justify-center cursor-pointer">
                    <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL 2: DETAIL SESI KONSULTASI --}}
    {{-- ========================================================================= --}}
    <div x-show="detailModalOpen" 
         x-transition 
         class="fixed inset-0 z-50 overflow-y-auto bg-ink-900/40 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
         style="display: none;">
        
        <div @click.away="detailModalOpen = false" 
             class="bg-white rounded-3xl shadow-2xl border border-cream-200 w-full max-w-lg p-6 sm:p-7 space-y-5">
            
            <div class="flex items-center justify-between pb-3 border-b border-cream-100">
                <div>
                    <h3 class="font-fraunces font-bold text-xl text-ink-900">Detail Sesi Konsultasi</h3>
                    <p class="text-xs text-ink-500 mt-0.5">Informasi jadwal dan klien</p>
                </div>
                <button type="button" @click="detailModalOpen = false" class="text-ink-400 hover:text-ink-700 cursor-pointer">
                    ✕
                </button>
            </div>

            <div class="space-y-3.5 text-xs">
                <div class="bg-cream-50 p-4 rounded-2xl space-y-2">
                    <div class="flex justify-between">
                        <span class="text-ink-500">Nama / Alias Klien:</span>
                        <span class="font-bold text-ink-900" x-text="selectedSesi.klien"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-500">Jadwal Sesi:</span>
                        <span class="font-semibold text-ink-900" x-text="(selectedSesi.hari_tanggal || '') + ' · ' + (selectedSesi.waktu || '')"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-500">Metode & Durasi:</span>
                        <span class="font-medium text-ink-900" x-text="(selectedSesi.metode || 'Konsultasi Chat') + ' · 60 Menit'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-500">Status Pembayaran:</span>
                        <span class="px-2 py-0.5 bg-[#EAF0E4] text-[#2F4F32] rounded-full font-semibold" x-text="selectedSesi.status_pembayaran || 'Terkonfirmasi'"></span>
                    </div>
                </div>

                <div>
                    <span class="font-semibold text-ink-800 block mb-1">Catatan & Topik Sesi:</span>
                    <p class="text-ink-600 bg-white border border-cream-200 p-3 rounded-xl leading-relaxed" 
                       x-text="selectedSesi.topik || 'Konsultasi lanjutan terkait kecemasan dan manajemen stres kerja.'"></p>
                </div>
            </div>

            <div class="pt-2 flex items-center justify-end space-x-3">
                <button type="button" @click="detailModalOpen = false" 
                        class="px-4 py-2 rounded-full border border-cream-300 text-xs font-semibold text-ink-700 hover:bg-cream-100 cursor-pointer">
                    Tutup
                </button>
                <button type="button" @click="detailModalOpen = false; chatModalOpen = true" 
                        class="px-5 py-2 rounded-full bg-sage-900 hover:bg-[#1E2B21] text-white text-xs font-semibold shadow-xs cursor-pointer">
                    Masuk ke Ruang Chat &rarr;
                </button>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL 3: TINJAU BOOKING MENUNGGU --}}
    {{-- ========================================================================= --}}
    <div x-show="tinjauModalOpen" 
         x-transition 
         class="fixed inset-0 z-50 overflow-y-auto bg-ink-900/40 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
         style="display: none;">
        
        <div @click.away="tinjauModalOpen = false" 
             class="bg-white rounded-3xl shadow-2xl border border-cream-200 w-full max-w-lg p-6 sm:p-7 space-y-5">
            
            <div class="flex items-center justify-between pb-3 border-b border-cream-100">
                <div>
                    <h3 class="font-fraunces font-bold text-xl text-ink-900">Tinjau Permintaan Booking</h3>
                    <p class="text-xs text-ink-500 mt-0.5" x-text="'Pengajuan dari ' + selectedBooking.klien"></p>
                </div>
                <button type="button" @click="tinjauModalOpen = false" class="text-ink-400 hover:text-ink-700 cursor-pointer">
                    ✕
                </button>
            </div>

            <div class="space-y-4 text-xs">
                <div class="bg-cream-50 p-4 rounded-2xl space-y-2">
                    <div class="flex justify-between">
                        <span class="text-ink-500">Klien:</span>
                        <span class="font-bold text-ink-900" x-text="selectedBooking.klien"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-500">Waktu Diajukan:</span>
                        <span class="font-medium text-ink-700" x-text="selectedBooking.diajukan"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-500">Slot yang Dipilih:</span>
                        <span class="font-bold text-sage-900" x-text="selectedBooking.jadwal"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-500">Jenis Layanan:</span>
                        <span class="font-medium text-ink-700" x-text="selectedBooking.layanan"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-500">Tarif Sesi:</span>
                        <span class="font-semibold text-ink-900" x-text="selectedBooking.tarif || 'Rp 150.000'"></span>
                    </div>
                </div>

                <div>
                    <span class="font-semibold text-ink-800 block mb-1">Keluhan / Catatan Awal Klien:</span>
                    <p class="text-ink-600 bg-white border border-cream-200 p-3 rounded-xl leading-relaxed" 
                       x-text="selectedBooking.keluhan || 'Klien membutuhkan ruang aman untuk mendiskusikan tekanan emosional.'"></p>
                </div>
            </div>

            <div class="pt-3 border-t border-cream-100 flex items-center justify-between">
                <form method="POST" :action="'{{ url('/konselor/booking') }}/' + selectedBooking.id + '/tolak'">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 rounded-full border border-danger-200 text-danger-600 hover:bg-danger-50 text-xs font-semibold transition cursor-pointer">
                        Tolak
                    </button>
                </form>

                <div class="flex items-center space-x-2">
                    <button type="button" @click="tinjauModalOpen = false" 
                            class="px-4 py-2 rounded-full border border-cream-300 text-xs font-semibold text-ink-700 hover:bg-cream-100 cursor-pointer">
                        Nanti
                    </button>
                    <form method="POST" :action="'{{ url('/konselor/booking') }}/' + selectedBooking.id + '/konfirmasi'">
                        @csrf
                        <button type="submit" 
                                class="px-5 py-2 rounded-full bg-sage-900 hover:bg-[#1E2B21] text-white text-xs font-semibold shadow-xs transition cursor-pointer">
                            ✓ Konfirmasi Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL 4: SEMUA DAFTAR BOOKING MASUK --}}
    {{-- ========================================================================= --}}
    <div x-show="semuaBookingModalOpen" 
         x-transition 
         class="fixed inset-0 z-50 overflow-y-auto bg-ink-900/40 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
         style="display: none;">
        
        <div @click.away="semuaBookingModalOpen = false" 
             class="bg-white rounded-3xl shadow-2xl border border-cream-200 w-full max-w-2xl p-6 sm:p-7 space-y-5 max-h-[85vh] flex flex-col">
            
            <div class="flex items-center justify-between pb-3 border-b border-cream-100">
                <div>
                    <h3 class="font-fraunces font-bold text-xl text-ink-900">Daftar Permintaan Booking Masuk</h3>
                    <p class="text-xs text-ink-500 mt-0.5">Kelola seluruh permohonan sesi konsultasi dari pengguna</p>
                </div>
                <button type="button" @click="semuaBookingModalOpen = false" class="text-ink-400 hover:text-ink-700 cursor-pointer">
                    ✕
                </button>
            </div>

            <div class="flex-1 overflow-y-auto divide-y divide-cream-100 pr-1 space-y-2">
                @foreach($bookingMenunggu as $b)
                    <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-sm text-ink-900">{{ $b['klien'] }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#EAF0E4] text-[#2F4F32]">Menunggu Persetujuan</span>
                            </div>
                            <p class="text-xs text-ink-500 mt-1">{{ $b['jadwal'] }} · {{ $b['layanan'] }}</p>
                            <p class="text-[11px] text-ink-400 italic mt-0.5">{{ $b['diajukan'] }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" @click="semuaBookingModalOpen = false; openTinjau({{ json_encode($b) }})"
                                    class="px-4 py-1.5 rounded-full bg-sage-900 text-white text-xs font-semibold hover:bg-[#1E2B21] transition shadow-xs cursor-pointer">
                                Tinjau Permintaan &rarr;
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-3 border-t border-cream-100 text-right">
                <button type="button" @click="semuaBookingModalOpen = false" 
                        class="px-5 py-2 rounded-full border border-cream-300 text-xs font-semibold text-ink-700 hover:bg-cream-100 cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
