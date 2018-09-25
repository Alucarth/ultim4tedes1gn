<?php

namespace App\Http\Controllers;

use App\LumberInventory;
use Illuminate\Http\Request;

class LumberInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = LumberInventory::get();
        return response()->json(
        [
            'inventories' => $inventories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventory = new LumberInventory();
        $data = [
            'inventory'    =>  $inventory,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in inventory.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $inventory = new LumberInventory();
        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->save();
        
        $data = [
            'inventory'    =>  $inventory
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = LumberInventory::find($id);
        
        $data = [
            'inventory'  =>  $inventory
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
        $inventory = LumberInventory::find($id);
        
        $data = [
            'inventory'  =>  $inventory
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in inventory.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inventory = LumberInventory::find($id);
        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->save();
        
        $data = [
            'inventory'    =>  $inventory
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from inventory.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = LumberInventory::find($id);
        $data = [
            'storage_id'    =>  $storage->id
        ];
        $storage->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from lumber
     * 
     * @param int $id
     * @return \App\Storage[] $inventories 
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';  
        
        $name = $request->name ?? '';
        $description = $request->description ?? '';
                
        $total = LumberInventory::
            where('name','like',$name.'%')
            //where('description','like',$description.'%')
            ->count();

        $inventories = LumberInventory::
            where('name','like',$name.'%')
//            ->where('description','like',$description.'%')
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();
            
        return response()->json(
        [
            'inventories' => $inventories->toArray(),
            'total'=>$total,
        ]);
    }
}
