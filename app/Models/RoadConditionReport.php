<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadConditionReport extends Model
{
    protected $fillable = [
        'year',
        'title',
        'file_path',
    ];
}
