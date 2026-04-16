<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class PublicDownload extends Model
{
    use LogsActivity;
    protected $fillable = [
        'kategori',
        'title',
        'description',
        'tanggal',
        'file_path',
        'is_active',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
    ];
}
