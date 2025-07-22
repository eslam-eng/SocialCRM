<?php

namespace App\Models;

use App\Traits\HasTranslatedFallback;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Feature extends BaseModel
{
    use HasTranslations,SoftDeletes,HasTranslatedFallback;

    protected $fillable = ['slug', 'name', 'description', 'group', 'is_active'];

    public $translatable = ['name', 'description'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'feature_plan')
            ->withPivot('value')
            ->using(FeaturePlan::class);
    }

    public function planSubscriptions()
    {
        return $this->belongsToMany(PlanSubscription::class, 'feature_plan_subscription')
            ->withPivot('value', 'usage')
            ->using(FeaturePlanSubscription::class);
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
