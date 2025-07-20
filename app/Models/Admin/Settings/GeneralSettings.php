<?php

namespace App\Models\Admin\Settings;

use App\Models\BaseSetting;

class GeneralSettings extends BaseSetting
{
    public static function groupName(): string
    {
        return 'general_landlord';
    }
}
