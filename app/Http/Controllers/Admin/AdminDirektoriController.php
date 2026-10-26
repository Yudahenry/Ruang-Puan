<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LembagaBantuan;
use Illuminate\Http\Request;

class AdminDirektoriController extends Controller
{
    public function index()
    {
        $lembagas = LembagaBantuan::with('admin.user')->latest()->paginate(10);
        return view('admin.direktori.index', compact('lembagas'));
    }

    public function create()
    {
        return view('admin.direktori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'jenis_layanan' => ['required', 'in:hotline,uptd_ppa,lbh,rumah_aman,lainnya'],
            'wilayah' => ['required', 'string', 'max:100'],
            'kontak' => ['nullable', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
        ]);

        LembagaBantuan::create([
            'nama' => $request->nama,
            'jenis_layanan' => $request->jenis_layanan,
            'wilayah' => $request->wilayah,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'dikelola_oleh' => auth()->user()->admin->id,
        ]);

        return redirect()->route('admin.direktori.index')->with('success', 'Lembaga bantuan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $lembaga = LembagaBantuan::findOrFail($id);
        $lembaga->delete();

        return redirect()->route('admin.direktori.index')->with('success', 'Lembaga bantuan berhasil dihapus.');
    }
}
