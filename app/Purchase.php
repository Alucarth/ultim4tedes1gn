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
     * Get the lumbers for the purchase post.
     */
    public function lumbers()
    {
        return $this->belongsToMany('App\Lumber','purchase_lumber')->withPivot(['quantity']);
    }
}
