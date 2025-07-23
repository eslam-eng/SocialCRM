<?php

namespace App\Traits;

use App\Models\Scopes\BelongsToTenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasTenantScope
{
    protected static function bootHasTenantScope()
    {
        // Automatically add tenant_id when creating a new model
        static::creating(function (Model $model) {
            if (Auth::check()) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });

        static::addGlobalScope(new BelongsToTenantScope());
    }
}
