<?php

namespace App\Models;

use App\Traits\HasTenantScope;

class Order extends BaseModel
{
    use HasTenantScope;
}
