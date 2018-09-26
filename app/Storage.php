<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $attributes = array(
        'name' => null,
        'description' => null,
        'is_enabled'    =>  true,
    );
}
