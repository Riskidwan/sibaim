<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class Galeri extends Model
{
    use LogsActivity;
    protected $fillable = [
        'judul',
        'kategori',
        'file_path',
        'is_active',
    ];
}
