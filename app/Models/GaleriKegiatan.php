<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class GaleriKegiatan extends Model
{
    use LogsActivity;
    protected $fillable = [
        'judul',
        'kategori',
        'tanggal',
        'deskripsi',
        'is_active',
    ];

    public function images()
    {
        return $this->hasMany(GaleriImage::class);
    }
}
