<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use Filterable, HasApiTokens,HasFactory,Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'locale',
        'country',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Generate a Sanctum token for the user.
     */
    public function generateToken(string $name = 'admin_token', array $abilities = ['*']): string
    {
        return $this->createToken($name, $abilities)->plainTextToken;
    }
}
