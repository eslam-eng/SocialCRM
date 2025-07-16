<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

class SubscriptionContext
{
    private AbstractSubscriptionState $state;

    public function __construct(int $status = SubscriptionStatus::PENDING->value)
    {
        $this->transitionTo($this->createStateFromStatus($status));
    }

    public function transitionTo(AbstractSubscriptionState $state): void
    {
        $this->state = $state;
        $this->state->setContext($this);
    }

    public function getState(): AbstractSubscriptionState
    {
        return $this->state;
    }

    public function getStatusCode(): int
    {
        return $this->state->getStatusCode();
    }

    public function getStatus(): string
    {
        return $this->state->getStatus();
    }

    public function activate(): void
    {
        $this->state->activate();
    }

    public function cancel(): void
    {
        $this->state->cancel();
    }

    public function expire(): void
    {
        $this->state->expire();
    }

    public function suspend(): void
    {
        $this->state->suspend();
    }

    public function markAsPastDue(): void
    {
        $this->state->markAsPastDue();
    }

    private function createStateFromStatus(int $status): AbstractSubscriptionState
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
