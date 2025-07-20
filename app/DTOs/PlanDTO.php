<?php

namespace App\DTOs;

use App\DTOs\Abstract\BaseDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PlanDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $billing_cycle,
        public float $price,
        public string $currency, // setDefault currency from settings
        public ?string $description = null,
        public bool $is_active = true,
        public int $trial_days = 0,
        public ?int $refund_days = null,
        public ?array $features = [],
        public ?array $limits = []
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            name: Arr::get($data, 'name'),
            description: Arr::get($data, 'description'),
            price: Arr::get($data, 'price', 0),
            billing_cycle: Arr::get($data, 'billing_cycle', ''),
            is_active: Arr::get($data, 'is_active', true),
            trial_days: Arr::get($data, 'trial_days', 0),
            currency: Arr::get($data, 'currency', ''),
            refund_days: Arr::get($data, 'refund_days'),
            features: Arr::get($data, 'features', []),
            limits: Arr::get($data, 'limits', []),
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->name,
            description: $request->description,
            price: $request->price,
            billing_cycle: $request->billing_cycle,
            is_active: $request->is_active,
            trial_days: $request->trial_days,
            currency: $request->currency,
            refund_days: $request->refund_days,
            features: $request->features,
            limits: $request->limits,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'billing_cycle' => $this->billing_cycle,
            'is_active' => $this->is_active,
            'trial_days' => $this->trial_days,
            'currency' => $this->currency,
            'refund_days' => $this->refund_days,
            'features' => $this->features,
            'limits' => $this->limits,
        ];
    }
}
