<?php

namespace App\Models;

use App\Enum\SubscriptionDurationEnum;

class Plan extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'is_active',
        'trial_days',
        'sort_order',
        'currency_id',
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
