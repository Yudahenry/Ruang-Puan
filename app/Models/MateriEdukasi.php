<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriEdukasi extends Model
{
    protected $table = 'materi_edukasis';

    protected $fillable = [
        'kategori_id',
        'dikelola_oleh',
        'judul',
        'isi',
        'jenis_konten',
        'file_url',
        'status',
        'tanggal_posting',
    ];

    public function kategoriEdukasi()
    {
        return $this->belongsTo(KategoriEdukasi::class, 'kategori_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'dikelola_oleh');
    }
}
