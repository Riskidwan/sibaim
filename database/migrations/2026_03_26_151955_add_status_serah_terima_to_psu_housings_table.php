<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('psu_housings', function (Blueprint $table) {
            $table->string('status_serah_terima')->default('Belum Serah Terima')->after('nama_pengembang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psu_housings', function (Blueprint $table) {
            $table->dropColumn('status_serah_terima');
        });
    }
};
