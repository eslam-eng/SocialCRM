<?php

namespace App\Enum;

enum SubscriptionStatusEnum: int
{
    case PENDING = 0;
    case ACTIVE = 1;
    case CANCELED = 2;
    case EXPIRED = 3;
    case SUSPENDED = 4;
    case PAST_DUE = 5;
}
