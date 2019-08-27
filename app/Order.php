<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function contract() {
        return $this->hasOne('App\Contract','id','contract_id');
    }

    public function products() {
        return $this->belongsToMany('App\Product','product_order')->withPivot('quantity','description','density','width','high','array_type');
    }

    public function inventories() {
        return $this->belongsToMany('App\InventoryOrder','inventory_order')->withPivot('quantity','used_quantity');
    }

    public function construction() {
        return $this->hasOne('App\Construction','id','construction_id');
    }

}
