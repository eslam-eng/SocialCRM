<?php

namespace App\Enum;

enum FeatureGroupEnum: int
{
    case LIMIT = 1;
    case FEATURE = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
