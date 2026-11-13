<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
