<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * The area that belong to the inventory.
     */
    public function inventories()
    {
        return $this->belongsToMany('App\Inventory','inventory_area')->withPivot(['quantity']);
    }
}
