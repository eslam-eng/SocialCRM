<?php

namespace App\Models;

use App\Enum\SubscriptionStatus;
use App\Traits\HasSubscriptionState;
use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends BaseModel
{
    use HasSubscriptionState;
    
    protected $fillable = [
        'plan_id',
        'tenant_id',
        'status',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'canceled_at',
        'auto_renew',
        'features',
        'limits',
    ];

    protected $casts = [
        'status' => SubscriptionStatus::class,
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'auto_renew' => 'boolean',
        'features' => 'array',
        'limits' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function isActive(): bool
    {
        return $this->status === SubscriptionStatus::ACTIVE;
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function hasEnded(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    public function cancel(bool $immediately = false): void
    {
        $this->canceled_at = now();
        
        if ($immediately) {
            $this->ends_at = now();
            $this->expire();
        } else {
            parent::cancel();
        }
        
        $this->save();
    }
}
