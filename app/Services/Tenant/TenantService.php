<?php

namespace App\Services\Tenant;

use App\DTOs\TenantDTO;
use App\Models\Tenant;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TenantService extends BaseService
{
    protected function getFilterClass(): ?string
    {
        return null;
    }

    protected function baseQuery(): Builder
    {
        return Tenant::query();
    }

    public function create(TenantDTO $dto): Tenant
    {
        return $this->getQuery()->create($dto->toArray());
    }

    public function update(int $id, TenantDTO $dto): Model
    {
        $tenant = $this->findById($id);
        $tenant->update($dto->toArray());

        return $tenant;
    }

    public function delete(int $id): bool
    {
        $tenant = $this->findById($id);

        return $tenant->delete();
    }
}
