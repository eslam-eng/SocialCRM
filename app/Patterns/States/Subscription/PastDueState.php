<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class PastDueState extends AbstractSubscriptionState
{
    protected SubscriptionStatus $status = SubscriptionStatus::PAST_DUE;

    public function activate(): void
    {
        $this->context->transitionTo(new ActiveState());
    }

    public function cancel(): void
    {
        $this->context->transitionTo(new CanceledState());
    }

    public function suspend(): void
    {
        $this->context->transitionTo(new SuspendedState());
    }
}
