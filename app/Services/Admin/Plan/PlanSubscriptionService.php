<?php

namespace App\Services\Admin\Plan;

use App\DTOs\SubscriptionPlanDTO;
use App\Models\Filters\PlanSubscriptionFilters;
use App\Models\PlanSubscription;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
        $subscriptionData = $subscriptionPlanDTO->toArray();
        if (!empty($subscriptionPlanDTO->plan_snapshot))
            $subscriptionData['plan_snapshot'] = json_encode($subscriptionPlanDTO->plan_snapshot);

        return $this->getQuery()->create($subscriptionData);
    }

    public function staticsByStatus(): Collection
    {
        return $this->getQuery()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

    }
}
