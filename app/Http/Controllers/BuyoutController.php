<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buyout;

class BuyoutController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buyout = new Buyout();        
        //$pivot = ['quantity'=>null];
        $data = [
            'buyout'  =>  $buyout,
          //  'pivot'    =>  $pivot,
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
        $buyout = new Buyout();        
        $buyout->date = $request->buyout['date'];
        $buyout->provider_id = $request->buyout['provider_id'];
        $buyout->employee_id = $request->buyout['employee_id'];
        $buyout->description = $request->buyout['description'];
        $buyout->amount = $request->buyout['amount'];
        $buyout->save();
        $inventories = [];
        foreach($request->inventories as $inventory) {
            $inventories[$inventory['id']] = [
                'quantity' => $inventory['quantity']
            ];
        }                
        $buyout->inventories()->attach($inventories);        
        return $buyout;
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
