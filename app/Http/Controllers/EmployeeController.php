<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = $request->order ?? 'asc';
        $pagination_rows = $request->pagination_rows ?? 10;               

        $employee_conditions = [];
        $official_area_conditions = [];
        $temporal_area_conditions = [];
        $position_conditions = [];
        $type_conditions = [];

        $item = $request->item ?? null;
        $identity_card = $request->identity_card ?? null;
        $name = $request->name ?? null;
        $last_name = $request->last_name ?? null;
        $official_area = $request->official_area ?? null;
        $temporal_area = $request->temporal_area ?? null;
        $type = $request->type ?? null;
        $position = $request->position ?? null;

        if ($item) {
            array_push($employee_conditions, ['item','=',"{$item}"]);
        }
        if ($identity_card) {
            array_push($employee_conditions, ['identity_card','=',"{$identity_card}"]);
        }
        if ($name) {
            array_push($employee_conditions, ['name','=',"{$name}"]);
        }
        if ($last_name) {
            array_push($employee_conditions, ['last_name','like',"%{$last_name}%"]);
        }
        if ($official_area) {
            array_push($official_area_conditions, ['name','like',"%{$official_area}%"]);
        }
        if ($temporal_area) {
            array_push($temporal_area_conditions, ['name','like',"%{$temporal_area}%"]);
        }
        if ($type) {
            array_push($type_conditions, ['name','like',"%{$type}%"]);
        }
        if($position) {
            array_push($position_conditions, ['name','like',"%{$position}%"]);
        }
        $employees = Employee::with(['official_area','temporal_area','position','type'])
                            ->where($employee_conditions)
                            ->whereHas('official_area', function ($query) use ($official_area_conditions) {
                                $query->where($official_area_conditions);
                            })
                            ->whereHas('temporal_area', function ($query) use ($temporal_area_conditions) {
                                $query->where($temporal_area_conditions);
                            })
                            ->whereHas('type', function ($query) use ($type_conditions) {
                                $query->where($type_conditions);
                            })
                            ->whereHas('position', function ($query) use ($position_conditions) {
                                $query->where($position_conditions);
                            })
                            ->paginate($pagination_rows);
        $data = [
            'employees'   =>  $employees
        ];
        return response()->json($employees);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new Employee();

        $data = [
            'employee'  =>  $employee
        ];

        return response()->json($data);
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
    }
}
