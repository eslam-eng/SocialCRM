<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BelongsToTenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {

        // Check if the authenticated user is using the teacher guard
        if (!Auth::guard('admin')->check() && $user =  Auth::user()) {
            if (Schema::hasColumn($model->getTable(), 'tenant_id')) {
                $builder->where($model->getTable() . '.tenant_id', $user->tenant_id);
            }
        }
    }
}
