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

if (! function_exists('countriesData')) {
    function countriesData(): \Illuminate\Support\Collection
    {
        // Load your JSON file (stored in storage or resources)
        $jsonPath = database_path('top_100_country_phone_codes.json'); // example path
        $countries = json_decode(file_get_contents($jsonPath), true);
        return collect($countries);
    }
}
