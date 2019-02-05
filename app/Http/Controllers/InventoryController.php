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
        $unit_conditions = [];
        $code = $request->high ?? null;
        $minimum = $request->minimum ?? null;
        $description = $request->description ?? null;
        $family = $request->family ?? null;
        $type = $request->type ?? null;
        $unit = $request->unit ?? null;
        

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
        if ($unit) {
            array_push($unit_conditions, ['name','like',"%{$unit}%"]);
        }

        $inventories = Inventory::with(['family','type','unit','areas'])
                            ->where($inventory_conditions)
                            ->whereHas('family', function ($query) use ($family_conditions) {
                                $query->where($family_conditions);
                            })
                            ->whereHas('type', function ($query) use ($type_conditions) {
                                $query->where($type_conditions);
                            })
                            ->whereHas('unit', function ($query) use ($unit_conditions) {
                                $query->where($unit_conditions);
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
        $inventory = new Inventory();
        $inventory->code = $request->code;
        $inventory->minimum = $request->minimum;
        $inventory->description = $request->description;
        $inventory->active = $request->active;
        $inventory->inventory_type_id = $request->inventory_type_id;
        $inventory->family_id = $request->family_id;
        $inventory->unit_id = $request->unit_id;
        $inventory->observation = "";
        $inventory->save();

        $data = [
            'inventory' => $inventory
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
        $inventory = Inventory::with(['family','type','unit'])->find($id);
        
        $data = [
            'inventory' => $inventory
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
        $inventory = Inventory::with(['family','type','unit'])->find($id);
        
        $data = [
            'inventory' => $inventory
        ];

        return response()->json($data);
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
        $inventory = Inventory::find($id);
        $inventory->code = $request->code;
        $inventory->minimum = $request->minimum;
        $inventory->description = $request->description;
        $inventory->active = $request->active;
        $inventory->inventory_type_id = $request->inventory_type_id;
        $inventory->family_id = $request->family_id;
        $inventory->unit_id = $request->unit_id;
        $inventory->observation = "";
        $inventory->save();

        $data = [
            'inventory' => $inventory
        ];

        return response()->json($data);
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
