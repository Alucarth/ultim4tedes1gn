<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lumber extends Model
{
    //
    public function type(){
        return $this->belongsTo('App\Type');
    }

    public function specie(){
        return $this->belongsTo('App\Specie');
    }
}
