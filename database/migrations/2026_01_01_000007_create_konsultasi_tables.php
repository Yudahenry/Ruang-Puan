<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_konsultasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konselor_id')->constrained('konselors')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status', ['tersedia', 'terpesan', 'nonaktif'])->default('tersedia');
            $table->timestamps();

            $table->unique(['konselor_id', 'tanggal', 'jam_mulai'], 'uq_jadwal_slot');
        });

        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('jadwal_konsultasis')->onDelete('cascade');
            $table->enum('status', ['menunggu_pembayaran', 'terkonfirmasi', 'batal'])->default('menunggu_pembayaran');
            $table->timestamps();

            $table->unique('jadwal_id', 'uq_pemesanan_jadwal');
        });

        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->string('no_invoice', 50)->unique();
            $table->decimal('jumlah', 10, 2);
            $table->string('metode', 50)->nullable();
            $table->enum('status', ['menunggu', 'berhasil', 'gagal'])->default('menunggu');
            $table->timestamp('waktu_bayar')->nullable();
            $table->json('payload_gateway')->nullable();
            $table->timestamps();

            $table->unique('pemesanan_id', 'uq_pembayaran_pemesanan');
        });

        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->date('tanggal_konsultasi');
            $table->time('jam_konsultasi');
            $table->enum('status', ['terjadwal', 'berlangsung', 'selesai', 'batal'])->default('terjadwal');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique('pemesanan_id', 'uq_konsultasi_pemesanan');
        });

        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konsultasi_id')->constrained('konsultasis')->onDelete('cascade');
            $table->foreignId('pengirim_id')->constrained('users')->onDelete('cascade');
            $table->text('isi_pesan');
            $table->timestamp('waktu_kirim');

            $table->index(['konsultasi_id', 'waktu_kirim'], 'idx_pesan_konsultasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesans');
        Schema::dropIfExists('konsultasis');
        Schema::dropIfExists('pembayarans');
        Schema::dropIfExists('pemesanans');
        Schema::dropIfExists('jadwal_konsultasis');
    }
};
