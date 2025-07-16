<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class SubscriptionStateFactory
{
    public static function create(int $status): AbstractSubscriptionState
    {
        return match ($status) {
            SubscriptionStatus::PENDING->value => new PendingState(),
            SubscriptionStatus::ACTIVE->value => new ActiveState(),
            SubscriptionStatus::CANCELED->value => new CanceledState(),
            SubscriptionStatus::EXPIRED->value => new ExpiredState(),
            SubscriptionStatus::SUSPENDED->value => new SuspendedState(),
            SubscriptionStatus::PAST_DUE->value => new PastDueState(),
            default => throw new \InvalidArgumentException("Invalid subscription status: {$status}"),
        };
    }
}
