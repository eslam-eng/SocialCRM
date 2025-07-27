<?php

namespace App\Models;

use App\Traits\HasTenantScope;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends BaseModel
{
    use HasTenantScope, HasUlids;

    protected $fillable = [
        'name',
        'description',
        'category',
        'template_type',
        'content',
        'header_type',
        'header_content',
        'footer_content',
        'is_active',
        'tenant_id',
    ];

    public function buttons(): HasMany
    {
        return $this->hasMany(TemplateButton::class)->orderBy('sort_order');
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(TemplateParameter::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
