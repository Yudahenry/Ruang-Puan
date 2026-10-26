<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Menegaskan bahwa kolom identifikasi untuk login adalah 'email'.
     */
    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'ditangani_oleh');
    }

    public function konselors()
    {
        return $this->hasMany(Konselor::class, 'diverifikasi_oleh');
    }
}