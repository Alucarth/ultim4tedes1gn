<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyout extends Model
{
    protected $attributes = array(        
        'provider_id' => null,
        'date' => null,
        'description' => null,
        'amount' => null,
        'employee_id' => null,
    );

    /**
     * Get the provider for the buyout.
     */
    public function provider() {
        return $this->hasOne('App\Provider','id','provider_id');
    }

    /**
     * Get the employee for the buyout.
     */
    public function employee() {
        return $this->hasOne('App\Employee','id','employee_id');
    }

    /**
     * Get the inventories for the buyout.
     */
    public function inventories()
    {
        return $this->belongsToMany('App\Inventory','purchase_inventory')->withPivot(['quantity']);
    }
}
