@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-3xl shadow-sm border border-cream-200 p-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-berry-900">Kelola Direktori Lembaga Bantuan</h1>
            <p class="text-sm text-ink-600 mt-1">Tambah dan kelola daftar lembaga mitra, UPTD PPA, LBH, dan rumah aman.</p>
        </div>
        <a href="{{ route('admin.direktori.create') }}" class="px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-xl text-sm shadow-sm transition">
            + Tambah Lembaga
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-cream-100 text-ink-900 border-b border-cream-200">
                    <th class="p-3">Nama Lembaga</th>
                    <th class="p-3">Jenis Layanan</th>
                    <th class="p-3">Wilayah</th>
                    <th class="p-3">Kontak</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cream-200">
                @forelse($lembagas as $lembaga)
                    <tr class="hover:bg-cream-50">
                        <td class="p-3 font-medium text-berry-900">{{ $lembaga->nama }}</td>
                        <td class="p-3 uppercase text-xs font-semibold">{{ str_replace('_', ' ', $lembaga->jenis_layanan) }}</td>
                        <td class="p-3">{{ $lembaga->wilayah }}</td>
                        <td class="p-3">{{ $lembaga->kontak ?? '-' }}</td>
                        <td class="p-3 text-right">
                            <button @click="$dispatch('open-confirm-modal', { 
                                        url: '{{ route('admin.direktori.destroy', $lembaga->id) }}', 
                                        title: 'Hapus Lembaga Bantuan', 
                                        message: 'Apakah Anda yakin ingin menghapus data lembaga bantuan ini secara permanen?', 
                                        method: 'DELETE',
                                        confirmText: 'Ya, Hapus Lembaga' 
                                    })" 
                                    type="button" 
                                    class="px-3 py-1 bg-danger-100 text-danger-600 hover:bg-danger-600 hover:text-white rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-ink-600">Belum ada lembaga bantuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $lembagas->links() }}
    </div>
</div>

<x-modal-confirm />
@endsection
