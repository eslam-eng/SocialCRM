<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Feature extends BaseModel
{
    use HasTranslations;

    protected $fillable = ['key', 'name', 'description', 'group'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class)->withPivot('value');
    }
}
