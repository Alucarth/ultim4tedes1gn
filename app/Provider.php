<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    //

     public function contacts()
     {
        return $this->hasMany('App\Contact');
     }
}
