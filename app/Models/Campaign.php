<?php

namespace App\Models;

class Campaign extends BaseModel
{
    protected $fillable = [
        'tenant_id',
        'started_at',
        'scheduled_at',
        'completed_at',
        'type',
        'channel',
        'title',
        'content',
        'target'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'target' => 'integer'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
