<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriEdukasi extends Model
{
    protected $table = 'kategori_edukasis';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function materiEdukasis()
    {
        return $this->hasMany(MateriEdukasi::class, 'kategori_id');
    }
}
