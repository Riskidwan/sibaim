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
        Schema::create('psu_housings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perumahan');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->string('nama_pengembang');
            $table->decimal('luas_lahan_m2', 12, 2)->nullable();
            $table->integer('jumlah_rumah')->nullable();
            
            // PSU Details
            $table->json('prasarana')->nullable();
            $table->json('sarana')->nullable();
            $table->json('utilitas')->nullable();
            
            // Location
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psu_housings');
    }
};
