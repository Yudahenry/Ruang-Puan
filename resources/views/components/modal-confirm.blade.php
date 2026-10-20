@props([
    'name' => 'confirm-modal',
    'title' => 'Konfirmasi Aksi',
    'message' => 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
    'confirmText' => 'Ya, Lanjutkan',
    'confirmColor' => 'danger'
])

<div x-data="{ 
        show: false, 
        actionUrl: '', 
        modalTitle: '{{ $title }}',
        modalMessage: '{{ $message }}',
        actionMethod: 'POST',
        customConfirmText: '{{ $confirmText }}',
        withReason: false,
        reason: ''
     }"
     @open-confirm-modal.window="
        show = true; 
        actionUrl = $event.detail.url || '';
        if ($event.detail.title) modalTitle = $event.detail.title;
        if ($event.detail.message) modalMessage = $event.detail.message;
        if ($event.detail.method) actionMethod = $event.detail.method;
        if ($event.detail.confirmText) customConfirmText = $event.detail.confirmText;
        withReason = !!$event.detail.withReason;
        reason = '';
     "
     x-show="show"
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
    
    <!-- Backdrop with Fade -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false"
         class="fixed inset-0 bg-berry-900/60 backdrop-blur-sm"></div>

    <!-- Modal Box with Scale & Fade -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
         @click.away="show = false" 
         class="relative bg-white rounded-xl max-w-md w-full p-6 shadow-2xl border border-cream-200 z-10">
        
        <div class="flex items-start space-x-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-danger-100 text-danger-600 flex items-center justify-center flex-shrink-0 font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-berry-900" x-text="modalTitle"></h3>
                <p class="text-sm text-ink-600 mt-1 leading-relaxed" x-text="modalMessage"></p>
            </div>
        </div>

        <form :action="actionUrl" method="POST" class="mt-4">
            @csrf
            <template x-if="actionMethod === 'DELETE'">
                <input type="hidden" name="_method" value="DELETE">
            </template>
            <template x-if="actionMethod === 'PATCH'">
                <input type="hidden" name="_method" value="PATCH">
            </template>

            <!-- Optional Reason Input (e.g. Alasan Penolakan) -->
            <div x-show="withReason" class="mb-5">
                <label class="block text-xs font-semibold text-ink-900 mb-1">Alasan Penolakan (Wajib)</label>
                <textarea name="alasan_penolakan" x-model="reason" rows="3" placeholder="Tulis alasan penolakan dokumen/pengajuan..."
                          class="w-full rounded-lg border-cream-200 bg-cream-50 focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-cream-200">
                <button @click="show = false" type="button" 
                        class="px-4 py-2 rounded-lg bg-cream-100 hover:bg-cream-200 text-ink-900 text-sm font-medium transition-all duration-200 active:scale-[0.98]">
                    Batal
                </button>
                <button type="submit" 
                        :disabled="withReason && !reason.trim()"
                        class="px-4 py-2 rounded-lg bg-danger-600 hover:bg-danger-700 disabled:opacity-50 text-white text-sm font-medium shadow-sm transition-all duration-200 active:scale-[0.98]" 
                        x-text="customConfirmText">
                </button>
            </div>
        </form>
    </div>
</div>
