<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom terenkripsi disimpan sebagai text (hasil enkripsi panjang)
            $table->text('no_hp')->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->text('kontak_darurat_nama')->nullable();
            $table->text('kontak_darurat_nomor')->nullable();

            $table->string('mode_lapor_default', 20)->default('anonim');

            $table->boolean('notif_status_laporan')->default(true);
            $table->boolean('notif_pengingat_konsultasi')->default(true);
            $table->boolean('notif_pembayaran')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'no_hp',
                'kota',
                'provinsi',
                'kontak_darurat_nama',
                'kontak_darurat_nomor',
                'mode_lapor_default',
                'notif_status_laporan',
                'notif_pengingat_konsultasi',
                'notif_pembayaran',
            ]);
        });
    }
};