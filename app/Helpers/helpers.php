<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

if (! function_exists('currentTenantId')) {
    function currentTenantId(): ?int
    {
        return Auth::check() ? Auth::user()->tenant_id : null;
    }
}

if (! function_exists('currentTenant')) {
    function currentTenant(): ?Tenant
    {
        return Auth::check() ? Auth::user()->currentTenant ?? null : null;
    }
}
