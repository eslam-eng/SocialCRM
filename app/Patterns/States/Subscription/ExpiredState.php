<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class ExpiredState extends AbstractSubscriptionState
{
    protected SubscriptionStatus $status = SubscriptionStatus::EXPIRED;

    public function activate(): void
    {
        $this->context->transitionTo(new ActiveState());
    }
}
