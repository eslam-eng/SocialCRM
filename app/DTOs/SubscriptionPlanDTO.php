<?php

namespace App\DTOs;

use App\DTOS\Abstract\BaseDTO;
use App\Enum\ActivationStatusEnum;
use App\Enum\SubscriptionStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SubscriptionPlanDTO extends BaseDTO
{
    public function __construct(
        public int $plan_id,
        public string $tenant_id,
        public string $starts_at,
        public string $ends_at,
        public bool $auto_renew = ActivationStatusEnum::INACTIVE->value,
        public ?string $trial_ends_at = null,
        public ?string $status = SubscriptionStatusEnum::ACTIVE->value,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            plan_id: Arr::get($data, 'plan_id'),
            tenant_id: Arr::get($data, 'tenant_id'),
            starts_at: Arr::get($data, 'starts_at'),
            ends_at: Arr::get($data, 'ends_at'),
            auto_renew: Arr::get($data, 'auto_renew'),
            status: Arr::get($data, 'status'),

        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            plan_id: $request->plan_id,
            tenant_id: $request->tenant_id,
            starts_at: $request->starts_at,
            ends_at: $request->ends_at,
            auto_renew: $request->auto_renew,
            trial_ends_at: $request->trial_ends_at,
            status: $request->status,
        );
    }

    public function toArray(): array
    {
        return [
            'plan_id' => $this->plan_id,
            'tenant_id' => $this->tenant_id,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'auto_renew' => $this->auto_renew,
            'trial_ends_at' => $this->trial_ends_at,
            'status' => $this->status,
        ];
    }
}
