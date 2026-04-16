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
            $table->string('file_template_diisi')->nullable()->after('fc_imb_pbg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psu_submissions', function (Blueprint $table) {
            $table->dropColumn('file_template_diisi');
        });
    }
};
