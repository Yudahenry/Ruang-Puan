<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function index()
    {
        // Ambil daftar seluruh user (pengguna dan konselor) dengan pagination
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Akun admin tidak boleh dinonaktifkan dari halaman ini
        abort_if($user->role === 'admin', 403);

        $statusBaru = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->forceFill(['status' => $statusBaru])->save();

        // Akun yang dinonaktifkan langsung keluar dari semua perangkat
        if ($statusBaru === 'nonaktif') {
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        $pesan = $statusBaru === 'nonaktif'
            ? 'Akun berhasil dinonaktifkan.'
            : 'Akun berhasil diaktifkan kembali.';

        return redirect()->route('admin.users.index')->with('success', $pesan);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
