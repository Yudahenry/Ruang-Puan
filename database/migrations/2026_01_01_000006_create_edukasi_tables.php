<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_edukasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 100)->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('materi_edukasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_edukasis')->onDelete('restrict');
            $table->foreignId('dikelola_oleh')->constrained('admins')->onDelete('cascade');
            $table->string('judul', 200);
            $table->longText('isi');
            $table->enum('jenis_konten', ['artikel', 'infografis', 'video'])->default('artikel');
            $table->string('file_url', 255)->nullable();
            $table->enum('status', ['draft', 'terbit'])->default('draft');
            $table->timestamp('tanggal_posting')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi_edukasis');
        Schema::dropIfExists('kategori_edukasis');
    }
};
