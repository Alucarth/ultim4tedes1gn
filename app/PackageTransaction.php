<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageTransaction extends Model
{
    protected $attributes = array(
        'number' => null,
        'date' => null,
        'description' => null,
        'storage_origin_id' => null,        
        'storage_destination_id' => null,                
    );

}
