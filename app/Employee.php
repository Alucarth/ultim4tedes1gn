<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
        
    protected $attributes = array(
        'name' => null,
        'last_name' => null,
        'identity_card' => null,
        'item' => null,
        'entry_date' => null,
        'departure_date' => null,
        'salary' => null,
        'bonus' => null,
        'extra_hour' => null,
        'official_area_id' => null,
        'tempora_area_id' => null,
        'position_id' => null,
        'employee_contract_type_id' => null,
        'employee_type_id' => null,
        'active' => null,       
    );

    public function type() {
        return $this->hasOne('App\EmployeeType','id','employee_type_id');
    }

    public function contact_type(){
        return $this->hasOne('App\EmployeeContractType','id','employee_contract_type_id');
    } 

    public function position() {
        return $this->hasOne('App\Position','id','positions_id');
    }

    public function official_area() {
        return $this->hasOne('App\Area','id','official_area_id');
    }

    public function temporal_area() {
        return $this->hasOne('App\Area','id','temporal_area_id');
    }
}
