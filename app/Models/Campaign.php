<?php

namespace App\Models;

use App\Traits\HasTenantScope;

class Campaign extends BaseModel
{
    use HasTenantScope;

    protected $fillable = [
        'tenant_id',
        'started_at',
        'scheduled_at',
        'completed_at',
        'type',
        'channel',
        'title',
        'content',
        'target',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'target' => 'integer',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
