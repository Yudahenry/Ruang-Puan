<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropForeign(['jadwal_id']);
            $table->dropUnique('uq_pemesanan_jadwal');
            $table->foreign('jadwal_id')
                  ->references('id')
                  ->on('jadwal_konsultasis')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropForeign(['jadwal_id']);
            $table->unique('jadwal_id', 'uq_pemesanan_jadwal');
            $table->foreign('jadwal_id')
                  ->references('id')
                  ->on('jadwal_konsultasis')
                  ->onDelete('cascade');
        });
    }
};