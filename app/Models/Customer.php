<?php

namespace App\Models;

use App\Enum\CustomerSourceEnum;
use App\Enum\CustomerStatusEnum;
use App\Traits\HasCustomFields;
use App\Traits\HasTenantScope;

class Customer extends BaseModel
{
    use HasCustomFields, HasTenantScope;

    protected $fillable = [
        'name',
        'country_code',
        'phone',
        'email',
        'source',
        'address',
        'status',
        'tenant_id',
    ];

    protected $casts = [
        'source' => CustomerSourceEnum::class,
        'status' => CustomerStatusEnum::class,
    ];

    //    protected $appends = ['custom_fields'];
}
