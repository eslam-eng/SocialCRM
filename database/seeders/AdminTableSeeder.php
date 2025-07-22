<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->create(['email' => 'superadmin@localhost']);
        Admin::factory()->count(3)->create();
    }
}
