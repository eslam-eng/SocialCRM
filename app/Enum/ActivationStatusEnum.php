<?php

namespace App\Enum;

enum ActivationStatusEnum: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => __('lang.active'),
            self::INACTIVE => __('lang.inactive'),
        };
    }
}
