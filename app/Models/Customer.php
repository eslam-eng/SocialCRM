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
        'country_code', 'phone', 'email',
        'source', 'address','country','city','zipcode',
        'status', 'tenant_id','tags'
    ];

    protected $casts = [
        'source' => CustomerSourceEnum::class,
        'status' => CustomerStatusEnum::class,
        'tags'=>'array',
    ];

    //    protected $appends = ['custom_fields'];
}
