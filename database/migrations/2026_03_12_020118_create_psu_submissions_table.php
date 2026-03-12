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
        Schema::create('psu_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->string('nama_pemohon');
            $table->string('jenis_permohonan')->default('Serah Terima PSU');
            $table->text('lokasi_pembangunan');
            // Document uploads
            $table->string('fc_ktp');
            $table->string('fc_akta_pendirian');
            $table->string('fc_sertifikat_tanah');
            $table->string('siteplan');
            $table->string('daftar_psu_nilai');
            $table->string('fc_imb_pbg');
            // Status and feedback
            $table->enum('status', ['verifikasi dokumen', 'perbaikan dokumen', 'BA terima terbit'])->default('verifikasi dokumen');
            $table->text('catatan_perbaikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psu_submissions');
    }
};
