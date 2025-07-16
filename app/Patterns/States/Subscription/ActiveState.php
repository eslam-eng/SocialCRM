<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class ActiveState extends AbstractSubscriptionState
{
    protected SubscriptionStatus $status = SubscriptionStatus::ACTIVE;

    public function cancel(): void
    {
        $this->context->transitionTo(new CanceledState());
    }

    public function suspend(): void
    {
        $this->context->transitionTo(new SuspendedState());
    }

    public function expire(): void
    {
        $this->context->transitionTo(new ExpiredState());
    }

    public function markAsPastDue(): void
    {
        $this->context->transitionTo(new PastDueState());
    }
}
