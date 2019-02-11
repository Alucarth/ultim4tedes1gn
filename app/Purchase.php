<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    protected $attributes = array(
        'cefo' => null,
        'provider_id' => null,
        'date' => null,
        'description' => null,
        'amount' => null,
    );

    /**
     * Get the provider for the purchase.
     */
    public function provider() {
        return $this->hasOne('App\Provider','id','provider_id');
    }

    /**
     * Get the lumbers for the purchase.
     */
    public function lumbers()
    {
        return $this->belongsToMany('App\Lumber','purchase_lumber')->withPivot(['quantity','quantity_feet','amount','state_id']);
    }

    public function expenses(){
        return $this->belongsToMany('App\Expensive','purchase_expenses')->withPivot(['cost']);
    }
}
