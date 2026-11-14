<?php

namespace App\Http\Controllers;

use App\Models\LembagaBantuan;
use Illuminate\Http\Request;

class DirektoriController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->get('jenis');
        $wilayah = $request->get('wilayah');
        $search = $request->get('search');

        // Pengguna hanya dapat melihat lembaga yang aktif.
        $query = LembagaBantuan::where('status', 'aktif');

        if ($jenis) {
            $query->where('jenis_layanan', $jenis);
        }

        if ($wilayah) {
            $query->where('wilayah', 'like', "%{$wilayah}%");
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('kontak', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $lembagas = $query->latest()->paginate(10)->withQueryString();

        // Pilihan wilayah hanya berasal dari lembaga aktif.
        $wilayahs = LembagaBantuan::where('status', 'aktif')
            ->whereNotNull('wilayah')
            ->distinct()
            ->orderBy('wilayah')
            ->pluck('wilayah');

        return view('direktori.index', compact(
            'lembagas',
            'wilayahs',
            'jenis',
            'wilayah',
            'search'
        ));
    }
}
