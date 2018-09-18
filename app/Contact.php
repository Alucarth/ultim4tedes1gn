<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $attributes = array(
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'phone' => null,
        'position' => null,
        'city'  => null,
    );

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
