<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasTenantScope
{
    protected static function bootHasTenantScope()
    {
        // Automatically add tenant_id when creating a new model
        static::creating(function (Model $model) {
            if (Auth::check() && ! $model->tenant_id) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });

        // Add global scope to filter by tenant_id
        static::addGlobalScope('tenant', function (Builder $builder) {
            // Allow admins (from admin guard) to bypass tenant scoping
            if (Auth::guard('admin-api')->check()) {
                return;
            }
            $defaultGuard = config('auth.defaults.guard');

            if (Auth::guard($defaultGuard)->check()) {
                return Auth::guard($defaultGuard)->user()?->tenant_id;
            }
        });
    }
}
