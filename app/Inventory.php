<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
      
    protected $fillable = array('id');

    protected $attributes = array(
        'code' => null,
        'minimum' => null,
        'description' => null,
        'observation' => null,
        'active'   => null,
    );

    public function type() {
        return $this->hasOne('App\InventoryType','id','inventory_type_id');
    }

    public function family() {
        return $this->hasOne('App\Family','id','family_id');
    }

    public function unit() {
        return $this->hasOne('App\Unit','id','unit_id');
    }
}
