@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-3xl shadow-sm border border-cream-200 p-8">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-berry-900">
                Kelola Direktori Lembaga Bantuan
            </h1>
            <p class="text-sm text-ink-600 mt-1">
                Tambah dan kelola daftar lembaga mitra, UPTD PPA, LBH, dan rumah aman.
            </p>
        </div>

        <a href="{{ route('admin.direktori.create') }}"
           class="px-4 py-2 bg-berry-700 hover:bg-berry-900 text-white font-medium rounded-xl text-sm">
            + Tambah Lembaga
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-cream-100 text-ink-900 border-b border-cream-200">
                    <th class="p-3">Nama Lembaga</th>
                    <th class="p-3">Jenis Layanan</th>
                    <th class="p-3">Wilayah</th>
                    <th class="p-3">Kontak</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-cream-200">
                @forelse($lembagas as $lembaga)
                    <tr class="hover:bg-cream-50">
                        <td class="p-3 font-medium text-berry-900">
                            {{ $lembaga->nama }}
                        </td>

                        <td class="p-3">
                            {{ strtoupper(str_replace('_', ' ', $lembaga->jenis_layanan)) }}
                        </td>

                        <td class="p-3">
                            {{ $lembaga->wilayah }}
                        </td>

                        <td class="p-3">
                            {{ $lembaga->kontak ?? '-' }}
                        </td>

                        <td class="p-3">
                            @if($lembaga->status === 'aktif')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('admin.direktori.edit', $lembaga->id) }}"
                                   class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 text-xs font-semibold">
                                    Edit
                                </a>

                                <form action="{{ route('admin.direktori.toggle-status', $lembaga->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="px-3 py-1 rounded-lg text-xs font-semibold
                                            {{ $lembaga->status === 'aktif'
                                                ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'
                                                : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        {{ $lembaga->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.direktori.destroy', $lembaga->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus lembaga ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-3 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 text-xs font-semibold">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-ink-600">
                            Belum ada lembaga bantuan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $lembagas->links() }}
    </div>

</div>
@endsection
