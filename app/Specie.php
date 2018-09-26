<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specie extends Model
{
    protected $attributes = array(
        'name' => null,
        'description' => null
    );
}
