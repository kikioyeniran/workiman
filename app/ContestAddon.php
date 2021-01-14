<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestAddon extends Model
{
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
