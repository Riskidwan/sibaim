<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class PsuTemplate extends Model
{
    use LogsActivity;
    protected $fillable = ['title', 'description', 'file_path', 'is_active'];
}
