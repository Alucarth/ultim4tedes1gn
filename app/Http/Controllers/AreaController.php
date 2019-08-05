<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::with(['inventories'])->get();

        $data = [
            'areas' => $areas
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
            $area = Area::find($request->id);
        }else{

            $area = new Area;
        }
        $area->name = $request->name;
        $area->description = $request->description;
        $area->save();

        return $area;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = Area::with(['inventories','inventories.type'])->find($id);
        $data = [
            'area' => $area
        ];

        return response()->json($data);
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
        $area = Area::find($id);
        return response()->json($area);
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
        $area = Area::find($id);
        $data = [
            'area_id'    =>  $area->id
        ];
        $area->delete();
        return response()->json($data);
    }

    public function transfer(Request $request) {
        $from = Area::with(['inventories'])->find($request->from_area_id);
        $to = Area::with(['inventories'])->find($request->to_area_id);
        $from_inventories = [];
        $to_inventories = [];
        foreach($request->inventories as $inventory) {
            $from_inventories[$inventory['id']] = [
                'quantity' => $from->inventories()->find($inventory['id'])->pivot->quantity - $inventory['quantity']
            ];
            $to_inventories[$inventory['id']] = [
                'quantity' => $inventory['quantity']+($to->inventories()->find($inventory['id'])->pivot->quantity ?? 0)
            ];
        }
        $from->inventories()->syncWithoutDetaching($from_inventories);
        $to->inventories()->syncWithoutDetaching($to_inventories);


        return $to;
    }
}
