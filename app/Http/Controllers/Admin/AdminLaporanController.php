<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\TanggapanLaporan;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $query = Laporan::with('user')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $laporans = $query->paginate(15);
        return view('admin.laporan.index', compact('laporans', 'status'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['user', 'buktiLaporans', 'tanggapanLaporans.admin.user'])->findOrFail($id);
        return view('admin.laporan.show', compact('laporan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:diterima,diverifikasi,diproses,diteruskan_ke_lembaga,selesai,ditutup'],
            'isi_tanggapan' => ['nullable', 'string'],
        ]);

        $laporan = Laporan::findOrFail($id);
        $oldStatus = $laporan->status;

        $laporan->update([
            'status' => $request->status,
            'ditangani_oleh' => auth()->user()->admin->id ?? $laporan->ditangani_oleh,
        ]);

        if ($request->filled('isi_tanggapan')) {
            TanggapanLaporan::create([
                'laporan_id' => $laporan->id,
                'admin_id' => auth()->user()->admin->id,
                'isi_tanggapan' => $request->isi_tanggapan,
                'status_laporan_saat_itu' => $request->status,
            ]);
        }

        return redirect()->route('admin.laporan.show', $laporan->id)
                         ->with('success', 'Status laporan berhasil diperbarui.');
    }
}
