<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ditangani_oleh')->nullable()->constrained('admins')->onDelete('set null');
            $table->string('kode_pelacakan', 20)->unique();
            $table->enum('jenis_kasus', ['kekerasan_fisik', 'kekerasan_psikis', 'kekerasan_seksual', 'kdrt', 'kekerasan_online', 'lainnya']);
            $table->text('kronologi');
            $table->dateTime('waktu_kejadian')->nullable();
            $table->string('lokasi_kejadian', 255)->nullable();
            $table->boolean('anonim')->default(false);
            $table->enum('status', ['diterima', 'diverifikasi', 'diproses', 'diteruskan_ke_lembaga', 'selesai', 'ditutup'])->default('diterima');
            $table->timestamps();

            $table->index('status', 'idx_laporan_status');
            $table->index('kode_pelacakan', 'idx_laporan_kode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
