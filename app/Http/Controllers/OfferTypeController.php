<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfferType;
class OfferTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $offer_types = OfferType::all();
        return response()->json(compact('offer_types'));
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
        // return $request->all();
        if($request->has('id')){
            $offer_type = OfferType::find($request->id);
        }else{
            $offer_type = new OfferType;
        }
        $offer_type->name = $request->name;
        $offer_type->save();
        
        $data = [
            'offer_type'  =>  $offer_type
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
        $offer = OfferType::find($id);
        
        $data = [
            'offer'  =>  $offer
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
        $offer = OfferType::find($id);
        $data = [
            'offer_id'    =>  $offer->id
        ];
        $offer->delete();
        return response()->json($data);
    }
}
