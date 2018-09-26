<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    //
    protected $attributes = array(
        'name' => null,
        'offer' => null,
        'description' => null,
        'address1' => null,
        'address2' => null,
        'city'   => null,
        'balance'   => null,
        'debit'   => null,
    );

     public function contacts()
     {
        return $this->hasMany('App\Contact');
     }
}
