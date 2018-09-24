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

    public function type() {
        return $this->hasOne('App\Type','id','type_id');
    }

    public function specie(){
        return $this->hasOne('App\Specie','id','specie_id');
    }            
}
