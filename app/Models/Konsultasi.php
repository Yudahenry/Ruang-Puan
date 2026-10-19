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

class Pemesanan extends Model
{
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

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'pemesanan_id',
        'no_invoice',
        'jumlah',
        'metode',
        'status',
        'waktu_bayar',
        'payload_gateway',
    ];

    protected $casts = [
        'payload_gateway' => 'array',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}

class Konsultasi extends Model
{
    protected $table = 'konsultasis';

    protected $fillable = [
        'pemesanan_id',
        'tanggal_konsultasi',
        'jam_konsultasi',
        'status',
        'catatan',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function pesans()
    {
        return $this->hasMany(Pesan::class);
    }
}

class Pesan extends Model
{
    protected $table = 'pesans';
    public $timestamps = false;

    protected $fillable = [
        'konsultasi_id',
        'pengirim_id',
        'isi_pesan',
        'waktu_kirim',
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
}
