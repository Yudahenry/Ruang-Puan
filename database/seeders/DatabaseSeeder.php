<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\KategoriEdukasi;
use App\Models\LembagaBantuan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Default
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@ruangpuan.test'],
            [
                'nama' => 'Administrator Utama',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        $admin = Admin::firstOrCreate(['user_id' => $adminUser->id]);

        // 2. 4 Kategori Edukasi Awal
        $kategoris = [
            [
                'nama_kategori' => 'Hak Perempuan',
                'deskripsi' => 'Materi seputar perlindungan hukum, kesetaraan hak, dan pemenuhan keadilan bagi perempuan.',
            ],
            [
                'nama_kategori' => 'Kesehatan Reproduksi',
                'deskripsi' => 'Edukasi kesehatan fisik dan mental reproduksi perempuan secara komprehensif dan aman.',
            ],
            [
                'nama_kategori' => 'Pencegahan Kekerasan',
                'deskripsi' => 'Panduan mengenali tanda-tanda kekerasan, KDRT, dan langkah awal mitigasi risiko.',
            ],
            [
                'nama_kategori' => 'Pengembangan Karier',
                'deskripsi' => 'Tips peningkatan kapasitas diri, kemandirian ekonomi, dan pemberdayaan karier perempuan.',
            ],
        ];

        foreach ($kategoris as $kat) {
            KategoriEdukasi::firstOrCreate(
                ['nama_kategori' => $kat['nama_kategori']],
                ['deskripsi' => $kat['deskripsi']]
            );
        }

        // 3. Contoh Lembaga Bantuan
        $lembagas = [
            [
                'nama' => 'Hotline Sahabat Perempuan dan Anak (SAPA 129)',
                'jenis_layanan' => 'hotline',
                'wilayah' => 'Nasional',
                'kontak' => '129 / 0821-1111-1129',
                'alamat' => 'Kementerian PPPA Republik Indonesia, Jakarta Pusat',
                'dikelola_oleh' => $admin->id,
            ],
            [
                'nama' => 'UPTD PPA Provinsi DKI Jakarta',
                'jenis_layanan' => 'uptd_ppa',
                'wilayah' => 'DKI Jakarta',
                'kontak' => '0813-8000-8000',
                'alamat' => 'Jl. Kademangan No. 1, Jakarta',
                'dikelola_oleh' => $admin->id,
            ],
            [
                'nama' => 'LBH APIK Jakarta',
                'jenis_layanan' => 'lbh',
                'wilayah' => 'DKI Jakarta & Sekitarnya',
                'kontak' => '021-87793395',
                'alamat' => 'Jl. Raya Condet No. 5 Gang Kalilio, Kramat Jati, Jakarta Timur',
                'dikelola_oleh' => $admin->id,
            ],
            [
                'nama' => 'Rumah Aman Pulih',
                'jenis_layanan' => 'rumah_aman',
                'wilayah' => 'Jabodetabek',
                'kontak' => '0812-3456-7890',
                'alamat' => 'Rahasia (Demi keamanan penyintas)',
                'dikelola_oleh' => $admin->id,
            ],
        ];

        foreach ($lembagas as $lembaga) {
            LembagaBantuan::firstOrCreate(
                ['nama' => $lembaga['nama']],
                $lembaga
            );
        }
    }
}
