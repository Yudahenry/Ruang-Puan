<div class="space-y-4">
    <div class="flex items-start gap-3.5">
        <div class="w-7 h-7 rounded-full bg-sage-100 text-sage-700 text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">
            01
        </div>
        <div>
            <h2 class="text-lg font-semibold text-sage-900 tracking-tight">Bagaimana kamu ingin melapor?</h2>
            <p class="text-xs text-sage-500 mt-0.5">Pilih cara identitasmu ditampilkan dalam laporan.</p>
        </div>
    </div>

    <div class="pt-1">
        <x-anonim-toggle :value="old('anonim', '1')" />
    </div>
</div>
