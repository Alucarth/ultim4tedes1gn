<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
      
    protected $fillable = array('id');

    protected $attributes = array(
        'code' => null,
        'minimum' => null,
        'description' => null,
        'observation' => null,
        'active'   => null,
    );
}
