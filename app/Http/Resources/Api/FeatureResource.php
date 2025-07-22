<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
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
            'group' => $this->group,
            'value' => $this->whenPivotLoaded('feature_plan', fn () => $this->pivot->value)
                ?? $this->whenPivotLoaded('plan_subscription_feature', fn () => $this->pivot->value),

        ];
    }
}
