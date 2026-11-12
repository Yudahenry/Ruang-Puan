@php
    $layout = match(auth()->user()->role) {
        'admin' => 'layouts.admin',
        'konselor' => 'layouts.konselor',
        default => 'layouts.pengguna',
    };
    $section = match(auth()->user()->role) {
        'admin' => 'admin-content',
        'konselor' => 'konselor-content',
        default => 'pengguna-content',
    };
    $isKonselor = $user->role === 'konselor';
    $input = 'w-full rounded-2xl border-[#DCD5DD] bg-[#FCFAF8] focus:border-[#643B62] focus:ring-1 focus:ring-[#643B62] focus:outline-none px-4 py-3 text-[#3E293F] border text-xs sm:text-sm shadow-inner transition';
    $tabAwal = $errors->hasAny(['password_lama', 'password', 'password_sesi']) ? 'keamanan' : 'profil';
@endphp

@extends($layout)

@section($section)
<div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm border border-[#DCD5DD] p-6 sm:p-10 my-8 transition-shadow duration-200 hover:shadow-md"
     x-data="{
         activeTab: '{{ $tabAwal }}',
         loading: false,
         dragging: false,
         fileName: ''
     }">

    <div class="mb-8 pb-6 border-b border-[#DCD5DD]">
        <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#3E293F] tracking-tight">Kelola Profil Akun</h1>
        <p class="text-xs sm:text-sm text-[#746B77] mt-1">Perbarui informasi data diri dan kelengkapan akun Anda.</p>
    </div>

    <!-- Navigasi Tab -->
    <div class="mb-8 flex flex-wrap items-center gap-2 bg-[#EEE7F2]/60 p-2 rounded-2xl border border-[#DCD5DD]">
        <button type="button" @click="activeTab = 'profil'"
                :class="activeTab === 'profil' ? 'bg-[#3E293F] text-white shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]'"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 active:scale-[0.98]">
            Informasi Pribadi
        </button>
        @unless($isKonselor)
            <button type="button" @click="activeTab = 'privasi'"
                    :class="activeTab === 'privasi' ? 'bg-[#3E293F] text-white shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 active:scale-[0.98]">
                Privasi &amp; Notifikasi
            </button>
        @endunless
        @if($isKonselor)
            <button type="button" @click="activeTab = 'legalitas'"
                    :class="activeTab === 'legalitas' ? 'bg-[#3E293F] text-white shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 active:scale-[0.98]">
                Dokumen Legalitas
            </button>
        @endif
        <button type="button" @click="activeTab = 'keamanan'"
                :class="activeTab === 'keamanan' ? 'bg-[#3E293F] text-white shadow-sm' : 'text-[#746B77] hover:text-[#3E293F]'"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 active:scale-[0.98]">
            Keamanan
        </button>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs sm:text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Foto Profil Section -->
    <div x-show="activeTab === 'profil'" class="mb-8 pb-6 border-b border-[#DCD5DD]" x-data="{ preview: null }">
        <h2 class="text-xs font-bold text-[#643B62] uppercase tracking-wider mb-4">Foto Profil</h2>
        <div class="flex items-start gap-5">
            @if($user->foto_profil)
                <img x-show="!preview" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto profil" class="w-20 h-20 rounded-full object-cover border border-[#DCD5DD]">
            @else
                <div x-show="!preview" class="w-20 h-20 rounded-full bg-[#EEE7F2] text-[#643B62] flex items-center justify-center text-2xl font-bold shadow-inner">
                    {{ strtoupper(mb_substr($user->nama, 0, 1)) }}
                </div>
            @endif
            <img x-show="preview" :src="preview" alt="Pratinjau foto" class="w-20 h-20 rounded-full object-cover border border-[#643B62]" style="display: none;">

            <div class="space-y-3">
                <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <input type="file" name="foto_profil" accept="image/png,image/jpeg" required
                           @change="const f = $event.target.files[0]; preview = f ? URL.createObjectURL(f) : null"
                           class="block text-xs text-[#746B77] file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#EEE7F2] file:text-[#643B62] file:font-semibold file:cursor-pointer hover:file:bg-[#643B62] hover:file:text-white transition">
                    <p class="text-[11px] text-[#746B77]">JPG atau PNG, maksimal 2 MB.</p>
                    <button type="submit" class="px-4 py-2 bg-[#643B62] hover:bg-[#3E293F] text-white font-semibold rounded-xl text-xs transition-all duration-200 active:scale-[0.98]">Simpan Foto</button>
                </form>

                @if($user->foto_profil)
                    <form method="POST" action="{{ route('profile.photo.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">Hapus Foto</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" @submit="loading = true" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Tab: Informasi Pribadi -->
        <div x-show="activeTab === 'profil'"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-6">

            <h2 class="text-xs font-bold text-[#643B62] uppercase tracking-wider">Identitas</h2>

            <div>
                <label for="nama" class="block text-xs font-semibold text-[#3E293F] mb-2">Nama Lengkap</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="{{ $input }}">
            </div>

            <div>
                <label for="alias" class="block text-xs font-semibold text-[#3E293F] mb-2">Nama Samaran / Alias (Opsional)</label>
                <input id="alias" type="text" name="alias" value="{{ old('alias', $user->alias) }}" placeholder="Nama samaran saat sesi konsultasi" class="{{ $input }}">
                <p class="text-[11px] text-[#746B77] mt-1.5">Nama alias dipakai untuk melindungi privasi saat berkomunikasi dalam platform.</p>
            </div>

            <h2 class="text-xs font-bold text-[#643B62] uppercase tracking-wider pt-2">Kontak</h2>

            <div>
                <label for="email" class="block text-xs font-semibold text-[#3E293F] mb-2">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="{{ $input }}">
                <p class="text-[11px] text-[#746B77] mt-1.5">Jika email diganti, Anda perlu memverifikasi ulang alamat yang baru.</p>
            </div>

            <div>
                <label for="no_hp" class="block text-xs font-semibold text-[#3E293F] mb-2">Nomor HP (Opsional)</label>
                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 081234567890" class="{{ $input }}">
                <p class="text-[11px] text-[#746B77] mt-1.5">Dipakai untuk pengingat sesi. Disimpan terenkripsi.</p>
            </div>

            @unless($isKonselor)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kota" class="block text-xs font-semibold text-[#3E293F] mb-2">Kota (Opsional)</label>
                        <input id="kota" type="text" name="kota" value="{{ old('kota', $user->kota) }}" placeholder="Contoh: Surabaya" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="provinsi" class="block text-xs font-semibold text-[#3E293F] mb-2">Provinsi (Opsional)</label>
                        <input id="provinsi" type="text" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}" placeholder="Contoh: Jawa Timur" class="{{ $input }}">
                    </div>
                </div>
                <p class="text-[11px] text-[#746B77] -mt-3">Dipakai untuk rekomendasi bantuan di sekitarmu.</p>

                <h2 class="text-xs font-bold text-[#643B62] uppercase tracking-wider pt-2">Kontak Darurat (Opsional)</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kontak_darurat_nama" class="block text-xs font-semibold text-[#3E293F] mb-2">Nama</label>
                        <input id="kontak_darurat_nama" type="text" name="kontak_darurat_nama" value="{{ old('kontak_darurat_nama', $user->kontak_darurat_nama) }}" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="kontak_darurat_nomor" class="block text-xs font-semibold text-[#3E293F] mb-2">Nomor</label>
                        <input id="kontak_darurat_nomor" type="text" name="kontak_darurat_nomor" value="{{ old('kontak_darurat_nomor', $user->kontak_darurat_nomor) }}" class="{{ $input }}">
                    </div>
                </div>
                <p class="text-[11px] text-[#746B77] -mt-3">Disimpan terenkripsi dan hanya dipakai untuk keadaan darurat.</p>
            @endunless
        </div>

        <!-- Tab: Privasi & Notifikasi (pengguna) -->
        @unless($isKonselor)
            <div x-show="activeTab === 'privasi'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6" style="display: none;">

                <h2 class="text-xs font-bold text-[#643B62] uppercase tracking-wider">Mode Lapor Default</h2>
                <div class="space-y-3">
                    <label class="flex items-start gap-3 p-4 rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] cursor-pointer hover:border-[#643B62] transition">
                        <input type="radio" name="mode_lapor_default" value="anonim" class="mt-1 text-[#643B62] focus:ring-[#643B62]"
                               {{ old('mode_lapor_default', $user->mode_lapor_default ?? 'anonim') === 'anonim' ? 'checked' : '' }}>
                        <span>
                            <span class="block text-xs sm:text-sm font-semibold text-[#3E293F]">Anonim</span>
                            <span class="block text-[11px] text-[#746B77]">Identitas Anda disembunyikan saat membuat laporan (disarankan).</span>
                        </span>
                    </label>
                    <label class="flex items-start gap-3 p-4 rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] cursor-pointer hover:border-[#643B62] transition">
                        <input type="radio" name="mode_lapor_default" value="identitas" class="mt-1 text-[#643B62] focus:ring-[#643B62]"
                               {{ old('mode_lapor_default', $user->mode_lapor_default ?? 'anonim') === 'identitas' ? 'checked' : '' }}>
                        <span>
                            <span class="block text-xs sm:text-sm font-semibold text-[#3E293F]">Dengan identitas</span>
                            <span class="block text-[11px] text-[#746B77]">Nama Anda tercantum pada laporan.</span>
                        </span>
                    </label>
                </div>

                <h2 class="text-xs font-bold text-[#643B62] uppercase tracking-wider pt-2">Notifikasi Email</h2>
                <div class="space-y-3">
                    <input type="hidden" name="notif_status_laporan" value="0">
                    <label class="flex items-center gap-3 p-4 rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] cursor-pointer hover:border-[#643B62] transition">
                        <input type="checkbox" name="notif_status_laporan" value="1" class="rounded border-[#DCD5DD] text-[#643B62] focus:ring-[#643B62]"
                               {{ old('notif_status_laporan', $user->notif_status_laporan ?? true) ? 'checked' : '' }}>
                        <span class="text-xs sm:text-sm font-semibold text-[#3E293F]">Status laporan</span>
                    </label>

                    <input type="hidden" name="notif_pengingat_konsultasi" value="0">
                    <label class="flex items-center gap-3 p-4 rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] cursor-pointer hover:border-[#643B62] transition">
                        <input type="checkbox" name="notif_pengingat_konsultasi" value="1" class="rounded border-[#DCD5DD] text-[#643B62] focus:ring-[#643B62]"
                               {{ old('notif_pengingat_konsultasi', $user->notif_pengingat_konsultasi ?? true) ? 'checked' : '' }}>
                        <span class="text-xs sm:text-sm font-semibold text-[#3E293F]">Pengingat konsultasi</span>
                    </label>

                    <input type="hidden" name="notif_pembayaran" value="0">
                    <label class="flex items-center gap-3 p-4 rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8] cursor-pointer hover:border-[#643B62] transition">
                        <input type="checkbox" name="notif_pembayaran" value="1" class="rounded border-[#DCD5DD] text-[#643B62] focus:ring-[#643B62]"
                               {{ old('notif_pembayaran', $user->notif_pembayaran ?? true) ? 'checked' : '' }}>
                        <span class="text-xs sm:text-sm font-semibold text-[#3E293F]">Pembayaran</span>
                    </label>
                </div>
            </div>
        @endunless

        <!-- Tab: Legalitas Konselor (Khusus role konselor) -->
        @if($isKonselor)
            <div x-show="activeTab === 'legalitas'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6" style="display: none;">

                @if($user->konselor)
                    <div class="p-5 rounded-2xl border flex items-center justify-between
                        @if($user->konselor->status_verifikasi === 'disetujui') bg-emerald-50 border-emerald-200 text-emerald-800
                        @elseif($user->konselor->status_verifikasi === 'ditolak') bg-rose-50 border-rose-200 text-rose-800
                        @else bg-amber-50 border-amber-200 text-amber-800 @endif">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider block mb-1">Status Verifikasi Akun</span>
                            <span class="text-xs sm:text-sm font-bold capitalize">{{ $user->konselor->status_verifikasi }}</span>
                            @if($user->konselor->alasan_penolakan)
                                <p class="text-xs mt-1 text-rose-600">Catatan admin: {{ $user->konselor->alasan_penolakan }}</p>
                            @endif
                        </div>
                        <span class="text-2xl font-bold">
                            @if($user->konselor->status_verifikasi === 'disetujui') ✓
                            @elseif($user->konselor->status_verifikasi === 'ditolak') ✕
                            @else ⏳ @endif
                        </span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="no_str" class="block text-xs font-semibold text-[#3E293F] mb-2">Nomor STR</label>
                        <input id="no_str" type="text" name="no_str" value="{{ old('no_str', $user->konselor->no_str ?? '') }}" placeholder="Contoh: 1234567890" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="no_sipp" class="block text-xs font-semibold text-[#3E293F] mb-2">Nomor SIPP</label>
                        <input id="no_sipp" type="text" name="no_sipp" value="{{ old('no_sipp', $user->konselor->no_sipp ?? '') }}" placeholder="Contoh: SIPP-2026-X" class="{{ $input }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="bidang_keahlian" class="block text-xs font-semibold text-[#3E293F] mb-2">Bidang Keahlian</label>
                        <input id="bidang_keahlian" type="text" name="bidang_keahlian" value="{{ old('bidang_keahlian', $user->konselor->bidang_keahlian ?? '') }}" placeholder="Contoh: Trauma Psikologis, KDRT" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="tarif" class="block text-xs font-semibold text-[#3E293F] mb-2">Tarif per Sesi (Rp)</label>
                        <input id="tarif" type="number" name="tarif" value="{{ old('tarif', $user->konselor->tarif ?? 0) }}" min="0" step="1000" class="{{ $input }}">
                    </div>
                </div>

                <!-- Drag & Drop Upload Zone -->
                <div>
                    <label class="block text-xs font-semibold text-[#3E293F] mb-2">Upload Dokumen STR / SIPP (PDF / Foto)</label>
                    <div @dragover.prevent="dragging = true"
                         @dragleave.prevent="dragging = false"
                         @drop.prevent="dragging = false; $refs.fileInput.files = $event.dataTransfer.files; fileName = $refs.fileInput.files[0].name;"
                         :class="{ 'border-[#643B62] bg-[#EEE7F2]/40': dragging, 'border-[#DCD5DD] bg-[#FCFAF8]': !dragging }"
                         class="border-2 border-dashed rounded-2xl p-8 text-center transition-all duration-200 cursor-pointer relative hover:border-[#643B62]">

                        <input type="file" name="dokumen_verifikasi" x-ref="fileInput" @change="fileName = $refs.fileInput.files[0].name" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">

                        <div class="space-y-2">
                            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center mx-auto shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <p class="text-xs sm:text-sm font-semibold text-[#3E293F]" x-text="fileName ? 'File dipilih: ' + fileName : 'Tarik dan letakkan file dokumen STR/SIPP Anda ke sini'"></p>
                            <p class="text-[11px] text-[#746B77]">Atau klik untuk memilih file dari perangkat (PDF, JPG, PNG - Maks 10MB)</p>
                        </div>
                    </div>

                    @if($user->konselor && $user->konselor->dokumen_verifikasi)
                        <div class="mt-3 flex items-center justify-between text-xs bg-[#FCFAF8] p-3.5 rounded-2xl border border-[#DCD5DD]">
                            <span class="font-semibold text-[#643B62]">✓ Dokumen saat ini telah terunggah di sistem</span>
                            <a href="{{ asset('storage/' . $user->konselor->dokumen_verifikasi) }}" target="_blank" class="text-[#643B62] hover:underline font-bold">
                                Buka Dokumen &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div x-show="activeTab !== 'keamanan'" class="flex items-center justify-end space-x-3 pt-6 border-t border-[#DCD5DD]">
            <button type="submit" :disabled="loading"
                    class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white font-semibold rounded-2xl text-xs sm:text-sm shadow-sm transition-all duration-200 active:scale-[0.98] flex items-center space-x-2">
                <span x-show="!loading">Simpan Perubahan</span>
                <span x-show="loading" class="inline-flex items-center space-x-2">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memproses...</span>
                </span>
            </button>
        </div>
    </form>

    <!-- Tab: Keamanan (form terpisah) -->
    <div x-show="activeTab === 'keamanan'"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         style="display: none;">

        <div class="mb-6 pb-4 border-b border-[#DCD5DD]">
            <h2 class="text-xl font-serif font-bold text-[#3E293F] tracking-tight">Ubah Kata Sandi</h2>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1">Gunakan kata sandi baru minimal 8 karakter.</p>
        </div>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-6" x-data="{ pw: '', get skor() { let s = 0; if (this.pw.length >= 8) s++; if (/[a-z]/.test(this.pw) && /[A-Z]/.test(this.pw)) s++; if (/\d/.test(this.pw)) s++; if (/[^A-Za-z0-9]/.test(this.pw)) s++; if (this.pw.length >= 12) s++; return s; } }">
            @csrf
            @method('PUT')

            <div>
                <label for="password_lama" class="block text-xs font-semibold text-[#3E293F] mb-2">Kata Sandi Lama</label>
                <input id="password_lama" type="password" name="password_lama" required autocomplete="current-password" class="{{ $input }}">
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-[#3E293F] mb-2">Kata Sandi Baru</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" x-model="pw" class="{{ $input }}">
                <div class="mt-2" x-show="pw.length > 0" x-cloak>
                    <div class="h-1.5 w-full bg-[#DCD5DD] rounded-full overflow-hidden">
                        <div class="h-full transition-all duration-300"
                             :class="skor <= 1 ? 'bg-rose-600' : (skor <= 3 ? 'bg-amber-500' : 'bg-emerald-600')"
                             :style="'width:' + (skor * 20) + '%'"></div>
                    </div>
                    <p class="text-[11px] mt-1 text-[#746B77]" x-text="skor <= 1 ? 'Lemah' : (skor <= 3 ? 'Sedang' : 'Kuat')"></p>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-[#3E293F] mb-2">Konfirmasi Kata Sandi Baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="{{ $input }}">
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-[#DCD5DD]">
                <button type="submit"
                        class="px-6 py-3 bg-[#643B62] hover:bg-[#3E293F] text-white font-semibold rounded-2xl text-xs sm:text-sm shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Simpan Kata Sandi
                </button>
            </div>
        </form>

        <div class="mt-10 pt-6 border-t border-[#DCD5DD]">
            <h2 class="text-xl font-serif font-bold text-[#3E293F] tracking-tight">Sesi Login Aktif</h2>
            <p class="text-xs sm:text-sm text-[#746B77] mt-1">Perangkat yang sedang masuk ke akun Anda.</p>

            <ul class="mt-4 space-y-3">
                @forelse($sesi as $s)
                    <li class="flex items-center justify-between p-4 rounded-2xl border border-[#DCD5DD] bg-[#FCFAF8]">
                        <div>
                            <p class="text-xs sm:text-sm font-semibold text-[#3E293F]">{{ $s->perangkat }}
                                @if($s->saat_ini)
                                    <span class="ml-2 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">Perangkat ini</span>
                                @endif
                            </p>
                            <p class="text-[11px] text-[#746B77] mt-0.5">IP {{ $s->ip }} · Aktif {{ $s->terakhir }}</p>
                        </div>
                    </li>
                @empty
                    <li class="text-xs text-[#746B77]">Tidak ada sesi aktif.</li>
                @endforelse
            </ul>

            <form method="POST" action="{{ route('profile.sessions.destroy') }}" class="mt-6 space-y-4">
                @csrf
                @method('DELETE')
                <div>
                    <label for="password_sesi" class="block text-xs font-semibold text-[#3E293F] mb-2">Kata Sandi</label>
                    <input id="password_sesi" type="password" name="password_sesi" required autocomplete="current-password" class="{{ $input }}">
                </div>
                <button type="submit" class="px-6 py-3 border border-rose-300 text-rose-700 hover:bg-rose-50 font-semibold rounded-2xl text-xs sm:text-sm transition-all duration-200">
                    Keluar dari Semua Perangkat Lain
                </button>
            </form>
        </div>
    </div>
</div>
@endsection