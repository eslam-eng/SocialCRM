<?php

namespace App\Models;

class VerificationCode extends BaseModel
{
    protected $fillable = [
        'email',
        'code',
        'type',
        'attempts',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function hasExceededMaxAttempts(): bool
    {
        return $this->attempts >= 5; // Configure max attempts as needed
    }
}
