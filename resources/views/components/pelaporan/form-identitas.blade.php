<div class="space-y-4">
    <div class="flex items-start gap-3.5">
        <div class="w-7 h-7 rounded-full bg-[#EEE7F2] text-[#643B62] text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5 shadow-inner">
            01
        </div>
        <div>
            <h2 class="text-lg font-serif font-bold text-[#3E293F] tracking-tight">Bagaimana kamu ingin melapor?</h2>
            <p class="text-xs text-[#746B77] mt-0.5">Pilih cara identitasmu ditampilkan dalam laporan.</p>
        </div>
    </div>

    <div class="pt-1">
        <x-anonim-toggle :value="old('anonim', '1')" />
    </div>
</div>