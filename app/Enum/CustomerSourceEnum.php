<?php

namespace App\Enum;

enum CustomerSourceEnum: int
{
    case MANUAL = 1;
    case WEBSITE = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::MANUAL => __('app.active'),
            self::WEBSITE => __('app.inactive'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
