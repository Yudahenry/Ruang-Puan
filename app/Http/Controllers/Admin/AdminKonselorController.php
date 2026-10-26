<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use Illuminate\Http\Request;

class AdminKonselorController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'menunggu');
        $query = Konselor::with('user')->latest();

        if ($status && in_array($status, ['menunggu', 'disetujui', 'ditolak'])) {
            $query->where('status_verifikasi', $status);
        }

        $konselors = $query->paginate(10)->withQueryString();

        return view('admin.konselor.index', compact('konselors', 'status'));
    }

    public function verifikasi(Request $request, $id)
    {
        $konselor = Konselor::findOrFail($id);
        $admin = auth()->user()->admin;

        $konselor->update([
            'status_verifikasi' => 'disetujui',
            'diverifikasi_oleh' => $admin ? $admin->id : null,
            'diverifikasi_at' => now(),
            'alasan_penolakan' => null,
        ]);

        return back()->with('success', 'Pengajuan konselor berhasil disetujui.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'max:500'],
        ]);

        $konselor = Konselor::findOrFail($id);
        $admin = auth()->user()->admin;

        $konselor->update([
            'status_verifikasi' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'diverifikasi_oleh' => $admin ? $admin->id : null,
            'diverifikasi_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan konselor telah ditolak.');
    }
}
