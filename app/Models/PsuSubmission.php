<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsuSubmission extends Model
{
    protected $fillable = [
        'no_registrasi',
        'nama_pemohon',
        'jenis_permohonan',
        'lokasi_pembangunan',
        'fc_ktp',
        'fc_akta_pendirian',
        'fc_sertifikat_tanah',
        'siteplan',
        'daftar_psu_nilai',
        'fc_imb_pbg',
        'status',
        'catatan_perbaikan'
    ];
}
