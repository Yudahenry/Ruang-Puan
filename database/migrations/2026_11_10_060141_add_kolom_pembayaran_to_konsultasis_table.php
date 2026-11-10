<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->decimal('total_biaya', 10, 2)->default(150000);
            $table->string('status_pembayaran')->default('pending');
            $table->string('metode_pembayaran')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropColumn(['total_biaya', 'status_pembayaran', 'metode_pembayaran']);
        });
    }
};