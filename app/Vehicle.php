<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function incidents()
    {
        return $this->hasMany('App\Incident');
    }
    public function driver(){

        return $this->belongsTo('App\Driver');
    
    }
}
