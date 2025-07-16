<?php

namespace App\Patterns\States\Subscription;

interface SubscriptionStateInterface
{
    public function activate(): void;
    public function cancel(): void;
    public function expire(): void;
    public function suspend(): void;
    public function markAsPastDue(): void;
    public function getStatus(): string;
}
