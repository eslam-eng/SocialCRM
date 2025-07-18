<?php

namespace App\Services\Actions\Auth;

use App\DTOs\SubscriptionPlanDTO;
use App\DTOs\TenantDTO;
use App\DTOs\UserDTO;
use App\Models\User;
use App\Services\Plan\PlanService;
use App\Services\Plan\PlanSubscriptionService;
use App\Services\Tenant\TenantService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        return DB::transaction(function () use ($registerDTO) {
            // 1- create tenant with organization data
            $tenantDTO = new TenantDTO(name: $registerDTO->organization_name, slug: Str::slug($registerDTO->organization_name));
            $tenant = $this->tenantService->create($tenantDTO);

            // 2- create user and link with this tenant and Attach to tenant_user pivot
            $registerDTO->tenant_id = $tenant->id;
            $user = $this->userService->create($registerDTO);
            $tenant->users()->attach($user->id);

            // 3- make subscription free with free trial
            $plan = $this->planService->getFreePlan();
            //create subscription with status free trial and ends at date time
            $subscriptionPlanDTO = new SubscriptionPlanDTO(
                plan_id: $plan->id,
                tenant_id: $tenant->id,
                starts_at: now(),
                ends_at: now()->addDays($plan->trial_days),
                trial_ends_at: now()->addDays($plan->trial_days)
            );
            $subscription = $this->planSubscriptionService->create($subscriptionPlanDTO);
            //take snapshot of features for the subscription ans store them

            return $user;
        });

    }
}
