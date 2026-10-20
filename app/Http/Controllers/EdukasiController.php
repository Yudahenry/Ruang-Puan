<?php

namespace App\Http\Controllers;

use App\Models\KategoriEdukasi;
use App\Models\MateriEdukasi;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->get('kategori');
        $search = $request->get('search');

        $kategoris = KategoriEdukasi::withCount('materiEdukasis')->get();

        $query = MateriEdukasi::with(['kategoriEdukasi', 'admin.user'])
            ->where('status', 'terbit')
            ->latest('tanggal_posting');

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        $materis = $query->paginate(9)->withQueryString();

        return view('edukasi.index', compact('materis', 'kategoris', 'kategoriId', 'search'));
    }

    public function show($id)
    {
        $materi = MateriEdukasi::with(['kategoriEdukasi', 'admin.user'])
            ->where('status', 'terbit')
            ->findOrFail($id);

        $relatedMateris = MateriEdukasi::where('status', 'terbit')
            ->where('kategori_id', $materi->kategori_id)
            ->where('id', '!=', $materi->id)
            ->latest()
            ->take(3)
            ->get();

        return view('edukasi.show', compact('materi', 'relatedMateris'));
    }
}
