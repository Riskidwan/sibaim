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
        Schema::table('psu_submissions', function (Blueprint $table) {
            $table->string('fc_ktp')->nullable()->change();
            $table->string('fc_akta_pendirian')->nullable()->change();
            $table->string('fc_sertifikat_tanah')->nullable()->change();
            $table->string('siteplan')->nullable()->change();
            $table->string('daftar_psu_nilai')->nullable()->change();
            $table->string('fc_imb_pbg')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psu_submissions', function (Blueprint $table) {
            $table->string('fc_ktp')->nullable(false)->change();
            $table->string('fc_akta_pendirian')->nullable(false)->change();
            $table->string('fc_sertifikat_tanah')->nullable(false)->change();
            $table->string('siteplan')->nullable(false)->change();
            $table->string('daftar_psu_nilai')->nullable(false)->change();
            $table->string('fc_imb_pbg')->nullable(false)->change();
        });
    }
};
