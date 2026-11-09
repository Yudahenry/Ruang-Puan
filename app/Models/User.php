<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'alias',
        'role',
        'status',
        'email_verified_at',
        'no_hp',
        'kota',
        'provinsi',
        'kontak_darurat_nama',
        'kontak_darurat_nomor',
        'mode_lapor_default',
        'notif_status_laporan',
        'notif_pengingat_konsultasi',
        'notif_pembayaran',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // Data sensitif dienkripsi di database
            'no_hp' => 'encrypted',
            'kontak_darurat_nama' => 'encrypted',
            'kontak_darurat_nomor' => 'encrypted',
            'notif_status_laporan' => 'boolean',
            'notif_pengingat_konsultasi' => 'boolean',
            'notif_pembayaran' => 'boolean',
        ];
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function konselor()
    {
        return $this->hasOne(Konselor::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }
}