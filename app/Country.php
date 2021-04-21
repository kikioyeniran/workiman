<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function currency_rate()
    {
        return $this->hasOne(CurrencyRate::class);
    }
}