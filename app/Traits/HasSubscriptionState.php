<?php

namespace App\Traits;

use App\Patterns\States\Subscription\SubscriptionContext;

/**
 * @property int $status
 * @method bool save()
 */
trait HasSubscriptionState
{
    private ?SubscriptionContext $subscriptionState = null;

    public function getStateAttribute(): SubscriptionContext
    {
        if ($this->subscriptionState === null) {
            $this->subscriptionState = new SubscriptionContext($this->status);
        }

        return $this->subscriptionState;
    }

    public function activate(): void
    {
        $this->state->activate();
        $this->updateStatus();
    }

    public function cancel(): void
    {
        $this->state->cancel();
        $this->updateStatus();
    }

    public function expire(): void
    {
        $this->state->expire();
        $this->updateStatus();
    }

    public function suspend(): void
    {
        $this->state->suspend();
        $this->updateStatus();
    }

    public function markAsPastDue(): void
    {
        $this->state->markAsPastDue();
        $this->updateStatus();
    }

    public function isActive(): bool
    {
        return $this->state->getStatus() === 'ACTIVE';
    }

    public function isPending(): bool
    {
        return $this->state->getStatus() === 'PENDING';
    }

    public function isCanceled(): bool
    {
        return $this->state->getStatus() === 'CANCELED';
    }

    public function isExpired(): bool
    {
        return $this->state->getStatus() === 'EXPIRED';
    }

    public function isSuspended(): bool
    {
        return $this->state->getStatus() === 'SUSPENDED';
    }

    public function isPastDue(): bool
    {
        return $this->state->getStatus() === 'PAST_DUE';
    }

    protected function updateStatus(): void
    {
        $this->status = $this->state->getStatusCode();
        $this->save();
    }
}
