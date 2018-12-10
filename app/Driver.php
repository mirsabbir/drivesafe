<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }
    public function vehicle()
    {
        return $this->hasOne('App\Vehicle');
    }
}
