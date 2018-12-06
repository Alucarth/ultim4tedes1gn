<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;

class InventoryController extends Controller
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

        $inventory_conditions = [];
        $family_conditions = [];
        $type_conditions = [];
        $code = $request->high ?? null;
        $minimum = $request->minimum ?? null;
        $description = $request->description ?? null;
        $family = $request->family ?? null;
        $type = $request->type ?? null;

        if ($code) {
            array_push($inventory_conditions, ['code','=',"{$code}"]);
        }
        if ($minimum) {
            array_push($inventory_conditions, ['mini$minimum','=',"{$minimum}"]);
        }        
        if ($description) {
            array_push($inventory_conditions, ['description','like',"%{$description}%"]);
        }
        if ($family) {
            array_push($family_conditions, ['name','like',"%{$family}%"]);
        }
        if ($type) {
            array_push($type_conditions, ['name','like',"%{$type}%"]);
        }

        $inventories = Inventory::with(['family','type'])
                            ->where($inventory_conditions)
                            ->whereHas('family', function ($query) use ($family_conditions) {
                                $query->where($family_conditions);
                            })
                            ->whereHas('type', function ($query) use ($type_conditions) {
                                $query->where($type_conditions);
                            })
                            ->paginate($pagination_rows);
        $data = [
            'inventories'   =>  $inventories
        ];
        return response()->json($inventories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $inventory = new Inventory();
        $data = [
            'inventory'    =>  $inventory
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
