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
        'total_biaya',
        'status_pembayaran',
        'metode_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi utama ke JadwalKonsultasi
    public function jadwalKonsultasi()
    {
        return $this->belongsTo(JadwalKonsultasi::class, 'jadwal_id');
    }

    // Alias 'jadwal' agar kompatibel dengan Controller yang memanggil with('jadwal')
    public function jadwal()
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