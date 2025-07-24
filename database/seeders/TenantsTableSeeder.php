<?php

namespace Database\Seeders;

use App\Enum\ActivationStatusEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::factory()->count(5)->create();
    }
}
