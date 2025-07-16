<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;
use App\Exceptions\SubscriptionException;

class PastDueState  extends SubscriptionState
{
    public function activate(): void
    {
        $this->subscription->setState(new ActiveState($this->subscription));
        $this->subscription->status = SubscriptionStatus::ACTIVE;
        $this->subscription->save();
    }

    public function cancel(): void
    {
        $this->subscription->setState(new CanceledState($this->subscription));
        $this->subscription->status = SubscriptionStatus::CANCELED;
        $this->subscription->save();
    }

    public function expire(): void
    {
        $this->subscription->setState(new ExpiredState($this->subscription));
        $this->subscription->status = SubscriptionStatus::EXPIRED;
        $this->subscription->save();
    }

    public function suspend(): void
    {
        $this->subscription->setState(new SuspendedState($this->subscription));
        $this->subscription->status = SubscriptionStatus::SUSPENDED;
        $this->subscription->save();
    }

    public function markPastDue(): void
    {
        throw new SubscriptionException(__(
            'subscription.already_past_due'
        ));
    }

    public function getStatus(): SubscriptionStatus
    {
        return SubscriptionStatus::PAST_DUE;
    }
}
