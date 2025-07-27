<?php

namespace App\Models;

use App\Traits\HasTenantScope;

class TemplateParameter extends BaseModel
{
    use HAsTenantScope;

    protected $fillable = [
        'template_id',
        'variable_name',
        'default_value',
        'is_required',
        'integration_source',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * Get the template that owns this parameter
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}
