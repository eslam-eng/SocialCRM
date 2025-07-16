<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends BaseModel
{
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
