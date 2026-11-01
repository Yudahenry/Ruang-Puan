
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lembaga_bantuans', function (Blueprint $table) {
            $table->text('deskripsi')->nullable();
            $table->string('website', 255)->nullable();
            $table->string('status', 20)->default('aktif');
        });
    }

    public function down(): void
    {
        Schema::table('lembaga_bantuans', function (Blueprint $table) {
            $table->dropColumn([
                'deskripsi',
                'website',
                'status',
            ]);
        });
    }
};
