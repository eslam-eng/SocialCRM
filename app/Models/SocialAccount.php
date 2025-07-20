<?php

namespace App\Models;

class SocialAccount extends BaseModel
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'provider_name',
        'provider_id',
        'access_token',
        'refresh_token',
        'expires_in',
        'token_type',
        'scopes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
