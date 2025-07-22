<?php

namespace App\Http\Resources\Api\SuperAdmin;

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
            'description' =>  $this->getTranslatedFallback('description'),
            'group' => $this->group,
            'value' => $this->whenPivotLoaded('feature_plans', fn () => $this->pivot->value)
                ?? $this->whenPivotLoaded('feature_plan_subscriptions', fn () => $this->pivot->value),

        ];
    }
}
