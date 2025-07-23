<?php

namespace App\Services\User;

use App\DTOs\UserDTO;
use App\Models\Filters\UsersFilter;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;

class UserService extends BaseService
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
        return User::query()->belongsToTenant();
    }

    public function create(UserDTO $userDTO)
    {
        return $this->getQuery()->create($userDTO->toArray());
    }
}
