<?php

namespace Database\Seeders;

use App\Models\JadwalKonsultasi;
use App\Models\Konselor;
use App\Models\Konsultasi;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoKonsultasiSeeder extends Seeder
{
    public function run(): void
    {
        // Prioritas: konselor Rumah Aman Pulih; kalau belum ada, pakai konselor pertama
        $konselor = Konselor::whereHas('user', fn ($q) => $q->where('email', 'rumahamanpulih@ruangpuan.test'))->first()
            ?? Konselor::first();

        if (!$konselor) {
            $this->command->error('Belum ada data konselor di tabel konselors.');
            return;
        }

        $pengguna = User::where('id', '!=', $konselor->user_id)
            ->where(function ($q) {
                $q->where('role', 'pengguna')->orWhereNull('role');
            })
            ->latest('id')
            ->first()
            ?? User::where('id', '!=', $konselor->user_id)->latest('id')->first();

        if (!$pengguna) {
            $this->command->error('Belum ada akun pengguna.');
            return;
        }

        // Sesi aktif: mulai 10 menit lalu, selesai 3 jam lagi.
        // Kalau melewati tengah malam, dipotong sampai 23:59 supaya satu hari yang sama.
        $mulai   = now()->subMinutes(10);
        $selesai = now()->addHours(3);
        if (!$selesai->isSameDay($mulai)) {
            $selesai = $mulai->copy()->setTime(23, 59, 0);
        }

        $jadwal = JadwalKonsultasi::forceCreate([
            'konselor_id' => $konselor->id,
            'tanggal'     => $mulai->format('Y-m-d'),
            'jam_mulai'   => $mulai->format('H:i:s'),
            'jam_selesai' => $selesai->format('H:i:s'),
            'status'      => 'terpesan',
        ]);

        $pemesanan = Pemesanan::forceCreate([
            'user_id'   => $pengguna->id,
            'jadwal_id' => $jadwal->id,
            'status'    => 'terkonfirmasi',
        ]);

        Pembayaran::forceCreate([
            'pemesanan_id' => $pemesanan->id,
            'no_invoice'   => 'INV-DEMO-' . now()->format('YmdHis'),
            'jumlah'       => 150000,
            'metode'       => 'simulasi',
            'status'       => 'berhasil',
            'waktu_bayar'  => now(),
        ]);

        $konsultasi = Konsultasi::forceCreate([
            'pemesanan_id'       => $pemesanan->id,
            'tanggal_konsultasi' => $mulai->format('Y-m-d'),
            'jam_konsultasi'     => $mulai->format('H:i:s'),
            'status'             => 'berlangsung',
        ]);

        $this->command->info("Berhasil. Konsultasi ID {$konsultasi->id}, pengguna: {$pengguna->email}, konselor ID {$konselor->id}.");
    }
}
