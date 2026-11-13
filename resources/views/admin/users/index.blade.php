@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Judul & Deskripsi -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Akun Pengguna & Konselor</h2>
        <p class="text-sm text-gray-600">Daftar seluruh akun yang terdaftar di dalam sistem Ruang Puan.</p>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Daftar Akun -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 font-semibold">
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role / Peran</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal Daftar</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4">{{ $users->firstItem() + $index }}</td>
                            <td class="p-4 font-medium text-gray-900">{{ $user->nama }}</td>
                            <td class="p-4 text-gray-600">{{ $user->email }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role == 'konselor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucwords($user->role ?? 'Pengguna') }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    {{ $user->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500">{{ $user->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                            <td class="p-4 text-center">
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-gray-400 italic">Akun Anda</span>
                                @elseif($user->role === 'admin')
                                    <span class="text-xs text-gray-400 italic">-</span>
                                @else
                                    <form action="{{ route('admin.users.status', $user->id) }}" method="POST"
                                          onsubmit="return confirm('{{ $user->status === 'aktif' ? 'Nonaktifkan akun ini? Pengguna akan keluar dari semua perangkat.' : 'Aktifkan kembali akun ini?' }}');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="px-3 py-1 rounded transition text-xs font-medium {{ $user->status === 'aktif' ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                                            {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Hapus disembunyikan sementara: aturan hapus akun (R08) menunggu keputusan tim --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500 italic">Belum ada akun pengguna yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
