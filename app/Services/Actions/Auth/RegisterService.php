<?php

namespace App\Services\Actions\Auth;

use App\DTOs\SubscriptionPlanDTO;
use App\DTOs\TenantDTO;
use App\DTOs\UserDTO;
use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Services\Admin\Plan\PlanService;
use App\Services\Admin\Plan\PlanSubscriptionService;
use App\Services\Admin\Tenant\TenantService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stevebauman\Location\Facades\Location as GioLocation;

readonly class RegisterService
{
    /**
     * Inject UsersService via constructor.
     */
    public function __construct(
        protected UserService             $userService,
        protected TenantService           $tenantService,
        protected PlanService             $planService,
        protected PlanSubscriptionService $planSubscriptionService
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function handle(UserDTO $registerDTO): User
    {
        return DB::transaction(fn() => $this->registerUserWithTenant($registerDTO));
    }

    private function registerUserWithTenant(UserDTO $registerDTO): User
    {
        $tenant = $this->createTenantFromDTO($registerDTO);
        $user = $this->createAndLinkUser($registerDTO, $tenant);
        $this->setupFreeTrial($tenant);
        $this->setUserLocation(user: $user);

        return $user->fresh();
    }

    private function createTenantFromDTO(UserDTO $registerDTO): Tenant
    {

        // 1. Get the part before @
        $slugBase = explode('@', $registerDTO->email)[0];

        $tenantDTO = new TenantDTO(
            name: $registerDTO->organization_name,
            slug: Str::slug($slugBase)
        );

        return $this->tenantService->create($tenantDTO);
    }

    private function setUserLocation(User $user): void
    {
        $position = GioLocation::get(request()->ip());
        if ($position) {
            $user->update(['country' => $position->countryName]);
        }
    }

    private function createAndLinkUser(UserDTO $registerDTO, Tenant $tenant): User
    {
        $registerDTO->tenant_id = $tenant->id;
        $registerDTO->role = Role::OWNER;
        $user = $this->userService->create($registerDTO);
        $tenant->users()->attach($user->id);

        return $user;
    }

    private function setupFreeTrial(Tenant $tenant): void
    {
        $plan = $this->planService->getFreePlan();
        $subscription = $this->createTrialSubscription($tenant, $plan);
        $this->attachPlanFeatures($subscription, $plan);
    }

    private function createTrialSubscription(Tenant $tenant, Plan $plan): PlanSubscription
    {
        $featuresSnapshot = [];

        foreach ($plan->features as $feature) {
            $snapshot = $feature->only($feature->getFillable()); // includes id, slug, name, group, etc.
            $snapshot['value'] = $feature->pivot?->value;
            $featuresSnapshot[] = $snapshot;
        }
        $trialEndsAt = now()->addDays($plan->trial_days);

        $planSnapshot = $plan->only($plan->getFillable());

        $planSnapshot['name'] = $plan->getTranslations('name');

        $subscriptionPlanDTO = new SubscriptionPlanDTO(
            plan_id: $plan->id,
            tenant_id: $tenant->id,
            starts_at: now(),
            ends_at: $trialEndsAt,
            plan_snapshot: $planSnapshot,
            plan_features_snapshot: $featuresSnapshot
        );

        return $this->planSubscriptionService->create($subscriptionPlanDTO);
    }

    private function attachPlanFeatures(PlanSubscription $subscription, Plan $plan): void
    {
        if (collect($plan->features)->isEmpty()) {
            return;
        }

        // Snapshot features to feature_plan_subscription
        $featuresToAttach = [];
        foreach ($plan->features as $feature) {
            $featuresToAttach[] = [
                'plan_subscription_id' => $subscription->id,
                'feature_id' => $feature->id,
                'slug' => $feature->slug,
                'name' => json_encode($feature->getTranslations('name')),
                'value' => $feature->pivot->value, // value from feature_plan pivot
                'usage' => 0,
            ];
        }
        $subscription->features()->sync($featuresToAttach);
    }
}
