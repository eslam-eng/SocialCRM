<?php

namespace App\Models;

use App\Traits\HasCustomFields;
use App\Traits\HasTenantScope;

class Customer extends BaseModel
{
    use HasCustomFields, HasTenantScope;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'stage',
        'tenant_id',
    ];

    protected $appends = ['custom_fields'];
}
