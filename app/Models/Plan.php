<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
use App\Enum\FeatureGroupEnum;
use App\Enum\SubscriptionDurationEnum;
use App\Traits\HasTranslatedFallback;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Plan extends BaseModel
{
    use SoftDeletes, HasTranslatedFallback, HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'is_active',
        'trial_days',
        'sort_order',
        'currency',
        'refund_days',
    ];

    public $translatable = ['name', 'description'];
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => ActivationStatusEnum::class,
        'billing_cycle' => SubscriptionDurationEnum::class,
    ];


    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_plan')
            ->withPivot('value')
            ->using(FeaturePlan::class);
    }

    public function limitFeatures(): BelongsToMany
    {
        return $this->features()
            ->where('group', FeatureGroupEnum::LIMIT->value);
    }

    public function addonFeatures(): BelongsToMany
    {
        return $this->features()
            ->where('group', FeatureGroupEnum::FEATURE->value);
    }

    /**
     * Get the subscriptions for the plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(PlanSubscription::class);
    }

    public function scopeTrial($query)
    {
        return $query->where('trial_days', '>', 0);
    }

}
