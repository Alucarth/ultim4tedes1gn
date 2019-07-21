<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Construction extends Model
{
    public function client() {
        return $this->hasOne('App\Client','id','client_id');
    }
}
