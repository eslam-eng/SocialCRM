<?php

namespace App\Services\Plan;

use App\Models\Filters\PlansFilters;
use App\Models\Plan;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;

class PlanService extends BaseService
{
    protected function getFilterClass(): ?string
    {
        return PlansFilters::class;
    }

    protected function baseQuery(): Builder
    {
        return Plan::query();
    }

    public function getFreePlan()
    {
        return $this->getQuery()->trial()->first();
    }
}
