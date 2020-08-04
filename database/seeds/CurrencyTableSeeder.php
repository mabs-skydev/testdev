<?php

use App\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            "USD",
            "EUR",
            "CAD",
            "AUD",
            "BTC",
            "ETH",
        ];

        foreach ($currencies as $currency) {
            Currency::create(['name' => $currency]);
        }
    }
}
