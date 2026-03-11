<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    protected $fillable = [
        'nama', 'panjang', 'lebar', 'jenis_perkerasan', 
        'kondisi', 'kecamatan', 'kelurahan', 'tahun', 'coordinates'
    ];

    protected $casts = [
        'coordinates' => 'array'
    ];
}
