<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class DataJalan extends Model
{
    use LogsActivity;

    protected $fillable = [
        'kecamatan',
        'kelurahan',
        'nama_jalan',
        'panjang_jalan',
        'is_public',
    ];

    protected $casts = [
        'panjang_jalan' => 'float',
        'is_public'     => 'boolean',
    ];
}
