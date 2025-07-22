<?php

namespace App\Models;

use App\Enum\FeatureGroupEnum;
use App\Enum\SubscriptionDurationEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends BaseModel
{
    use SoftDeletes;

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

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'billing_cycle' => SubscriptionDurationEnum::class,
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class)->withPivot('value')->withTimestamps();
    }

    public function limitFeatures(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class)
            ->where('type', FeatureGroupEnum::LIMIT->value)
            ->withPivot('value');
    }

    public function addonFeatures(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class)
            ->where('type', FeatureGroupEnum::FEATURE->value)
            ->withPivot('value');
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

    public function planFeatures()
    {
        return $this->hasMany(PlanFeature::class);
    }
}
