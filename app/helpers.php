<?php

use App\CurrencyRate;
use Stevebauman\Location\Facades\Location;

function getCurrencyFromLocation()
{
    // Set default currency to dollar
    $currency = config("currency.currencies.dollar");

    // Check if user is in Nigeria
    // if ($position = Location::get("169.255.125.126")) {
    if ($position = Location::get()) {
        // dd($position);
        // Successfully retrieved position.
        if ($position->countryCode == "NG") {
            // Set Currency to Naira
            $currency = config("currency.currencies.naira");
        }
    }

    return json_decode(json_encode($currency));
}

function getCurrencyAmount($source_currency, $source_amount, $destination_currency)
{
    $source_amount = intval($source_amount);
    $destination_amount = 0;

    if ($source_currency == $destination_currency) {
        $destination_amount = $source_amount;
    } else {
        if ($source_currency == "dollar") {
            // Get Naira Exchange Rate
            $currency = json_decode(json_encode(config("currency.currencies.naira")));

            if ($currency) {
                $rate = CurrencyRate::where('country_id', 566)->count() ? CurrencyRate::where('country_id', 566)->first()->rate : null;

                $destination_amount = $source_amount * $rate;
            }
        } else {
            // Get Dollar Exchange Rate
            $currency = json_decode(json_encode(config("currency.currencies.dollar")));

            if ($currency) {
                $rate = CurrencyRate::where('country_id', 566)->count() ? CurrencyRate::where('country_id', 566)->first()->rate : null;

                $destination_amount = $source_amount / $rate;
            }
        }
    }

    return $destination_amount;
}

function getUserCurrencyAmount($user_currency, $source_amount, $destination_currency, $dollar_rate)
{
    $source_amount = intval($source_amount);
    $destination_amount = 0;

    if ($user_currency == $destination_currency) {
        $destination_amount = $source_amount;
    } else {
        $destination_amount = $source_amount * $dollar_rate;
    }

    return $destination_amount;
}