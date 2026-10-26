@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-2xl shadow-sm border border-cream-200 p-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-berry-900">Kelola Materi Edukasi</h1>
            <p class="text-sm text-ink-600 mt-1">Tambah, kelola artikel edukasi, serta kategori konten.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.edukasi.create') }}" class="px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-lg text-sm shadow-sm transition">
                + Tambah Materi
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-danger-100 border border-danger-600 text-danger-600 p-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah Kategori Cepat -->
    <div class="mb-10 bg-cream-50 p-6 rounded-2xl border border-cream-200">
        <h3 class="text-lg font-bold text-berry-900 mb-3">Tambah Kategori Edukasi Baru</h3>
        <form method="POST" action="{{ route('admin.edukasi.kategori.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required placeholder="Nama Kategori (mis. Kesehatan Mental)"
                    class="w-full rounded-lg border-cream-200 bg-white focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
            </div>
            <div>
                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Deskripsi singkat kategori..."
                    class="w-full rounded-lg border-cream-200 bg-white focus:border-berry-500 focus:ring-berry-500 px-3 py-2 text-ink-900 border text-sm">
            </div>
            <div>
                <button type="submit" class="w-full py-2 px-4 bg-rose-600 hover:bg-berry-700 text-white font-medium rounded-lg text-sm transition shadow-sm">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>

    <!-- Daftar Materi Edukasi -->
    <h3 class="text-lg font-bold text-berry-900 mb-4">Daftar Materi Edukasi</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-cream-100 text-ink-900 border-b border-cream-200">
                    <th class="p-3">Judul</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Jenis</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cream-200">
                @forelse($materis as $materi)
                    <tr class="hover:bg-cream-50">
                        <td class="p-3 font-medium text-berry-900">{{ $materi->judul }}</td>
                        <td class="p-3">{{ $materi->kategoriEdukasi->nama_kategori ?? '-' }}</td>
                        <td class="p-3 uppercase text-xs font-semibold">{{ $materi->jenis_konten }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $materi->status === 'terbit' ? 'bg-success-100 text-success-600' : 'bg-warning-100 text-warning-600' }}">
                                {{ ucfirst($materi->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <button type="button" 
                                    @click="$dispatch('open-confirm-modal', { 
                                        url: '{{ route('admin.edukasi.destroy', $materi->id) }}', 
                                        title: 'Hapus Materi Edukasi', 
                                        message: 'Apakah Anda yakin ingin menghapus materi ini secara permanen?', 
                                        method: 'DELETE',
                                        confirmText: 'Ya, Hapus Materi' 
                                    })"
                                    class="px-3 py-1 bg-danger-100 text-danger-600 hover:bg-danger-600 hover:text-white rounded-lg text-xs font-semibold transition-all duration-200 active:scale-[0.98]">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-ink-600">Belum ada materi edukasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $materis->links() }}
    </div>
</div>

<x-modal-confirm />
@endsection
