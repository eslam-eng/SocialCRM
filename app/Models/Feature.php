<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Feature extends BaseModel
{
    use HasTranslations,SoftDeletes;

    protected $fillable = ['slug', 'name', 'description', 'group', 'is_active'];

    public $translatable = ['name', 'description'];
    public function plans()
    {
        return $this->belongsToMany(Plan::class)
            ->withPivot('value')
            ->using(FeaturePlan::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(PlanSubscription::class)
            ->withPivot('value')
            ->using(FeaturePlanSubscription::class);
    }

    public static function booted()
    {
        static::creating(function ($feature) {
            $feature->slug = Str::slug($feature->getTranslation('name', 'en'));
        });
    }

    public function getTranslatedFallback(string $attribute, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $fallbackLocales = config('app.fallback_locales', ['en']);

        $value = $this->getTranslation($attribute, $locale, false);

        // If value is missing in current locale, loop over fallbacks
        if (!$value) {
            foreach ($fallbackLocales as $fallbackLocale) {
                $value = $this->getTranslation($attribute, $fallbackLocale, false);
                if ($value) {
                    break;
                }
            }
        }

        return $value;
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
