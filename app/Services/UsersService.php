<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\User;
use App\Models\Filters\UsersFilter;
use Illuminate\Database\Eloquent\Builder;

class UsersService extends BaseService
{
    /**
     * Return the filter class for users.
     */
    protected function getFilterClass(): string
    {
        return UsersFilter::class;
    }

    /**
     * Return the base query for users.
     */
    protected function baseQuery(): Builder
    {
        return User::query();
    }
}
