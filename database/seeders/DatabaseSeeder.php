<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CurrencyTableSeeder::class);
        $this->call(TenantsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
