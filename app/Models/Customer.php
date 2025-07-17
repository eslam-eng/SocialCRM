<?php

namespace App\Models;

use App\Traits\HasTenantScope;

class Customer extends BaseModel
{
    use HasTenantScope;

    protected $fillable = [];
}
