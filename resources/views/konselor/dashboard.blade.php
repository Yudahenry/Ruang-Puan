@extends('layouts.konselor')

@section('konselor-content')
<div class="space-y-8 max-w-7xl mx-auto py-6">

    <!-- 1. GREETING & VERIFICATION BADGE -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#746B77] block mb-1">Selamat Datang Kembali</span>
            <h1 class="text-3xl font-serif font-bold text-[#3E293F]">Halo, {{ auth()->user()->nama ?? 'Bu Dewi' }}.</h1>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1">Ini ringkasan sesi dan permintaan hari ini.</p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-2xs">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Terverifikasi
            </span>
        </div>
    </div>

    <!-- 2. STAT CARDS (4 KARTU RINGKASAN) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">2</span>
                <p class="text-xs text-[#746B77] mt-1">Sesi hari ini</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                📅
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">3</span>
                <p class="text-xs text-[#746B77] mt-1">Booking menunggu</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                ⏰
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">18</span>
                <p class="text-xs text-[#746B77] mt-1">Sesi selesai bulan ini</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                ✓
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-3xl p-6 border border-[#DCD5DD] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-3xl font-serif font-bold text-[#3E293F]">64</span>
                <p class="text-xs text-[#746B77] mt-1">Total sesi</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center shadow-inner">
                💬
            </div>
        </div>
    </div>

    <!-- 3. MAIN GRID (KOLOM UTAMA & SIDEBAR BOOKING) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI (Span 2) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Sesi Berikutnya -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-serif font-bold text-[#3E293F]">Sesi berikutnya</h2>
                    <span class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        Pembayaran dikonfirmasi
                    </span>
                </div>
                
                @php $next = $nextSesi ?? ['tanggal' => 'Jumat, 23 Oktober 2026', 'waktu' => '15.00–16.00 WIB', 'nama_klien' => 'yudahenry', 'durasi' => '60 menit', 'chat_url' => '#']; @endphp
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-[#DCD5DD]/60">
                    <div class="flex items-start sm:items-center space-x-4">
                        <div class="w-16 h-16 rounded-2xl bg-[#EEE7F2] border border-[#DCD5DD] flex flex-col items-center justify-center text-[#643B62] font-bold shadow-inner flex-shrink-0">
                            <span class="text-[10px] uppercase tracking-widest text-[#746B77]">OKT</span>
                            <span class="text-xl font-serif">23</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-serif font-bold text-[#3E293F]">{{ data_get($next, 'nama_klien') }}</h3>
                            <p class="text-xs text-[#746B77] mt-1">{{ data_get($next, 'tanggal') }} • {{ data_get($next, 'waktu') }}</p>
                            <p class="text-xs text-[#643B62] font-medium mt-1">💬 Sesi melalui chat • {{ data_get($next, 'durasi') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <a href="{{ data_get($next, 'chat_url') }}" class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white rounded-2xl text-xs sm:text-sm font-semibold shadow-sm transition">
                        Masuk ke chat &rarr;
                    </a>
                    <a href="#" class="px-6 py-3 bg-[#FCFAF8] hover:bg-[#EEE7F2] text-[#3E293F] border border-[#DCD5DD] rounded-2xl text-xs sm:text-sm font-semibold transition">
                        Lihat detail
                    </a>
                </div>
            </div>

            <!-- Jadwal Hari Ini -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-serif font-bold text-[#3E293F]">Jadwal hari ini</h2>
                        <p class="text-xs text-[#746B77] mt-0.5">Jumat, 23 Oktober 2026 • 2 sesi</p>
                    </div>
                    <a href="{{ route('konselor.jadwal') }}" class="text-xs font-bold text-[#643B62] hover:underline flex items-center gap-1">
                        Lihat jadwal &nearr;
                    </a>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD]">
                        <div>
                            <span class="text-xs font-bold text-[#3E293F] block">15.00–16.00</span>
                            <span class="text-[11px] text-[#746B77]">WIB • 60 menit</span>
                        </div>
                        <div class="flex-1 px-6">
                            <span class="text-sm font-semibold text-[#3E293F] block">yudahenry</span>
                            <span class="text-[11px] text-[#746B77]">Konsultasi melalui chat</span>
                        </div>
                        <span class="px-3.5 py-1 rounded-full text-xs font-semibold bg-[#EEE7F2] text-[#643B62]">
                            Berikutnya
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD]">
                        <div>
                            <span class="text-xs font-bold text-[#3E293F] block">17.00–18.00</span>
                            <span class="text-[11px] text-[#746B77]">WIB • 60 menit</span>
                        </div>
                        <div class="flex-1 px-6">
                            <span class="text-sm font-semibold text-[#3E293F] block">ruangsenja</span>
                            <span class="text-[11px] text-[#746B77]">Konsultasi melalui chat</span>
                        </div>
                        <span class="px-3.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                            Terjadwal
                        </span>
                    </div>
                </div>
            </div>

            <!-- ANALISIS: Performa Kamu -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-[#DCD5DD]/60">
                    <div>
                        <span class="text-[10px] font-bold text-[#746B77] uppercase tracking-widest block mb-1">ANALISIS</span>
                        <h2 class="text-xl font-serif font-bold text-[#3E293F]">Performa kamu</h2>
                        <p class="text-xs text-[#746B77] mt-0.5">Pantau pola sesi, hari tersibuk, dan penggunaan slot untuk meningkatkan kualitas pendampingan.</p>
                    </div>
                    <div class="inline-flex bg-[#EEE7F2]/60 p-1 rounded-full border border-[#DCD5DD]">
                        <button class="px-4 py-1.5 rounded-full text-xs font-bold bg-white text-[#3E293F] shadow-2xs">6 bulan</button>
                        <button class="px-4 py-1.5 rounded-full text-xs font-bold text-[#746B77] hover:text-[#3E293F]">3 bulan</button>
                    </div>
                </div>

                <!-- 3 Visual Analisis Grafik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Grafik 1: Sesi per bulan -->
                    <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD] flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-[#3E293F] mb-1">Sesi per bulan</h3>
                            <div class="bg-[#3E293F] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-md inline-block mb-3">Okt: 18 sesi</div>
                        </div>
                        <div class="h-32 flex items-end justify-between gap-2 pt-4 border-b border-[#DCD5DD]">
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">9</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-14"></div>
                                <span class="text-[10px] text-[#746B77]">Mei</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">12</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-20"></div>
                                <span class="text-[10px] text-[#746B77]">Jun</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">14</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-24"></div>
                                <span class="text-[10px] text-[#746B77]">Jul</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">11</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-18"></div>
                                <span class="text-[10px] text-[#746B77]">Agt</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">16</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-28"></div>
                                <span class="text-[10px] text-[#746B77]">Sep</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] font-bold text-[#3E293F]">18</span>
                                <div class="w-full bg-[#3E293F] rounded-t-lg h-32"></div>
                                <span class="text-[10px] font-bold text-[#3E293F]">Okt</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-[#746B77] mt-3">Sesi naik 12,5% dibanding bulan lalu.</p>
                    </div>

                    <!-- Grafik 2: Hari tersibuk -->
                    <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD] flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-[#3E293F] mb-4">Hari tersibuk</h3>
                        </div>
                        <div class="h-32 flex items-end justify-between gap-1 pt-4 border-b border-[#DCD5DD]">
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">4</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-16"></div>
                                <span class="text-[10px] text-[#746B77]">Sen</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">6</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-22"></div>
                                <span class="text-[10px] text-[#746B77]">Sel</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">3</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-12"></div>
                                <span class="text-[10px] text-[#746B77]">Rab</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">7</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-26"></div>
                                <span class="text-[10px] text-[#746B77]">Kam</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] font-bold text-[#3E293F]">8</span>
                                <div class="w-full bg-[#3E293F] rounded-t-lg h-32"></div>
                                <span class="text-[10px] font-bold text-[#3E293F]">Jum</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">2</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-8"></div>
                                <span class="text-[10px] text-[#746B77]">Sab</span>
                            </div>
                            <div class="w-full flex flex-col items-center gap-1">
                                <span class="text-[10px] text-[#746B77]">1</span>
                                <div class="w-full bg-[#DCD5DD]/70 rounded-t-lg h-4"></div>
                                <span class="text-[10px] text-[#746B77]">Min</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-[#746B77] mt-3">Jumat paling padat dengan 8 sesi.</p>
                    </div>

                    <!-- Grafik 3: Slot terisi -->
                    <div class="bg-[#FCFAF8] p-5 rounded-2xl border border-[#DCD5DD] flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-[#3E293F] mb-4">Slot terisi</h3>
                        </div>
                        <div class="space-y-3.5 my-auto">
                            <div>
                                <div class="flex justify-between text-[11px] font-medium text-[#3E293F] mb-1">
                                    <span>Minggu 1</span>
                                    <span>60%</span>
                                </div>
                                <div class="w-full bg-[#DCD5DD]/50 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-[#3E293F] h-full rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-[11px] font-medium text-[#3E293F] mb-1">
                                    <span>Minggu 2</span>
                                    <span>75%</span>
                                </div>
                                <div class="w-full bg-[#DCD5DD]/50 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-[#3E293F] h-full rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-[11px] font-medium text-[#3E293F] mb-1">
                                    <span>Minggu 3</span>
                                    <span>50%</span>
                                </div>
                                <div class="w-full bg-[#DCD5DD]/50 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-[#3E293F] h-full rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-[11px] font-medium text-[#3E293F] mb-1">
                                    <span>Minggu 4</span>
                                    <span>85%</span>
                                </div>
                                <div class="w-full bg-[#DCD5DD]/50 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-[#3E293F] h-full rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-[11px] text-[#746B77] mt-3">Minggu 4 mencapai 85% slot terisi.</p>
                    </div>

                </div>
            </div>

        </div>

        <!-- 4. SIDEBAR KANAN: BOOKING MENUNGGU (Span 1) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCD5DD] shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-serif font-bold text-[#3E293F]">Booking menunggu</h2>
                    <span class="w-7 h-7 rounded-full bg-[#EEE7F2] text-[#643B62] font-bold text-xs flex items-center justify-center">3</span>
                </div>
                <p class="text-xs text-[#746B77] mb-6">Ada yang menantikan pendampinganmu.</p>

                <div class="space-y-4">
                    <!-- Item 1 -->
                    <div class="p-4 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD] space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#3E293F]">bungapapi</span>
                            <span class="text-[10px] text-[#746B77]">Diajukan 20 menit lalu</span>
                        </div>
                        <div class="text-xs text-[#746B77] space-y-1">
                            <p class="flex items-center gap-1.5">📅 Sabtu, 24 Okt • 10.00–11.00 WIB</p>
                            <p class="flex items-center gap-1.5">💬 Chat • 60 menit</p>
                        </div>
                        <div class="pt-2 flex justify-end">
                            <a href="#" class="text-xs font-bold text-[#643B62] hover:underline flex items-center gap-1">
                                Tinjau &nearr;
                            </a>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="p-4 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD] space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#3E293F]">langitcerah</span>
                            <span class="text-[10px] text-[#746B77]">Diajukan 1 jam lalu</span>
                        </div>
                        <div class="text-xs text-[#746B77] space-y-1">
                            <p class="flex items-center gap-1.5">📅 Sabtu, 24 Okt • 13.00–14.00 WIB</p>
                            <p class="flex items-center gap-1.5">💬 Chat • 60 menit</p>
                        </div>
                        <div class="pt-2 flex justify-end">
                            <a href="#" class="text-xs font-bold text-[#643B62] hover:underline flex items-center gap-1">
                                Tinjau &nearr;
                            </a>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="p-4 rounded-2xl bg-[#FCFAF8] border border-[#DCD5DD] space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#3E293F]">langkahkecil</span>
                            <span class="text-[10px] text-[#746B77]">Diajukan 2 jam lalu</span>
                        </div>
                        <div class="text-xs text-[#746B77] space-y-1">
                            <p class="flex items-center gap-1.5">📅 Minggu, 25 Okt • 09.00–10.00 WIB</p>
                            <p class="flex items-center gap-1.5">💬 Chat • 60 menit</p>
                        </div>
                        <div class="pt-2 flex justify-end">
                            <a href="#" class="text-xs font-bold text-[#643B62] hover:underline flex items-center gap-1">
                                Tinjau &nearr;
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-[#DCD5DD] text-center">
                    <a href="{{ route('konselor.dashboard', ['tab' => 'booking']) }}" class="text-xs font-bold text-[#643B62] hover:underline inline-flex items-center gap-1">
                        Lihat semua booking &nearr;
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection