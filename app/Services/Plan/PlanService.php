<?php

namespace App\Services\Plan;

use App\Models\Filters\PlansFilters;
use App\Models\Plan;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function paginate(array $filters = [], array $withRelation = []): LengthAwarePaginator
    {
        return $this->getQuery(filters: $filters, withRelation: $withRelation)->paginate();
    }

    public function create()
    {
        // $basicPlan->features()->attach([
        //    Feature::where('name', 'max_users')->first()->id => ['value' => 5],
        //    Feature::where('name', 'ai_enabled')->first()->id => ['value' => false],
        //    Feature::where('name', 'channel_integration')->first()->id => ['value' => true]
        // ]);
    }
}
