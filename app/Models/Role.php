<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    const OWNER = 'owner';
    const ADMIN = 'admin';
    const USER = 'user';
    const SUPER_ADMIN = 'super_admin';
}
