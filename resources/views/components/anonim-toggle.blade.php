@props(['value' => old('anonim', '1')])

<div x-data="{ anonim: '{{ $value ?? '1' }}' }" class="w-full">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Opsi Anonim --}}
        <label 
            @click="anonim = '1'"
            :class="anonim === '1' ? 'border-sage-700 ring-1 ring-sage-700' : 'border-sage-200 hover:border-sage-300'"
            class="relative flex items-start gap-3 p-4 rounded-xl border bg-white cursor-pointer transition-all duration-150">
            <input type="radio" name="anonim" value="1" x-model="anonim" class="sr-only">
            <div class="flex-shrink-0 mt-0.5">
                <template x-if="anonim === '1'">
                    <div class="w-4 h-4 rounded-full border-2 border-sage-700 flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-sage-700"></div>
                    </div>
                </template>
                <template x-if="anonim !== '1'">
                    <div class="w-4 h-4 rounded-full border border-sage-300"></div>
                </template>
            </div>
            <div>
                <span class="block text-sm font-semibold text-sage-900 leading-tight">Anonim</span>
                <span class="block text-xs text-sage-500 mt-1 leading-relaxed">
                    Identitasmu tidak ditampilkan kepada admin maupun pihak lain.
                </span>
            </div>
        </label>

        {{-- Opsi Dengan Identitas --}}
        <label 
            @click="anonim = '0'"
            :class="anonim === '0' ? 'border-sage-700 ring-1 ring-sage-700' : 'border-sage-200 hover:border-sage-300'"
            class="relative flex items-start gap-3 p-4 rounded-xl border bg-white cursor-pointer transition-all duration-150">
            <input type="radio" name="anonim" value="0" x-model="anonim" class="sr-only">
            <div class="flex-shrink-0 mt-0.5">
                <template x-if="anonim === '0'">
                    <div class="w-4 h-4 rounded-full border-2 border-sage-700 flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-sage-700"></div>
                    </div>
                </template>
                <template x-if="anonim !== '0'">
                    <div class="w-4 h-4 rounded-full border border-sage-300"></div>
                </template>
            </div>
            <div>
                <span class="block text-sm font-semibold text-sage-900 leading-tight">Dengan identitas</span>
                <span class="block text-xs text-sage-500 mt-1 leading-relaxed">
                    Identitas dari akunmu ditampilkan sebagai bagian dari laporan.
                </span>
            </div>
        </label>
    </div>

    {{-- Info bar kecil di bawah radio card --}}
    <div class="mt-3.5 flex items-center gap-2 text-xs text-sage-500">
        <svg class="w-4 h-4 text-sage-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Laporan anonim tetap terhubung ke akunmu agar kamu dapat melihat riwayat dan memantau statusnya.</span>
    </div>
</div>
