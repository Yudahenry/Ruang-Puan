<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        // Tab peran: pengguna (default), konselor, atau admin
        $peran = in_array($request->query('peran'), ['pengguna', 'konselor', 'admin'], true)
            ? $request->query('peran')
            : 'pengguna';

        $users = User::where('role', $peran)->latest()->paginate(10)->withQueryString();

        // Jumlah akun per peran untuk label tab
        $jumlah = User::selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role');

        return view('admin.users.index', compact('users', 'peran', 'jumlah'));
    }

    public function toggleStatus($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Hanya admin yang boleh, dan akun admin tidak boleh dinonaktifkan (lihat UserPolicy)
        Gate::authorize('toggleStatus', $user);

        $statusBaru = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->forceFill(['status' => $statusBaru])->save();

        LogAktivitas::catat(
            $statusBaru === 'nonaktif' ? 'akun_dinonaktifkan_admin' : 'akun_diaktifkan_admin',
            'Status akun pengguna ID '.$user->id.' diubah oleh admin'
        );

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
