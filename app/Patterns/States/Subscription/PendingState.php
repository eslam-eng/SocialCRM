<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class PendingState extends AbstractSubscriptionState
{
    protected SubscriptionStatus $status = SubscriptionStatus::PENDING;

    public function activate(): void
    {
        $this->context->transitionTo(new ActiveState());
    }

    public function cancel(): void
    {
        $this->context->transitionTo(new CanceledState());
    }
}
