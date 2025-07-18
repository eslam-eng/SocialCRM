<?php

namespace App\Services\Actions\Auth;

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
        protected UserService $userService,
        protected TenantService $tenantService,
        protected PlanService $planService,
        protected PlanSubscriptionService $planSubscriptionService
    ) {}

    /**
     * @throws \Throwable
     */
    public function handle(UserDTO $registerDTO): User
    {
        return DB::transaction(function () use ($registerDTO) {
            // 1- create tenant with organization data
            $tenantDTO = new TenantDTO(name: $registerDTO->organization_name, slug: Str::slug($registerDTO->organization_name));

            $tenant = $this->tenantService->create($tenantDTO);
            // 2- create user and link with this tenant
            $registerDTO->tenant_id = $tenant->id;
            $user = $this->userService->create($registerDTO);
            // Attach to tenant_user pivot
            $tenant->users()->attach($user->id);

            // 3- make subscription free with free trial
            $plan = $this->planService->getFreePlan();

            return $user;
        });

    }
}
