@props(['message', 'type' => 'success'])

@if(session($type) || isset($message))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-6 scale-95"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 sm:translate-x-0 scale-100"
         x-transition:leave-end="opacity-0 sm:translate-x-6 scale-95"
         class="fixed top-6 right-6 z-50 max-w-sm w-full shadow-xl rounded-xl p-4 border flex items-start justify-between space-x-3
         @if($type === 'success') bg-white border-success-600/30 text-ink-900 shadow-success-600/10
         @elseif($type === 'error' || $type === 'danger') bg-white border-danger-600/30 text-ink-900 shadow-danger-600/10
         @else bg-white border-info-600/30 text-ink-900 shadow-info-600/10 @endif"
         role="alert">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold
                @if($type === 'success') bg-success-100 text-success-600
                @elseif($type === 'error' || $type === 'danger') bg-danger-100 text-danger-600
                @else bg-info-100 text-info-600 @endif">
                @if($type === 'success')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                @endif
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider
                    @if($type === 'success') text-success-600
                    @elseif($type === 'error' || $type === 'danger') text-danger-600
                    @else text-info-600 @endif">
                    {{ $type === 'success' ? 'Berhasil' : 'Perhatian' }}
                </p>
                <p class="text-sm text-ink-900 mt-0.5 leading-snug">{{ $message ?? session($type) }}</p>
            </div>
        </div>
        <button @click="show = false" class="text-ink-600 hover:text-ink-900 p-1 rounded-md transition" aria-label="Tutup">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
@endif
