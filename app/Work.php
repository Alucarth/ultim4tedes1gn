<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    //
    public function work_items(){
        return $this->hasMany('App\WorkItem')->with('area','product','order','task');
    }
}
