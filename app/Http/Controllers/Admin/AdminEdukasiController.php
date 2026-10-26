<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriEdukasi;
use App\Models\MateriEdukasi;
use Illuminate\Http\Request;

class AdminEdukasiController extends Controller
{
    public function index()
    {
        $kategoris = KategoriEdukasi::withCount('materiEdukasis')->get();
        $materis = MateriEdukasi::with(['kategoriEdukasi', 'admin.user'])->latest()->paginate(10);
        return view('admin.edukasi.index', compact('kategoris', 'materis'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategori_edukasis'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        KategoriEdukasi::create($request->only(['nama_kategori', 'deskripsi']));

        return redirect()->route('admin.edukasi.index')->with('success', 'Kategori edukasi berhasil ditambahkan.');
    }

    public function createMateri()
    {
        $kategoris = KategoriEdukasi::all();
        return view('admin.edukasi.create-materi', compact('kategoris'));
    }

    public function storeMateri(Request $request)
    {
        $request->validate([
            'kategori_id' => ['required', 'exists:kategori_edukasis,id'],
            'judul' => ['required', 'string', 'max:200'],
            'isi' => ['required', 'string'],
            'jenis_konten' => ['required', 'in:artikel,infografis,video'],
            'file_url' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,terbit'],
        ]);

        MateriEdukasi::create([
            'kategori_id' => $request->kategori_id,
            'dikelola_oleh' => auth()->user()->admin->id,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'jenis_konten' => $request->jenis_konten,
            'file_url' => $request->file_url,
            'status' => $request->status,
            'tanggal_posting' => $request->status === 'terbit' ? now() : null,
        ]);

        return redirect()->route('admin.edukasi.index')->with('success', 'Materi edukasi berhasil dibuat.');
    }

    public function destroyMateri($id)
    {
        $materi = MateriEdukasi::findOrFail($id);
        $materi->delete();

        return redirect()->route('admin.edukasi.index')->with('success', 'Materi edukasi berhasil dihapus.');
    }
}
