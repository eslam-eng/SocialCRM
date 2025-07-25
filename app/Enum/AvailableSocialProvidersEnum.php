<?php

namespace App\Enum;

enum AvailableSocialProvidersEnum: string
{
    case GOOGLE = 'google';
    case FACEBOOK = 'facebook';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
