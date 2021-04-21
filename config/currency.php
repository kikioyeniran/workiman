<?php

use App\CurrencyRate;

return [
    'currencies' => [
        'dollar' => [
            'short_name' => 'USD',
            'symbol' => '$',
            'country_id' => 840,
            'name' => 'dollar',
            // 'exchange_rate' => CurrencyRate::where('country_id', 840)->count() ? CurrencyRate::where('country_id', 840)->first()->rate : null
        ],
        'naira' => [
            'short_name' => 'NGN',
            'symbol' => '₦',
            'country_id' => 566,
            'name' => 'naira',
            // 'exchange_rate' => CurrencyRate::where('country_id', 566)->count() ? CurrencyRate::where('country_id', 566)->first()->rate : null
        ],
    ],

    'default' => 'dollar'
];