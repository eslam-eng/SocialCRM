<?php

namespace App\Models;

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
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Get the currency that owns the plan.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

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
