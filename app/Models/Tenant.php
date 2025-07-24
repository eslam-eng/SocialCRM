<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;

class Tenant extends BaseModel
{
    use HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'users_count',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'tenant_users')
            ->withTimestamps();
    }
    public function owner() {
        return $this->hasOne(User::class)->where('role', Role::OWNER);
    }

    public function subscription() {
        return $this->hasOne(PlanSubscription::class)->latestOfMany(); // latest active
    }
    public static function booted()
    {
        static::creating(function ($tenant) {
            $tenant->slug = Str::slug($tenant->name);
        });
    }
}
