<?php

namespace App\Models\Tenant;

use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Permission extends \Spatie\Permission\Models\Permission
{
    use UsesTenantConnection;
}
