<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konselors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_str', 50)->nullable();
            $table->string('no_sipp', 50)->nullable();
            $table->string('bidang_keahlian', 150)->nullable();
            $table->decimal('tarif', 10, 2)->default(0);
            $table->string('dokumen_verifikasi', 255)->nullable();
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamp('diverifikasi_at')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
            $table->unique('user_id', 'uq_konselor_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konselors');
    }
};
