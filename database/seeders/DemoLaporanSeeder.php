<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Laporan;
use App\Models\TanggapanLaporan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = User::where('email', 'mubaroksubki@gmail.com')->first()
            ?? User::where('role', 'pengguna')->latest('id')->first();

        if (!$pengguna) {
            $this->command->error('Belum ada akun pengguna.');
            return;
        }

        $admin = Admin::first();
        if (!$admin) {
            $this->command->warn('Belum ada data admin, tanggapan tidak dibuat (hanya laporan berstatus diterima).');
        }

        $data = [
            [
                'jenis' => 'kekerasan_online', 'anonim' => true, 'status' => 'diterima',
                'lokasi' => 'Surabaya', 'hari' => 1,
                'kronologi' => 'Saya menerima pesan ancaman berulang dari akun tidak dikenal di media sosial.',
                'tanggapan' => [],
            ],
            [
                'jenis' => 'kekerasan_psikis', 'anonim' => false, 'status' => 'diproses',
                'lokasi' => 'Sidoarjo', 'hari' => 5,
                'kronologi' => 'Mengalami intimidasi dan tekanan psikologis dari atasan di tempat kerja.',
                'tanggapan' => [
                    ['diverifikasi', 'Laporan Anda sudah kami periksa dan dinyatakan lengkap.', 4],
                    ['diproses', 'Laporan sedang kami tindaklanjuti. Mohon tunggu kabar berikutnya.', 2],
                ],
            ],
            [
                'jenis' => 'kdrt', 'anonim' => true, 'status' => 'selesai',
                'lokasi' => 'Gresik', 'hari' => 14,
                'kronologi' => 'Kekerasan dalam rumah tangga yang terjadi berulang kali.',
                'tanggapan' => [
                    ['diverifikasi', 'Laporan diverifikasi oleh tim kami.', 13],
                    ['diteruskan_ke_lembaga', 'Laporan diteruskan ke Rumah Aman Pulih untuk pendampingan.', 10],
                    ['selesai', 'Pendampingan telah berjalan dan kasus dinyatakan selesai ditangani.', 3],
                ],
            ],
        ];

        foreach ($data as $d) {
            $dibuat = now()->subDays($d['hari']);

            $laporan = Laporan::forceCreate([
                'user_id'         => $pengguna->id,
                'ditangani_oleh'  => $admin && count($d['tanggapan']) ? $admin->id : null,
                'kode_pelacakan'  => 'RP-' . strtoupper(Str::random(8)),
                'jenis_kasus'     => $d['jenis'],
                'kronologi'       => $d['kronologi'],
                'waktu_kejadian'  => $dibuat->copy()->subDay(),
                'lokasi_kejadian' => $d['lokasi'],
                'anonim'          => $d['anonim'],
                'status'          => $admin ? $d['status'] : 'diterima',
                'created_at'      => $dibuat,
                'updated_at'      => $dibuat,
            ]);

            if ($admin) {
                foreach ($d['tanggapan'] as [$status, $isi, $hariLalu]) {
                    TanggapanLaporan::forceCreate([
                        'laporan_id'              => $laporan->id,
                        'admin_id'                => $admin->id,
                        'isi_tanggapan'           => $isi,
                        'status_laporan_saat_itu' => $status,
                        'created_at'              => now()->subDays($hariLalu),
                    ]);
                }
            }
        }

        $this->command->info("Berhasil membuat 3 laporan contoh untuk {$pengguna->email}.");
    }
}
