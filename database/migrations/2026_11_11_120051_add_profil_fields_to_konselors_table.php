<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konselors', function (Blueprint $table) {
            // Identitas profesional
            $table->string('gelar', 100)->nullable();
            $table->text('bio')->nullable();
            $table->text('pendidikan')->nullable();
            $table->unsignedSmallInteger('pengalaman_tahun')->nullable();
            $table->string('bahasa', 150)->nullable();

            // Kredensial
            $table->date('masa_berlaku_str')->nullable();
            $table->date('masa_berlaku_sipp')->nullable();
            $table->string('dokumen_ijazah')->nullable();

            // Layanan
            $table->json('spesialisasi')->nullable();
            $table->unsignedSmallInteger('durasi_sesi')->nullable();
            $table->text('kebijakan_pembatalan')->nullable();

            // Rekening pencairan (nomor dan atas nama terenkripsi)
            $table->string('rekening_bank', 50)->nullable();
            $table->text('rekening_nomor')->nullable();
            $table->text('rekening_atas_nama')->nullable();

            // Persetujuan kode etik
            $table->timestamp('kode_etik_disetujui_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('konselors', function (Blueprint $table) {
            $table->dropColumn([
                'gelar', 'bio', 'pendidikan', 'pengalaman_tahun', 'bahasa',
                'masa_berlaku_str', 'masa_berlaku_sipp', 'dokumen_ijazah',
                'spesialisasi', 'durasi_sesi', 'kebijakan_pembatalan',
                'rekening_bank', 'rekening_nomor', 'rekening_atas_nama',
                'kode_etik_disetujui_at',
            ]);
        });
    }
};
