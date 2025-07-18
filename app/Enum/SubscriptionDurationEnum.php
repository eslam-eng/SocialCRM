<?php

namespace App\Enum;

enum SubscriptionDurationEnum: string
{
    case MONTHLY = 'month';
    case YEAR = 'year';
    case LIFE_TIME = 'life time';
}
