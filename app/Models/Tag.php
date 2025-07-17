<?php

namespace App\Models;

use App\Traits\HasTenantScope;

class Tag extends BaseModel
{
    use HasTenantScope;

    protected $fillable = [
        'color',
        'name',
        'emoji',
        'description',
        'tenant_id',
    ];
}
