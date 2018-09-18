<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lumber extends Model
{
    
    protected $attributes = array(
        'high' => null,
        'width' => null,
        'density' => null,
        'specie_id' => null,
        'type_id'   => null,
        'description'   =>  null
    );

    public function type(){
        return $this->belongsTo('App\Type');
    }

    public function specie(){
        return $this->belongsTo('App\Specie');
    }            
}
