<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
        
    protected $attributes = array(
        // 'high' => null,
        // 'width' => null,
        // 'density' => null,
        // 'specie_id' => null,
        // 'type_id'   => null,
        // 'description'   =>  null
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
