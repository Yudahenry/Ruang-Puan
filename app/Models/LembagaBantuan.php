<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LembagaBantuan extends Model
{
    protected $table = 'lembaga_bantuans';

    protected $fillable = [
        'nama',
        'jenis_layanan',
        'wilayah',
        'kontak',
        'alamat',
        'dikelola_oleh',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'dikelola_oleh');
    }
}
