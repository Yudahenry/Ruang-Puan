<div class="space-y-6" x-data="{ kategori: '{{ old('jenis_kasus', '') }}' }">
    {{-- Section Header --}}
    <div class="flex items-start gap-3.5">
        <div class="w-7 h-7 rounded-full bg-sage-100 text-sage-700 text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">
            02
        </div>
        <div>
            <h2 class="text-lg font-semibold text-sage-900 tracking-tight">Ceritakan kejadian yang kamu alami</h2>
            <p class="text-xs text-sage-500 mt-0.5">Tuliskan sesuai yang kamu ingat. Tidak harus dengan bahasa formal.</p>
        </div>
    </div>

    {{-- Kategori Kasus --}}
    <div class="space-y-2">
        <div>
            <label class="block text-xs font-bold text-sage-900 uppercase tracking-wider">Kategori kasus</label>
            <p class="text-xs text-sage-500 mt-0.5">Pilih kategori yang paling sesuai.</p>
        </div>

        <div class="flex flex-wrap gap-2.5 pt-1">
            @php
                $kategoriList = [
                    'kekerasan_fisik' => 'Kekerasan fisik',
                    'kekerasan_psikis' => 'Kekerasan psikis',
                    'kekerasan_seksual' => 'Kekerasan seksual',
                    'kdrt' => 'KDRT',
                    'kekerasan_online' => 'Kekerasan berbasis online',
                ];
            @endphp

            @foreach($kategoriList as $key => $label)
                <label 
                    @click="kategori = '{{ $key }}'"
                    :class="kategori === '{{ $key }}' ? 'border-sage-700 ring-1 ring-sage-700 bg-sage-50/70 text-sage-900 font-medium' : 'border-sage-200 bg-white text-sage-700 hover:border-sage-300 hover:bg-sage-50/40'"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full border text-xs cursor-pointer transition-all duration-150">
                    <input type="radio" name="jenis_kasus" value="{{ $key }}" x-model="kategori" class="sr-only">
                    <div class="flex-shrink-0">
                        <template x-if="kategori === '{{ $key }}'">
                            <div class="w-3.5 h-3.5 rounded-full border-2 border-sage-700 flex items-center justify-center">
                                <div class="w-1.5 h-1.5 rounded-full bg-sage-700"></div>
                            </div>
                        </template>
                        <template x-if="kategori !== '{{ $key }}'">
                            <div class="w-3.5 h-3.5 rounded-full border border-sage-300"></div>
                        </template>
                    </div>
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>

        @error('jenis_kasus')
            <p class="text-xs text-danger-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kronologi Kejadian --}}
    <div class="space-y-1.5">
        <label for="kronologi" class="block text-xs font-bold text-sage-900 uppercase tracking-wider">Kronologi kejadian</label>
        <textarea 
            id="kronologi" 
            name="kronologi" 
            rows="6" 
            required
            placeholder="Mulai dari apa yang terjadi, siapa yang terlibat, dan bagaimana urutan kejadiannya. Ceritakan sejauh yang kamu nyaman bagikan..."
            class="w-full rounded-xl border @error('kronologi') border-danger-600 ring-1 ring-danger-600 @else border-sage-200 @enderror bg-white p-4 text-sm text-sage-900 placeholder:text-sage-400 focus:border-sage-700 focus:ring-1 focus:ring-sage-700 transition focus:outline-none resize-y leading-relaxed">{{ old('kronologi') }}</textarea>
        
        <p class="text-xs text-sage-400">Kamu boleh berhenti sejenak saat menulis.</p>
        
        @error('kronologi')
            <p class="text-xs text-danger-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tanggal & Waktu Kejadian (2 Kolom) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Tanggal Kejadian --}}
        <div class="space-y-1.5">
            <label for="tanggal_kejadian" class="block text-xs font-bold text-sage-900 uppercase tracking-wider">Tanggal kejadian</label>
            <div class="relative">
                <input 
                    id="tanggal_kejadian" 
                    type="date" 
                    name="tanggal_kejadian" 
                    value="{{ old('tanggal_kejadian') }}"
                    required
                    placeholder="Pilih tanggal"
                    onclick="this.showPicker && this.showPicker()"
                    class="w-full rounded-xl border @error('tanggal_kejadian') border-danger-600 ring-1 ring-danger-600 @else border-sage-200 @enderror bg-white px-4 py-2.5 pr-10 text-sm text-sage-900 placeholder:text-sage-400 focus:border-sage-700 focus:ring-1 focus:ring-sage-700 transition focus:outline-none cursor-pointer">
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-sage-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            @error('tanggal_kejadian')
                <p class="text-xs text-danger-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Waktu Kejadian --}}
        <div class="space-y-1.5">
            <label for="waktu_kejadian" class="block text-xs font-bold text-sage-900 uppercase tracking-wider">Waktu kejadian</label>
            <div class="relative">
                <input 
                    id="waktu_kejadian" 
                    type="text" 
                    name="waktu_kejadian" 
                    value="{{ old('waktu_kejadian') }}"
                    placeholder="Contoh: sekitar pukul 14.00"
                    class="w-full rounded-xl border @error('waktu_kejadian') border-danger-600 ring-1 ring-danger-600 @else border-sage-200 @enderror bg-white px-4 py-2.5 pr-10 text-sm text-sage-900 placeholder:text-sage-400 focus:border-sage-700 focus:ring-1 focus:ring-sage-700 transition focus:outline-none">
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-sage-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            @error('waktu_kejadian')
                <p class="text-xs text-danger-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Lokasi Kejadian --}}
    <div class="space-y-1.5">
        <label for="lokasi_kejadian" class="block text-xs font-bold text-sage-900 uppercase tracking-wider">Lokasi kejadian</label>
        <div class="relative">
            <input 
                id="lokasi_kejadian" 
                type="text" 
                name="lokasi_kejadian" 
                value="{{ old('lokasi_kejadian') }}"
                required
                placeholder="Contoh: wilayah, tempat, atau platform online"
                class="w-full rounded-xl border @error('lokasi_kejadian') border-danger-600 ring-1 ring-danger-600 @else border-sage-200 @enderror bg-white px-4 py-2.5 pr-10 text-sm text-sage-900 placeholder:text-sage-400 focus:border-sage-700 focus:ring-1 focus:ring-sage-700 transition focus:outline-none">
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-sage-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>
        <p class="text-xs text-sage-400">Tuliskan lokasi atau perkiraan tempat yang kamu ingat.</p>
        @error('lokasi_kejadian')
            <p class="text-xs text-danger-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
