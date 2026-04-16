<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class PsuHousing extends Model
{
    use LogsActivity;
    protected $fillable = [
        'nama_perumahan',
        'alamat',
        'nama_pengembang',
        'no_ba_serah_terima',
        'luas_lahan_m2',
        'total_luas_psu',
        'jumlah_rumah',
        'prasarana',
        'sarana',
        'utilitas',
        'status_serah_terima'
    ];

    protected $casts = [
        'prasarana' => 'array',
        'sarana' => 'array',
        'utilitas' => 'array',
        'luas_lahan_m2' => 'float',
        'total_luas_psu' => 'float'
    ];
}
