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
            $table->string('nomor_surat_ba')->nullable()->after('status');
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE psu_submissions MODIFY status ENUM('verifikasi dokumen', 'perbaikan dokumen', 'penugasan tim verifikasi', 'BA terima terbit') DEFAULT 'verifikasi dokumen'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE psu_submissions MODIFY status ENUM('verifikasi dokumen', 'perbaikan dokumen', 'BA terima terbit') DEFAULT 'verifikasi dokumen'");

        Schema::table('psu_submissions', function (Blueprint $table) {
            $table->dropColumn('nomor_surat_ba');
        });
    }
};
