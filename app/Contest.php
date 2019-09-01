<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    public function payment()
    {
        return $this->hasOne(ContestPayment::class);
    }
}
