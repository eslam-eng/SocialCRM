<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class CanceledState extends AbstractSubscriptionState
{
    protected SubscriptionStatus $status = SubscriptionStatus::CANCELED;
}
