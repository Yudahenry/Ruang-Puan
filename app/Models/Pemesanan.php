<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalKonsultasi()
    {
        return $this->belongsTo(JadwalKonsultasi::class, 'jadwal_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function konsultasi()
    {
        return $this->hasOne(Konsultasi::class);
    }
}