<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FeaturePlanSubscription extends Pivot
{
    protected $table = 'feature_plan_subscription';
}
