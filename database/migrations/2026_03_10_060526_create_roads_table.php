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
        Schema::create('roads', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->float('panjang');
            $table->float('lebar');
            $table->string('jenis_perkerasan');
            $table->string('kondisi');
            $table->string('kecamatan');
            $table->string('kelurahan')->nullable();
            $table->integer('tahun');
            $table->json('coordinates')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roads');
    }
};
