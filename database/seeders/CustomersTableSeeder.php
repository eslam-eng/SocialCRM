<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->count(5)->create();
    }
}
