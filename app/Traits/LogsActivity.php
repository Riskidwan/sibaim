<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->recordActivity('created');
        });

        static::updated(function ($model) {
            $model->recordActivity('updated');
        });

        static::deleted(function ($model) {
            $model->recordActivity('deleted');
        });
    }

    protected function recordActivity($event)
    {
        $description = $this->generateActivityDescription($event);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'description' => $description,
            'properties' => $this->getLogProperties($event),
        ]);
    }

    protected function generateActivityDescription($event)
    {
        $modelName = class_basename($this);
        $displayName = $this->nama_perumahan ?? $this->nama_pemohon ?? $this->nama_kegiatan ?? $this->nama ?? $this->name ?? $this->title ?? $this->judul ?? $this->id;
        
        $action = [
            'created' => 'menambah',
            'updated' => 'mengubah',
            'deleted' => 'menghapus',
        ][$event];

        return "{$action} data {$modelName}: {$displayName}";
    }

    protected function getLogProperties($event)
    {
        if ($event === 'updated') {
            return [
                'old' => array_intersect_key($this->getRawOriginal(), $this->getDirty()),
                'attributes' => $this->getDirty(),
            ];
        }

        return $this->toArray();
    }
}
