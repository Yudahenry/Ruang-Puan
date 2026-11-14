<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * Catat satu aktivitas. Jangan isi keterangan dengan data sensitif
     * (kata sandi, nomor rekening, dsb.), cukup catat BAHWA sesuatu berubah.
     */
    public static function catat(string $aktivitas, ?string $keterangan = null, ?int $userId = null): self
    {
        return static::create([
            'user_id' => $userId ?? auth()->id(),
            'aktivitas' => $aktivitas,
            'keterangan' => $keterangan,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
