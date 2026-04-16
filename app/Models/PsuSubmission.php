<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class PsuSubmission extends Model
{
    use LogsActivity;
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
        'file_template_diisi',
        'status',
        'nomor_surat_ba',
        'file_ba_terbit',
        'catatan_perbaikan',
        'user_id'
    ];

    /**
     * Get the user that owns the submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
