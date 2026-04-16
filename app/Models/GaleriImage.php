<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriImage extends Model
{
    protected $fillable = [
        'galeri_kegiatan_id',
        'file_path',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(GaleriKegiatan::class, 'galeri_kegiatan_id');
    }
}
