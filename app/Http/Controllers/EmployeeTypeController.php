<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeType;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = EmployeeType::get();

        $data = [
            'types' => $types
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
            $employe_type = EmployeeType::find($request->id);
        }else{

            $employe_type = new EmployeeType;
        }
        $employe_type->name = $request->name;
        $employe_type->description = $request->description;
        $employe_type->save();

        return $employe_type;
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
        $employee_type = EmployeeType::find($id);
        return response()->json($employee_type);
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
        $employee_type = EmployeeType::find($id);
        $data = [
            'employee_type_id'    =>  $employee_type->id
        ];
        $employee_type->delete();
        return response()->json($data);
    }
}
