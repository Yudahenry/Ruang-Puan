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
    $input = 'w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3.5 py-2.5 text-ink-900 border text-sm transition';
    $tabAwal = $errors->hasAny(['password_lama', 'password']) ? 'keamanan' : 'profil';
@endphp

@extends($layout)

@section($section)
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-cream-200 p-6 sm:p-8 my-6 transition-shadow duration-200 hover:shadow-md"
     x-data="{
         activeTab: '{{ $tabAwal }}',
         loading: false,
         dragging: false,
         fileName: ''
     }">

    <div class="mb-6 pb-4 border-b border-cream-200">
        <h1 class="text-2xl font-bold text-berry-900 tracking-tight">Kelola Profil Akun</h1>
        <p class="text-sm text-ink-600 mt-0.5">Perbarui informasi data diri dan kelengkapan akun Anda.</p>
    </div>

    <!-- Navigasi Tab -->
    <div class="mb-6 flex flex-wrap items-center gap-1 bg-cream-50 p-1 rounded-lg border border-cream-200">
        <button type="button" @click="activeTab = 'profil'"
                :class="activeTab === 'profil' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
            Informasi Pribadi
        </button>
        @unless($isKonselor)
            <button type="button" @click="activeTab = 'privasi'"
                    :class="activeTab === 'privasi' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                Privasi &amp; Notifikasi
            </button>
        @endunless
        @if($isKonselor)
            <button type="button" @click="activeTab = 'legalitas'"
                    :class="activeTab === 'legalitas' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                Dokumen Legalitas
            </button>
        @endif
        <button type="button" @click="activeTab = 'keamanan'"
                :class="activeTab === 'keamanan' ? 'bg-berry-700 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
            Keamanan
        </button>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-danger-100 border border-danger-600 text-danger-600 p-4 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" @submit="loading = true" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Tab: Informasi Pribadi -->
        <div x-show="activeTab === 'profil'"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-5">

            <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider">Identitas</h2>

            <div>
                <label for="nama" class="block text-sm font-semibold text-ink-900 mb-1.5">Nama Lengkap</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="{{ $input }}">
            </div>

            <div>
                <label for="alias" class="block text-sm font-semibold text-ink-900 mb-1.5">Nama Samaran / Alias (Opsional)</label>
                <input id="alias" type="text" name="alias" value="{{ old('alias', $user->alias) }}" placeholder="Nama samaran saat sesi konsultasi" class="{{ $input }}">
                <p class="text-xs text-ink-600 mt-1">Nama alias dipakai untuk melindungi privasi saat berkomunikasi dalam platform.</p>
            </div>

            <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider pt-2">Kontak</h2>

            <div>
                <label for="email" class="block text-sm font-semibold text-ink-900 mb-1.5">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="{{ $input }}">
                <p class="text-xs text-ink-600 mt-1">Jika email diganti, Anda perlu memverifikasi ulang alamat yang baru.</p>
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-semibold text-ink-900 mb-1.5">Nomor HP (Opsional)</label>
                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 081234567890" class="{{ $input }}">
                <p class="text-xs text-ink-600 mt-1">Dipakai untuk pengingat sesi. Disimpan terenkripsi.</p>
            </div>

            @unless($isKonselor)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kota" class="block text-sm font-semibold text-ink-900 mb-1.5">Kota (Opsional)</label>
                        <input id="kota" type="text" name="kota" value="{{ old('kota', $user->kota) }}" placeholder="Contoh: Surabaya" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="provinsi" class="block text-sm font-semibold text-ink-900 mb-1.5">Provinsi (Opsional)</label>
                        <input id="provinsi" type="text" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}" placeholder="Contoh: Jawa Timur" class="{{ $input }}">
                    </div>
                </div>
                <p class="text-xs text-ink-600 -mt-2">Dipakai untuk rekomendasi bantuan di sekitarmu.</p>

                <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider pt-2">Kontak Darurat (Opsional)</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kontak_darurat_nama" class="block text-sm font-semibold text-ink-900 mb-1.5">Nama</label>
                        <input id="kontak_darurat_nama" type="text" name="kontak_darurat_nama" value="{{ old('kontak_darurat_nama', $user->kontak_darurat_nama) }}" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="kontak_darurat_nomor" class="block text-sm font-semibold text-ink-900 mb-1.5">Nomor</label>
                        <input id="kontak_darurat_nomor" type="text" name="kontak_darurat_nomor" value="{{ old('kontak_darurat_nomor', $user->kontak_darurat_nomor) }}" class="{{ $input }}">
                    </div>
                </div>
                <p class="text-xs text-ink-600 -mt-2">Disimpan terenkripsi dan hanya dipakai untuk keadaan darurat.</p>
            @endunless
        </div>

        <!-- Tab: Privasi & Notifikasi (pengguna) -->
        @unless($isKonselor)
            <div x-show="activeTab === 'privasi'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-5" style="display: none;">

                <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider">Mode Lapor Default</h2>
                <div class="space-y-2">
                    <label class="flex items-start gap-3 p-3 rounded-lg border border-cream-200 bg-cream-50 cursor-pointer">
                        <input type="radio" name="mode_lapor_default" value="anonim" class="mt-1 text-berry-700 focus:ring-berry-500"
                               {{ old('mode_lapor_default', $user->mode_lapor_default ?? 'anonim') === 'anonim' ? 'checked' : '' }}>
                        <span>
                            <span class="block text-sm font-semibold text-ink-900">Anonim</span>
                            <span class="block text-xs text-ink-600">Identitas Anda disembunyikan saat membuat laporan (disarankan).</span>
                        </span>
                    </label>
                    <label class="flex items-start gap-3 p-3 rounded-lg border border-cream-200 bg-cream-50 cursor-pointer">
                        <input type="radio" name="mode_lapor_default" value="identitas" class="mt-1 text-berry-700 focus:ring-berry-500"
                               {{ old('mode_lapor_default', $user->mode_lapor_default ?? 'anonim') === 'identitas' ? 'checked' : '' }}>
                        <span>
                            <span class="block text-sm font-semibold text-ink-900">Dengan identitas</span>
                            <span class="block text-xs text-ink-600">Nama Anda tercantum pada laporan.</span>
                        </span>
                    </label>
                </div>

                <h2 class="text-sm font-bold text-berry-900 uppercase tracking-wider pt-2">Notifikasi Email</h2>
                <div class="space-y-2">
                    <input type="hidden" name="notif_status_laporan" value="0">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-cream-200 bg-cream-50 cursor-pointer">
                        <input type="checkbox" name="notif_status_laporan" value="1" class="rounded border-cream-200 text-berry-700 focus:ring-berry-500"
                               {{ old('notif_status_laporan', $user->notif_status_laporan ?? true) ? 'checked' : '' }}>
                        <span class="text-sm text-ink-900">Status laporan</span>
                    </label>

                    <input type="hidden" name="notif_pengingat_konsultasi" value="0">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-cream-200 bg-cream-50 cursor-pointer">
                        <input type="checkbox" name="notif_pengingat_konsultasi" value="1" class="rounded border-cream-200 text-berry-700 focus:ring-berry-500"
                               {{ old('notif_pengingat_konsultasi', $user->notif_pengingat_konsultasi ?? true) ? 'checked' : '' }}>
                        <span class="text-sm text-ink-900">Pengingat konsultasi</span>
                    </label>

                    <input type="hidden" name="notif_pembayaran" value="0">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-cream-200 bg-cream-50 cursor-pointer">
                        <input type="checkbox" name="notif_pembayaran" value="1" class="rounded border-cream-200 text-berry-700 focus:ring-berry-500"
                               {{ old('notif_pembayaran', $user->notif_pembayaran ?? true) ? 'checked' : '' }}>
                        <span class="text-sm text-ink-900">Pembayaran</span>
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
                 class="space-y-5" style="display: none;">

                @if($user->konselor)
                    <div class="p-4 rounded-xl border flex items-center justify-between
                        @if($user->konselor->status_verifikasi === 'disetujui') bg-success-100/50 border-success-600/30 text-success-600
                        @elseif($user->konselor->status_verifikasi === 'ditolak') bg-danger-100/50 border-danger-600/30 text-danger-600
                        @else bg-warning-100/50 border-warning-600/30 text-warning-600 @endif">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider block">Status Verifikasi Akun</span>
                            <span class="text-sm font-semibold capitalize">{{ $user->konselor->status_verifikasi }}</span>
                            @if($user->konselor->alasan_penolakan)
                                <p class="text-xs mt-1 text-danger-600">Catatan admin: {{ $user->konselor->alasan_penolakan }}</p>
                            @endif
                        </div>
                        <span class="text-2xl">
                            @if($user->konselor->status_verifikasi === 'disetujui') ✓
                            @elseif($user->konselor->status_verifikasi === 'ditolak') ✕
                            @else ⏳ @endif
                        </span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="no_str" class="block text-sm font-semibold text-ink-900 mb-1.5">Nomor STR</label>
                        <input id="no_str" type="text" name="no_str" value="{{ old('no_str', $user->konselor->no_str ?? '') }}" placeholder="Contoh: 1234567890" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="no_sipp" class="block text-sm font-semibold text-ink-900 mb-1.5">Nomor SIPP</label>
                        <input id="no_sipp" type="text" name="no_sipp" value="{{ old('no_sipp', $user->konselor->no_sipp ?? '') }}" placeholder="Contoh: SIPP-2026-X" class="{{ $input }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="bidang_keahlian" class="block text-sm font-semibold text-ink-900 mb-1.5">Bidang Keahlian</label>
                        <input id="bidang_keahlian" type="text" name="bidang_keahlian" value="{{ old('bidang_keahlian', $user->konselor->bidang_keahlian ?? '') }}" placeholder="Contoh: Trauma Psikologis, KDRT" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="tarif" class="block text-sm font-semibold text-ink-900 mb-1.5">Tarif per Sesi (Rp)</label>
                        <input id="tarif" type="number" name="tarif" value="{{ old('tarif', $user->konselor->tarif ?? 0) }}" min="0" step="1000" class="{{ $input }}">
                    </div>
                </div>

                <!-- Drag & Drop Upload Zone -->
                <div>
                    <label class="block text-sm font-semibold text-ink-900 mb-1.5">Upload Dokumen STR / SIPP (PDF / Foto)</label>
                    <div @dragover.prevent="dragging = true"
                         @dragleave.prevent="dragging = false"
                         @drop.prevent="dragging = false; $refs.fileInput.files = $event.dataTransfer.files; fileName = $refs.fileInput.files[0].name;"
                         :class="{ 'border-berry-700 bg-berry-100/40': dragging, 'border-cream-200 bg-cream-50/70': !dragging }"
                         class="border-2 border-dashed rounded-xl p-8 text-center transition-all duration-200 cursor-pointer relative hover:border-berry-500">

                        <input type="file" name="dokumen_verifikasi" x-ref="fileInput" @change="fileName = $refs.fileInput.files[0].name" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">

                        <div class="space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-berry-100 text-berry-700 flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-ink-900" x-text="fileName ? 'File dipilih: ' + fileName : 'Tarik dan letakkan file dokumen STR/SIPP Anda ke sini'"></p>
                            <p class="text-xs text-ink-600">Atau klik untuk memilih file dari perangkat (PDF, JPG, PNG - Maks 10MB)</p>
                        </div>
                    </div>

                    @if($user->konselor && $user->konselor->dokumen_verifikasi)
                        <div class="mt-3 flex items-center justify-between text-xs bg-cream-50 p-3 rounded-lg border border-cream-200">
                            <span class="font-medium text-berry-700">✓ Dokumen saat ini telah terunggah di sistem</span>
                            <a href="{{ asset('storage/' . $user->konselor->dokumen_verifikasi) }}" target="_blank" class="text-rose-600 hover:underline font-semibold">
                                Buka Dokumen &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div x-show="activeTab !== 'keamanan'" class="flex items-center justify-end space-x-3 pt-5 border-t border-cream-200">
            <button type="submit" :disabled="loading"
                    class="px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition-all duration-200 active:scale-[0.98] flex items-center space-x-2">
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

        <div class="mb-5 pb-4 border-b border-cream-200">
            <h2 class="text-xl font-bold text-berry-900 tracking-tight">Ubah Kata Sandi</h2>
            <p class="text-sm text-ink-600 mt-0.5">Gunakan kata sandi baru minimal 8 karakter.</p>
        </div>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="password_lama" class="block text-sm font-semibold text-ink-900 mb-1.5">Kata Sandi Lama</label>
                <input id="password_lama" type="password" name="password_lama" required autocomplete="current-password" class="{{ $input }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-ink-900 mb-1.5">Kata Sandi Baru</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="{{ $input }}">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-ink-900 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="{{ $input }}">
            </div>

            <div class="flex items-center justify-end pt-5 border-t border-cream-200">
                <button type="submit"
                    class="px-6 py-2.5 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition-all duration-200 active:scale-[0.98]">
                    Simpan Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection