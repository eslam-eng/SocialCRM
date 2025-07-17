<?php

namespace App\Models;

use App\Traits\HasTenantScope;

class Product extends BaseModel
{
    use HasTenantScope;
}
