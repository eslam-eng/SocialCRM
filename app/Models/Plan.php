<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'features',
        'limits',
        'is_active',
        'trial_days',
        'sort_order',
        'currency_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'features' => 'array' // If features is stored as JSON
    ];


    /**
     * Get the currency that owns the plan.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    /**
     * Get the subscriptions for the plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(PlanSubscription::class);
    }
}
