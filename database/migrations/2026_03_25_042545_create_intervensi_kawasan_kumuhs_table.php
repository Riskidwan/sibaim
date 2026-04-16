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
        Schema::create('intervensi_kawasan_kumuhs', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('kawasan');
            $table->string('infrastruktur');
            $table->string('kegiatan');
            $table->string('volume_satuan');
            $table->unsignedBigInteger('anggaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervensi_kawasan_kumuhs');
    }
};
