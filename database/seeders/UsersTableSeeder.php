<?php

namespace Database\Seeders;

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
        User::factory()->count(5)->create();
        User::all()->each(function ($user) {
            TenantUser::query()->create([
                'tenant_id' => $user->tenant_id,
                'user_id' => $user->id,
            ]);
        });
    }
}
