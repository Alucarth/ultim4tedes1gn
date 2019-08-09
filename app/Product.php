<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function product_type() {
        return $this->hasOne('App\ProductType','id','product_type_id');
    }    
}
