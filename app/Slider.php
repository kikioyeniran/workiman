<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table  = 'sliders';
    //Primary Key
    public $primaryKey = 'id';
    // Timestamsp
    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function getSliders()
    {
        $sliders = $this::orderBy('created_at', 'desc')->where('disabled', false)->get();
        return $sliders;
    }
    public function getDisabledSliders()
    {
        $sliders = $this::orderBy('created_at', 'desc')->where('disabled', true)->get();
        return $sliders;
    }
}