<?php

namespace App\Models;

use App\Traits\HasTenantScope;

class Segment extends BaseModel
{
    use HasTenantScope;

    protected $fillable = [
        'name',
        'description',
        'tenant_id',
        'contact_count',
        'is_active',
    ];

    protected $casts = [
        'contact_count' => 'integer',
    ];

    /**
     * Get the tenant that owns the segment.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
