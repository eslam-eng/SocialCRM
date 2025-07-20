<?php

namespace App\Services\Plan;

use App\DTOs\PlanDTO;
use App\Models\Currency;
use App\Models\Filters\PlansFilters;
use App\Models\Plan;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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

    /**
     * @throws \Throwable
     */
    public function create(PlanDTO $planDTO)
    {
        $limitsToAttach = collect($planDTO->limits)
            ->mapWithKeys(function ($value, $id) {
                return [$id => ['value' => $value]];
            })
            ->all();

        $featuresToAttach = collect($planDTO->limits)
            ->mapWithKeys(function ($value, $id) {
                return [$id => ['value' => $value]];
            })
            ->all();


        return DB::transaction(function () use ($planDTO, $featuresToAttach, $limitsToAttach) {
            $plan = $this->getQuery()->create($planDTO->toArray());
            $allFeaturesToAttach = array_merge($featuresToAttach, $limitsToAttach);
            $plan->features()->attach($allFeaturesToAttach);
            return $plan;
        });
    }

    public function delete(int $plan_id): ?bool
    {
        $plan = $this->findById($plan_id);
        return $plan->delete();
    }
}
