<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public function construction() {
        return $this->hasOne('App\Construction','id','construction_id');
    }
}
