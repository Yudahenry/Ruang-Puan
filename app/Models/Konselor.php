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

    /**
     * Memeriksa dan mengembalikan rincian status kelengkapan profil serta kredensial konselor.
     *
     * @return array{is_lengkap: bool, persentase: int, terisi: int, total: int, missing: array<string, string>}
     */
    public function kelengkapanProfil(): array
    {
        // Daftar field wajib profil dan kredensial legalitas konselor
        $fieldsWajib = [
            'gelar'                  => 'Gelar Profesi (contoh: M.Psi., Psikolog)',
            'bio'                    => 'Bio / Deskripsi Profil Diri',
            'pendidikan'             => 'Riwayat Pendidikan',
            'pengalaman_tahun'       => 'Pengalaman Praktik (Tahun)',
            'spesialisasi'           => 'Bidang Spesialisasi / Keahlian',
            'durasi_sesi'            => 'Durasi Sesi Konsultasi',
            'tarif'                  => 'Tarif Sesi Konsultasi',
            'no_str'                 => 'Nomor STR (Surat Tanda Registrasi)',
            'no_sipp'                => 'Nomor SIPP (Surat Izin Praktik Psikologi)',
            'dokumen_verifikasi'     => 'Dokumen Bukti STR / SIPP',
            'rekening_bank'          => 'Nama Bank Rekening',
            'rekening_nomor'         => 'Nomor Rekening',
            'rekening_atas_nama'     => 'Nama Pemilik Rekening',
            'kode_etik_disetujui_at' => 'Persetujuan Kode Etik & Kerahasiaan',
        ];

        $missing = [];

        foreach ($fieldsWajib as $field => $label) {
            try {
                $value = $this->getAttribute($field);
            } catch (\Throwable $e) {
                $value = null;
            }

            // Pengecekan spesialisasi: bisa dari array 'spesialisasi' atau string 'bidang_keahlian'
            if ($field === 'spesialisasi') {
                $hasSpesialisasi = (!empty($value) && (is_array($value) ? count($value) > 0 : true)) 
                                || !empty($this->getAttribute('bidang_keahlian'));
                if (!$hasSpesialisasi) {
                    $missing[$field] = $label;
                }
                continue;
            }

            // Pengecekan angka numerik (0 tahun pengalaman atau tarif bernilai 0 tetap dicek apakah diset)
            if (in_array($field, ['pengalaman_tahun', 'tarif'], true)) {
                if ($value === null || $value === '' || (is_numeric($value) && $value < 0)) {
                    $missing[$field] = $label;
                }
                continue;
            }

            // Pengecekan umum (string, file path, tanggal, atau array)
            if (is_null($value) || (is_string($value) && trim($value) === '') || (is_array($value) && empty($value))) {
                $missing[$field] = $label;
            }
        }

        $totalWajib = count($fieldsWajib);
        $terisi = $totalWajib - count($missing);
        $persentase = (int) round(($terisi / $totalWajib) * 100);

        return [
            'is_lengkap' => empty($missing),
            'persentase' => $persentase,
            'terisi'     => $terisi,
            'total'      => $totalWajib,
            'missing'    => $missing,
        ];
    }

    /**
     * Helper boolean praktis untuk mengetahui apakah profil dan kredensial konselor sudah 100% lengkap.
     */
    public function isProfilLengkap(): bool
    {
        return $this->kelengkapanProfil()['is_lengkap'];
    }
}
