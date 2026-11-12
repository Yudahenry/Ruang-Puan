<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    use HasFactory;

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
        'gelar',
        'bio',
        'pendidikan',
        'pengalaman_tahun',
        'bahasa',
        'masa_berlaku_str',
        'masa_berlaku_sipp',
        'dokumen_ijazah',
        'spesialisasi',
        'durasi_sesi',
        'kebijakan_pembatalan',
        'rekening_bank',
        'rekening_nomor',
        'rekening_atas_nama',
        'kode_etik_disetujui_at',
    ];

    protected $casts = [
        'spesialisasi' => 'array',
        'masa_berlaku_str' => 'date',
        'masa_berlaku_sipp' => 'date',
        'rekening_nomor' => 'encrypted',
        'rekening_atas_nama' => 'encrypted',
        'kode_etik_disetujui_at' => 'datetime',
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
