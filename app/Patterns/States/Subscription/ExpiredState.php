<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;
use App\Exceptions\SubscriptionException;

class ExpiredState extends SubscriptionState
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
        throw new SubscriptionException(__('subscription.already_expired'));
    }

    public function suspend(): void
    {
        throw new SubscriptionException(__('subscription.cannot_suspend_expired'));
    }

    public function markPastDue(): void
    {
        throw new SubscriptionException(__('subscription.cannot_mark_past_due_expired'));
    }

    public function getStatus(): SubscriptionStatus
    {
        return SubscriptionStatus::EXPIRED;
    }
}
