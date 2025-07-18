<?php

namespace App\Models;

class Currency extends BaseModel
{
    protected $fillable = [
        'code',           // e.g., 'USD', 'EUR'
        'name',           // e.g., 'US Dollar', 'Euro'
        'symbol',         // e.g., '$', '€'
        'decimal_places', // e.g., 2
        'is_active',      // boolean
        'is_default',     // boolean
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'decimal_places' => 'integer',
    ];
}
