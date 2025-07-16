<?php

namespace App\Patterns\States\Subscription;

use App\Enum\SubscriptionStatus;

abstract class AbstractSubscriptionState implements SubscriptionStateInterface
{
    protected SubscriptionContext $context;
    protected SubscriptionStatus $status;

    public function setContext(SubscriptionContext $context): void
    {
        $this->context = $context;
    }

    public function getStatus(): string
    {
        return $this->status->name;
    }

    public function getStatusCode(): int
    {
        return $this->status->value;
    }

    // Default implementations that throw exceptions for invalid state transitions
    public function activate(): void
    {
        throw new \RuntimeException("Cannot transition from {$this->getStatus()} to ACTIVE");
    }

    public function cancel(): void
    {
        throw new \RuntimeException("Cannot transition from {$this->getStatus()} to CANCELED");
    }

    public function expire(): void
    {
        throw new \RuntimeException("Cannot transition from {$this->getStatus()} to EXPIRED");
    }

    public function suspend(): void
    {
        throw new \RuntimeException("Cannot transition from {$this->getStatus()} to SUSPENDED");
    }

    public function markAsPastDue(): void
    {
        throw new \RuntimeException("Cannot transition from {$this->getStatus()} to PAST_DUE");
    }
}
