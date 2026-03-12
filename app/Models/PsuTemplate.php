<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsuTemplate extends Model
{
    protected $fillable = ['title', 'description', 'file_path'];
}
