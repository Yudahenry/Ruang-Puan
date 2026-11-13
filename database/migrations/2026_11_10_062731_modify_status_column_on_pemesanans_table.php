<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            // Mengubah kolom status menjadi VARCHAR(50) agar muat menampung teks status
            $table->string('status', 50)->default('menunggu_pembayaran')->change();
        });
    }

    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->string('status')->change();
        });
    }
};