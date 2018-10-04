<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contact extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'phone' => null,
        'position' => null,
    );

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
