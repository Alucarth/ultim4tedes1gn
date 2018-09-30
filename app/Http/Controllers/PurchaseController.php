<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lumber.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase = new Purchase();
        $pivot = ['quantity'=>null];
        $data = [
            'purchase'  =>  $purchase,
            'pivot'    =>  $pivot,
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
        //return response()->json($request->purchase['cefo']);
        $purchase = new Purchase();
        $purchase->cefo = $request->purchase['cefo'];
        $purchase->date = $request->purchase['date'];
        $purchase->provider_id = $request->purchase['provider_id'];
        $purchase->description = "";
        $purchase->amount = 0;
        $purchase->save();
        //$purchase->lumbers()->attach($request->lumbers);
        $d = [1=>['quantity'=>'3'],
        2=>['quantity'=>'34'],
        3=>['quantity'=>'31'],
    ];
    $purchase->lumbers()->attach($d);
        //$purchase->lumbers()->attach([1,2,3]);
        return $purchase;
        //$purchase->cefo = $request->
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
