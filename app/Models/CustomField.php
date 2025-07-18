<?php

namespace App\Models;

use App\Traits\HasTenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomField extends BaseModel
{
    use HasTenantScope;

    protected $fillable = ['tenant_id', 'model_type', 'field_name', 'field_type'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function values()
    {
        return $this->hasMany(CustomFieldValue::class);
    }
}
