<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    protected $table = 'konselors';

    protected $fillable = [
        'user_id',
        'no_str',
        'no_sipp',
        'bidang_keahlian',
        'tarif',
        'dokumen_verifikasi',
        'status_verifikasi',
        'diverifikasi_oleh',
        'diverifikasi_at',
        'alasan_penolakan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'diverifikasi_oleh');
    }

    public function jadwalKonsultasis()
    {
        return $this->hasMany(JadwalKonsultasi::class);
    }
}
