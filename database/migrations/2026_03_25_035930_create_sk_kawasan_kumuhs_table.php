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
        Schema::create('sk_kawasan_kumuhs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nomor_sk')->nullable();
            $table->integer('tahun')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_kawasan_kumuhs');
    }
};
