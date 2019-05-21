<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    
    protected $attributes = array(
        'code' => null,
        'name' => null,
        'storage_id' => null,        
    );

    /**
     * Get the storage for the package.
     */
    public function storage() {
        return $this->hasOne('App\Storage','id','storage_id');
    }

    /**
     * Get the lumbers for the package.
     */
    public function lumbers()
    {
        return $this->belongsToMany('App\Lumber','package_lumber')->withPivot(['quantity','quantity_feet']);
    }
}
