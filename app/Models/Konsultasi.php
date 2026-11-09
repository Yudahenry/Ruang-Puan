<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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

    public function getJadwalAttribute()
    {
        return $this->pemesanan?->jadwalKonsultasi;
    }

    public function waktuMulai(): ?Carbon
    {
        $j = $this->jadwal;
        if (!$j) {
            return null;
        }
        return Carbon::parse(Carbon::parse($j->tanggal)->format('Y-m-d') . ' ' . $j->jam_mulai);
    }

    public function waktuSelesai(): ?Carbon
    {
        $j = $this->jadwal;
        if (!$j) {
            return null;
        }

        $tanggal = Carbon::parse($j->tanggal)->format('Y-m-d');
        $selesai = Carbon::parse($tanggal . ' ' . $j->jam_selesai);
        $mulai   = Carbon::parse($tanggal . ' ' . $j->jam_mulai);

        // Jika jam selesai lebih kecil dari jam mulai, berarti sesi melewati tengah malam
        if ($selesai->lessThanOrEqualTo($mulai)) {
            $selesai->addDay();
        }

        return $selesai;
    }

    // Chat hanya aktif: sudah dibayar/terkonfirmasi, belum batal/selesai, dan sedang di jam sesi (FR-16)
    public function sesiAktif(): bool
    {
        if (in_array($this->status, ['batal', 'selesai'])) {
            return false;
        }
        if ($this->pemesanan?->status !== 'terkonfirmasi') {
            return false;
        }
        $mulai = $this->waktuMulai();
        $selesai = $this->waktuSelesai();
        return $mulai && $selesai && now()->between($mulai, $selesai);
    }

    public function sesiBerakhir(): bool
    {
        if ($this->status === 'selesai') {
            return true;
        }
        $selesai = $this->waktuSelesai();
        return $selesai && now()->greaterThan($selesai);
    }

    // Status yang ditampilkan: terjadwal | berlangsung | selesai | batal
    public function getStatusEfektifAttribute(): string
    {
        if ($this->status === 'batal') {
            return 'batal';
        }
        if ($this->sesiBerakhir()) {
            return 'selesai';
        }
        if ($this->sesiAktif()) {
            return 'berlangsung';
        }
        return 'terjadwal';
    }
}
