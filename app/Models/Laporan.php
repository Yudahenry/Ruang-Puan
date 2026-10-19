<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';

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
}

class BuktiLaporan extends Model
{
    protected $table = 'bukti_laporans';
    public $timestamps = false;

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
    public $timestamps = false;

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
