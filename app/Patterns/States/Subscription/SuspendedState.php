<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class SuspendedState extends AbstractSubscriptionState
{
    protected SubscriptionStatus $status = SubscriptionStatus::SUSPENDED;

    public function activate(): void
    {
        $this->context->transitionTo(new ActiveState());
    }

    public function cancel(): void
    {
        $this->context->transitionTo(new CanceledState());
    }
}
