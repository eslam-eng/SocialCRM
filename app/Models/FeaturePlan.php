<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturePlan extends BaseModel
{
    protected $table = 'feature_plan';

    protected $fillable = [
        'plan_id',
        'feature_id',
        'value',
        'is_unlimited',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }
}
