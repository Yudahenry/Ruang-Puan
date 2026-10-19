<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade');
            $table->string('nama_file', 255);
            $table->string('tipe_file', 50);
            $table->unsignedInteger('ukuran_file');
            $table->string('lokasi_file', 255);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('tanggapan_laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->text('isi_tanggapan');
            $table->string('status_laporan_saat_itu', 50);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('lembaga_bantuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->enum('jenis_layanan', ['hotline', 'uptd_ppa', 'lbh', 'rumah_aman', 'lainnya']);
            $table->string('wilayah', 100);
            $table->string('kontak', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('dikelola_oleh')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamps();

            $table->index('wilayah', 'idx_lembaga_wilayah');
            $table->index('jenis_layanan', 'idx_lembaga_jenis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembaga_bantuans');
        Schema::dropIfExists('tanggapan_laporans');
        Schema::dropIfExists('bukti_laporans');
    }
};
