<?php

namespace App\Models;

use App\Enum\SubscriptionStatus;
use App\Patterns\States\Subscription\ActiveState;
use App\Patterns\States\Subscription\CanceledState;
use App\Patterns\States\Subscription\ExpiredState;
use App\Patterns\States\Subscription\PendingState;
use App\Patterns\States\Subscription\SubscriptionState;
use App\Patterns\States\Subscription\SuspendedState;
use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends BaseModel
{

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

    public function setState(SubscriptionState $state): void
    {
        $this->state = $state;
    }

    public function getState(): ?SubscriptionState
    {
        if ($this->state === null) {
            $this->initializeState();
        }
        return $this->state;
    }

    protected function initializeState(): void
    {
        $this->state = match ($this->status) {
            SubscriptionStatus::PENDING => new PendingState($this),
            SubscriptionStatus::ACTIVE => new ActiveState($this),
            SubscriptionStatus::CANCELED => new CanceledState($this),
            SubscriptionStatus::EXPIRED => new ExpiredState($this),
            SubscriptionStatus::SUSPENDED => new SuspendedState($this),
            SubscriptionStatus::PAST_DUE => new PastDueState($this),
        };
    }

    public function activate(): void
    {
        $this->getState()->activate();
    }

    public function cancel(): void
    {
        $this->getState()->cancel();
    }

    public function expire(): void
    {
        $this->getState()->expire();
    }

    public function suspend(): void
    {
        $this->getState()->suspend();
    }

    public function markPastDue(): void
    {
        $this->getState()->markPastDue();
    }

}
