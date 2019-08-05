<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeContractType;
class EmployeeContractTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contract_types = EmployeeContractType::get();

        $data = [
            'contract_types' =>$contract_types
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->has('id')){
            $employe_contract_type = EmployeeContractType::find($request->id);
        }else{

            $employe_contract_type = new EmployeeContractType;
        }
        $employe_contract_type->name = $request->name;
        $employe_contract_type->description = $request->description;
        $employe_contract_type->save();

        return $employe_contract_type;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $employee_contract_type = EmployeeContractType::find($id);
        return response()->json($employee_contract_type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $employee_contract_type = EmployeeContractType::find($id);
        $data = [
            'employee_contract_type_id'    =>  $employee_contract_type->id
        ];
        $employee_contract_type->delete();
        return response()->json($data);
    }
}
