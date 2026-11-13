@php
    $warna = [
        'diterima'              => 'bg-sky-100 text-sky-800 border-sky-200',
        'diverifikasi'          => 'bg-indigo-100 text-indigo-800 border-indigo-200',
        'diproses'              => 'bg-amber-100 text-amber-800 border-amber-200',
        'diteruskan_ke_lembaga' => 'bg-violet-100 text-violet-800 border-violet-200',
        'selesai'               => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'ditutup'               => 'bg-gray-100 text-gray-700 border-gray-200',
    ];
@endphp
<span class="inline-flex px-3 py-1 rounded-full border text-[11px] font-semibold {{ $warna[$status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
    {{ \App\Models\Laporan::labelStatus($status) }}
</span>
