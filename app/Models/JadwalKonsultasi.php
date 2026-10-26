<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKonsultasi extends Model
{
    protected $table = 'jadwal_konsultasis';

    protected $fillable = [
        'konselor_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    public function konselor()
    {
        return $this->belongsTo(Konselor::class);
    }

    public function pemesanan()
    {
        return $this->hasOne(Pemesanan::class, 'jadwal_id');
    }
}
