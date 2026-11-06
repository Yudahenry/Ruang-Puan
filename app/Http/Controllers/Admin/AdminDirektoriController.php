<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LembagaBantuan;
use Illuminate\Http\Request;

class AdminDirektoriController extends Controller
{
    public function index()
    {
        $lembagas = LembagaBantuan::with('admin.user')
            ->latest()
            ->paginate(10);

        return view('admin.direktori.index', compact('lembagas'));
    }

    public function create()
    {
        return view('admin.direktori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'jenis_layanan' => ['required', 'in:hotline,uptd_ppa,lbh,rumah_aman,lainnya'],
            'wilayah' => ['required', 'string', 'max:100'],
            'kontak' => ['nullable', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $validated['status'] = 'aktif';

        // Ambil ID integer tabel admins untuk foreign key 'dikelola_oleh'
        $adminId = null;
        if (auth()->guard('admin')->check()) {
            $adminModel = auth()->guard('admin')->user();
            $adminId = $adminModel->id ?? \App\Models\Admin::where('email', $adminModel->email)->value('id');
        } elseif (auth()->user()) {
            $adminId = auth()->user()->admin->id ?? \App\Models\Admin::where('user_id', auth()->id())->value('id');
        }

        // Fallback jika belum terelasi ke tabel admins, ambil admin pertama
        if (!$adminId || !is_numeric($adminId)) {
            $adminId = \App\Models\Admin::value('id');
        }

        $validated['dikelola_oleh'] = $adminId;

        LembagaBantuan::create($validated);

        return redirect()->route('admin.direktori.index')
            ->with('success', 'Layanan bantuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lembaga = LembagaBantuan::findOrFail($id);

        return view('admin.direktori.edit', compact('lembaga'));
    }

    public function update(Request $request, $id)
    {
        $lembaga = LembagaBantuan::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'jenis_layanan' => ['required', 'in:hotline,uptd_ppa,lbh,rumah_aman,lainnya'],
            'wilayah' => ['required', 'string', 'max:100'],
            'kontak' => ['nullable', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $lembaga->update($validated);

        return redirect()->route('admin.direktori.index')
            ->with('success', 'Layanan bantuan berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $lembaga = LembagaBantuan::findOrFail($id);

        $lembaga->update([
            'status' => $lembaga->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        return redirect()->route('admin.direktori.index')
            ->with('success', 'Status layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lembaga = LembagaBantuan::findOrFail($id);
        $lembaga->delete();

        return redirect()->route('admin.direktori.index')
            ->with('success', 'Layanan bantuan berhasil dihapus.');
    }
}
