<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Construction extends Model
{
    public function client() {
        return $this->hasOne('App\Client','id','client_id');
    }

    public function status() {
        return $this->hasOne('App\Status','id','status_id');
    }
}
