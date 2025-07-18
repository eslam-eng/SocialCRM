<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('currencies.json');

        $jsonContents = file_get_contents($file);

        $currenciesData = json_decode($jsonContents, true); // decode as associative array
        $currencies = [];
        foreach ($currenciesData as $currency) {
            $currencies[] = [
                'code' => $currency['code'],           // e.g., 'USD', 'EUR'
                'name' => $currency['name'],           // e.g., 'US Dollar', 'Euro'
                'symbol' => $currency['symbol'],         // e.g., '$', '€'
            ];
        }
        Currency::query()->insert($currencies);
    }
}
