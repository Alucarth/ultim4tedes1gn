<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Work;
use App\WorkItem;
class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function index_employee($employee_id)
    {
        $works= Work::with('work_items')->where('employee_id',$employee_id)->get();
        $employee = Employee::find($employee_id);
        return response()->json(compact('works','employee'));
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
        // return $request->date;

        if($request->has('id'))
        {
            $work = Work::find($request->id);
        }else{
            $work = new Work;
        }
        $work->date = $request->date;
        $work->employee_id = $request->employee_id;
        $work->save();

        foreach($request->work_items as $item)
        {
            $wk = (object) $item;
            // return $wk->area;
            $work_item = new WorkItem;
            $work_item->area_id = $wk->area['id'];
            $work_item->order_id = $wk->order['id'];
            $work_item->product_id = $wk->product['id'];
            $work_item->task_id = $wk->task['id'];
            $work_item->work_id = $work['id'];
            $work_item->observation = $wk->observation;
            $work_item->quantity = $wk->quantity;
            $work_item->time = 2.3;
            $work_item->save();
        }

        return response()->json($work);

        // return $request->all();
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
        $work = Work::with('work_items')->find($id);
        return response()->json(compact('work'));
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
