<?php

namespace App\Models;

class CustomFieldValue extends BaseModel
{
    protected $fillable = ['custom_field_id', 'model_id', 'model_type', 'value'];

    public function field()
    {
        return $this->belongsTo(CustomField::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
