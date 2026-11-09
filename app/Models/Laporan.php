<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';

    public const STATUS_LIST = [
        'diterima', 'diverifikasi', 'diproses', 'diteruskan_ke_lembaga', 'selesai', 'ditutup',
    ];

    // Langkah yang ditampilkan di stepper pelacakan
    public const LANGKAH = [
        'diterima', 'diverifikasi', 'diproses', 'diteruskan_ke_lembaga', 'selesai',
    ];

    protected $fillable = [
        'user_id',
        'ditangani_oleh',
        'kode_pelacakan',
        'jenis_kasus',
        'kronologi',
        'waktu_kejadian',
        'lokasi_kejadian',
        'anonim',
        'status',
    ];

    protected $casts = [
        'waktu_kejadian' => 'datetime',
        'anonim'         => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'ditangani_oleh');
    }

    public function buktiLaporans()
    {
        return $this->hasMany(BuktiLaporan::class);
    }

    public function tanggapanLaporans()
    {
        return $this->hasMany(TanggapanLaporan::class);
    }

    public static function labelStatus(?string $status): string
    {
        return match ($status) {
            'diterima'              => 'Diterima',
            'diverifikasi'          => 'Diverifikasi',
            'diproses'              => 'Diproses',
            'diteruskan_ke_lembaga' => 'Diteruskan ke Lembaga',
            'selesai'               => 'Selesai',
            'ditutup'               => 'Ditutup',
            default                 => ucfirst(str_replace('_', ' ', (string) $status)),
        };
    }

    public function statusLabel(): string
    {
        return self::labelStatus($this->status);
    }

    public function jenisKasusLabel(): string
    {
        return match ($this->jenis_kasus) {
            'kekerasan_fisik'   => 'Kekerasan Fisik',
            'kekerasan_psikis'  => 'Kekerasan Psikis',
            'kekerasan_seksual' => 'Kekerasan Seksual',
            'kdrt'              => 'KDRT',
            'kekerasan_online'  => 'Kekerasan Berbasis Online',
            'lainnya'           => 'Lainnya',
            default             => ucfirst(str_replace('_', ' ', (string) $this->jenis_kasus)),
        };
    }
}

class BuktiLaporan extends Model
{
    protected $table = 'bukti_laporans';

    // Tabel hanya punya created_at, tidak ada updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'laporan_id',
        'nama_file',
        'tipe_file',
        'ukuran_file',
        'lokasi_file',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}

class TanggapanLaporan extends Model
{
    protected $table = 'tanggapan_laporans';

    // Tabel hanya punya created_at, tidak ada updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'laporan_id',
        'admin_id',
        'isi_tanggapan',
        'status_laporan_saat_itu',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
