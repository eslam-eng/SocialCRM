<?php

namespace App\Models\Filters;

use App\Abstracts\QueryFilter;

class TagsFilter extends QueryFilter
{
    public function __construct($params = [])
    {
        parent::__construct($params);
    }
}
