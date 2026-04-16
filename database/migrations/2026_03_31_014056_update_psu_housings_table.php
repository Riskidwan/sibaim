<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('psu_housings', function (Blueprint $table) {
            $table->string('alamat')->after('nama_perumahan')->nullable();
            $table->string('no_ba_serah_terima')->after('nama_pengembang')->nullable();
            $table->decimal('total_luas_psu', 12, 2)->after('luas_lahan_m2')->nullable();
        });

        // Data migration
        $housings = DB::table('psu_housings')->get();
        foreach ($housings as $housing) {
            $alamat = "Kel. {$housing->kelurahan_desa}, Kec. {$housing->kecamatan}";
            DB::table('psu_housings')->where('id', $housing->id)->update(['alamat' => $alamat]);
        }

        Schema::table('psu_housings', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'kelurahan_desa']);
            $table->string('alamat')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psu_housings', function (Blueprint $table) {
            $table->string('kecamatan')->after('nama_perumahan')->nullable();
            $table->string('kelurahan_desa')->after('kecamatan')->nullable();
        });

        Schema::table('psu_housings', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'no_ba_serah_terima', 'total_luas_psu']);
        });
    }
};
