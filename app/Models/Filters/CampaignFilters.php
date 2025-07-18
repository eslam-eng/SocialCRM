<?php

namespace App\Models\Filters;

use App\Abstracts\QueryFilter;

class CampaignFilters extends QueryFilter
{
    public function __construct($params = [])
    {
        parent::__construct($params);
    }
}
