<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['code' => 'USD', 'symbol' => '$', 'exchange_rate' => 1.0000],
            ['code' => 'EUR', 'symbol' => '€', 'exchange_rate' => 0.9300],
            ['code' => 'GBP', 'symbol' => '£', 'exchange_rate' => 0.7900],
            ['code' => 'AED', 'symbol' => 'AED', 'exchange_rate' => 3.6700],
            ['code' => 'INR', 'symbol' => '₹', 'exchange_rate' => 83.0000],
            ['code' => 'KWD', 'symbol' => 'KWD', 'exchange_rate' => 0.3100],
        ];

        foreach ($currencies as $currency) {
            \App\Models\Currency::updateOrCreate(['code' => $currency['code']], $currency);
        }
    }
}
