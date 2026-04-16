<?php

namespace App\Models;

class ActivityLog extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'user_id',
        'event',
        'model_type',
        'model_id',
        'description',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }
}
