<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Provider extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'name' => null,
        'description' => null,
        'address1' => null,
        'address2' => null,
        'city'   => null,
        'balance'   => null,
        'debit'   => null,
    );

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }
    public function offer_types()
    {
        return $this->belongsToMany('App\OfferType','offer_type_providers');
    }
}
