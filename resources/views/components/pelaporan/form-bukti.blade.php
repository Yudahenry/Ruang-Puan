<div class="space-y-4" x-data="{
    isDragging: false,
    fileList: [],
    fileError: '',
    maxFileSize: 10 * 1024 * 1024, // 10MB
    allowedExtensions: ['jpg', 'jpeg', 'png', 'pdf', 'mp4', 'mov', 'doc', 'docx'],

    handleFiles(newFiles) {
        this.fileError = '';
        const incoming = Array.from(newFiles);

        for (const file of incoming) {
            // Check extension
            const ext = file.name.split('.').pop().toLowerCase();
            if (!this.allowedExtensions.includes(ext)) {
                this.fileError = 'Format berkas ' + file.name + ' tidak didukung. Gunakan foto, dokumen (PDF/DOC), atau rekaman.';
                continue;
            }

            // Check size
            if (file.size > this.maxFileSize) {
                this.fileError = 'Ukuran berkas ' + file.name + ' melebihi batas 10MB.';
                continue;
            }

            // Avoid duplicate by name & size
            if (!this.fileList.some(f => f.name === file.name && f.size === file.size)) {
                this.fileList.push(file);
            }
        }

        this.syncInput();
    },

    removeFile(index) {
        this.fileList.splice(index, 1);
        this.syncInput();
    },

    syncInput() {
        try {
            const dt = new DataTransfer();
            this.fileList.forEach(file => dt.items.add(file));
            this.$refs.fileInput.files = dt.files;
        } catch (e) {
            // Fallback for older browsers
        }
    },

    formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }
}">
    {{-- Section Header --}}
    <div class="flex items-start gap-3.5">
        <div class="w-7 h-7 rounded-full bg-[#EEE7F2] text-[#643B62] text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5 shadow-inner">
            03
        </div>
        <div>
            <h2 class="text-lg font-serif font-bold text-[#3E293F] tracking-tight">Tambahkan bukti, jika ada</h2>
            <p class="text-xs text-[#746B77] mt-0.5">Opsional. Kamu tetap dapat mengirim laporan tanpa melampirkan bukti.</p>
        </div>
    </div>

    {{-- Drag & Drop Upload Area --}}
    <div 
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
        @click="$refs.fileInput.click()"
        :class="isDragging ? 'border-[#643B62] bg-[#EEE7F2]/70 ring-2 ring-[#643B62]/20' : 'border-[#DCD5DD] bg-[#FCFAF8]/40 hover:bg-[#FCFAF8]/80 hover:border-[#746B77]/50'"
        class="border-2 border-dashed rounded-3xl p-8 sm:p-10 text-center transition-all duration-200 cursor-pointer relative group shadow-2xs">
        
        <input 
            type="file" 
            x-ref="fileInput" 
            name="bukti[]" 
            multiple 
            accept=".jpg,.jpeg,.png,.pdf,.mp4,.mov,.doc,.docx"
            class="hidden" 
            @change="handleFiles($event.target.files)">

        <div class="flex flex-col items-center justify-center">
            {{-- Cloud upload icon --}}
            <div class="w-12 h-12 rounded-2xl bg-[#EEE7F2] flex items-center justify-center text-[#643B62] mb-3 group-hover:scale-105 transition shadow-inner">
                <svg class="w-6 h-6 text-[#643B62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
            </div>

            <p class="text-xs sm:text-sm font-semibold text-[#3E293F]">
                Tarik berkas ke sini atau pilih dari perangkatmu
            </p>

            <button type="button" class="mt-3 px-4 py-2 rounded-xl border border-[#DCD5DD] bg-white text-xs font-semibold text-[#3E293F] shadow-2xs group-hover:bg-[#FCFAF8] transition pointer-events-none">
                Pilih berkas
            </button>

            <p class="text-[11px] text-[#746B77] mt-2">
                Foto, dokumen, atau rekaman
            </p>
        </div>
    </div>

    {{-- Client error alert --}}
    <template x-if="fileError">
        <div class="p-4 bg-red-100 border border-red-500/30 text-red-700 text-xs rounded-2xl flex items-center justify-between shadow-2xs">
            <span x-text="fileError" class="font-medium"></span>
            <button type="button" @click="fileError = ''" class="text-red-700 hover:text-red-900 font-bold ml-2 text-sm">&times;</button>
        </div>
    </template>

    <p class="text-xs text-[#746B77] leading-relaxed">
        Lampirkan hanya yang kamu nyaman bagikan. Format dan ukuran berkas akan diperiksa saat dipilih.
    </p>

    {{-- File Previews List --}}
    <template x-if="fileList.length > 0">
        <div class="space-y-2 pt-2">
            <template x-for="(file, index) in fileList" :key="index">
                <div class="flex items-center justify-between p-3.5 bg-white border border-[#DCD5DD] rounded-2xl text-xs transition hover:border-[#643B62]/50 shadow-2xs">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-[#EEE7F2] text-[#643B62] flex items-center justify-center flex-shrink-0 shadow-inner">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-[#3E293F] truncate max-w-xs sm:max-w-md" x-text="file.name"></p>
                            <p class="text-[10px] text-[#746B77]" x-text="formatBytes(file.size)"></p>
                        </div>
                    </div>
                    <button 
                        type="button" 
                        @click.stop="removeFile(index)" 
                        class="p-2 text-[#746B77] hover:text-red-600 hover:bg-red-50 rounded-xl transition" 
                        title="Hapus berkas">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </template>

    @error('bukti')
        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
    @enderror
    @error('bukti.*')
        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
    @enderror
</div>