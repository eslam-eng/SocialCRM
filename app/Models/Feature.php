<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Feature extends BaseModel
{
    use HasTranslations,SoftDeletes;

    protected $fillable = ['key', 'name', 'description', 'group', 'is_active'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class)
            ->withPivot('value')
            ->using(PlanFeature::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(PlanSubscription::class)
            ->withPivot('value')
            ->using(SubscriptionPlanFeature::class);
    }

    public static function booted()
    {
        static::creating(function ($feature) {
            $feature->slug = Str::slug($feature->getTranslation('name', 'en'));
        });
    }

    // public function subscriptions(): BelongsToMany
    //    {
    //        return $this->belongsToMany(
    //            related: PlanSubscription::class,
    //            table: 'subscription_plan_features',
    //            foreignPivotKey: 'feature_id',
    //            relatedPivotKey: 'plan_subscription_id'
    //        )->withPivot('value')
    //         ->using(SubscriptionPlanFeature::class);  // Custom pivot model
    //    }
}
