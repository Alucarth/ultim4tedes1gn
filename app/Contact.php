<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
