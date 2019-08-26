<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function asset_type() {
        return $this->hasOne('App\AssetType','id','asset_type_id');
    }
    public function area() {
        return $this->hasOne('App\Area','id','area_id');
    }
}
