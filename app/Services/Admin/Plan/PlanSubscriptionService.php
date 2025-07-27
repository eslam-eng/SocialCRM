<?php

namespace App\Services\Admin\Plan;

use App\DTOs\SubscriptionPlanDTO;
use App\Models\Filters\PlanSubscriptionFilters;
use App\Models\PlanSubscription;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PlanSubscriptionService extends BaseService
{
    protected function getFilterClass(): ?string
    {
        return PlanSubscriptionFilters::class;
    }

    protected function baseQuery(): Builder
    {
        return PlanSubscription::query();
    }

    public function create(SubscriptionPlanDTO $subscriptionPlanDTO)
    {
        return $this->getQuery()->create($subscriptionPlanDTO->toFilteredArray());
    }

    public function staticsByStatus(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->getQuery()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

    }
}
