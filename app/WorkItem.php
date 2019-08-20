<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkItem extends Model
{
    //
    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
