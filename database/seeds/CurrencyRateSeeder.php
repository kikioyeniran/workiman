<?php

use App\CurrencyRate;
use Illuminate\Database\Seeder;

class CurrencyRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (CurrencyRate::where('country_id', 840)->count() < 1) {
            $currency_rate = new CurrencyRate();
            $currency_rate->country_id = 840;
            $currency_rate->rate = 1;
            $currency_rate->save();
        }
        if (CurrencyRate::where('country_id', 566)->count() < 1) {
            $currency_rate = new CurrencyRate();
            $currency_rate->country_id = 566;
            $currency_rate->rate = 450;
            $currency_rate->save();
        }
    }
}