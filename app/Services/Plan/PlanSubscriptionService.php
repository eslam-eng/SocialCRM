<?php

namespace App\Services\Plan;

use App\DTOs\SubscriptionPlanDTO;
use App\Models\Filters\PlanSubscriptionFilters;
use App\Models\PlanSubscription;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;

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
        return $this->getQuery()->create($subscriptionPlanDTO->toArray());
    }
}
