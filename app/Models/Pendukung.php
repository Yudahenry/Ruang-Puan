<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'jenis',
        'isi',
        'saluran',
        'status_baca',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'aktivitas',
        'keterangan',
        'ip_address',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
