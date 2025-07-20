<?php

namespace App\Http\Resources\Api;

use App\Enum\ActivationStatusEnum;
use App\Enum\FeatureGroupEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'currency' => $this->currency,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'is_active_text' => ActivationStatusEnum::from($this->is_active)->getLabel(),
            'billing_cycle' => $this->billing_cycle,
            'billing_cycle_text' => ActivationStatusEnum::from($this->billing_cycle)->getLabel(),
            'trial_days' => $this->trial_days,
            'refund_days' => $this->refund_days,
            'features' => FeatureResource::collection($this->whenLoaded('features')->where('type', FeatureGroupEnum::FEATURE->value)),
            'limits' => FeatureResource::collection($this->whenLoaded('features')->where('type', FeatureGroupEnum::LIMIT->value)),
        ];
    }
}
