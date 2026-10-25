<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use Illuminate\Http\Request;

class VerifikasiKonselorController extends Controller
{
    public function index()
    {
        $konselors = Konselor::with('user')->where('status_verifikasi', 'pending')->get();
        
        return view('admin.verifikasi-konselor.index', compact('konselors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:approved,rejected',
        ]);

        $konselor = Konselor::findOrFail($id);
        
        $konselor->update([
            'status_verifikasi' => $request->status_verifikasi,
            'admin_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Status verifikasi konselor berhasil diperbarui.');
    }
}
