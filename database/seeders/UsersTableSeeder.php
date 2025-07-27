<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'eslam@gmail.com'
        ]);

        User::factory()->count(4)->create();

        User::query()->withoutGlobalScopes()
            ->get()->each(function ($user) {
                TenantUser::query()->create([
                    'tenant_id' => $user->tenant_id,
                    'user_id' => $user->id,
                ]);
                // Check if there's already an owner for this tenant
                $existingOwner = User::query()
                    ->role(Role::OWNER)
                    ->whereHas('tenants', function ($query) use ($user) {
                        $query->where('tenants.id', $user->tenant_id);
                    })
                    ->exists();

                // If no owner exists for this tenant, assign this user as owner
                if (!$existingOwner) {
                    $user->assignRole(Role::OWNER);
                    $user->update(['role' => Role::OWNER]);
                }

            });
    }
}
