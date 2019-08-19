<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::get();

        $data = [
            'assets'  =>  $assets
        ];

        return response()->json($assets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asset = new Asset();
        $data = [
            'asset'   =>  $asset,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in asset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('id')) {
            $asset = Asset::find($request->id);
            $asset->revaluation = $request->revaluation;
        } else {
            $asset = new Asset();
            $asset->revaluation = 0;
        }
        $asset->code = $request->code;
        $asset->name = $request->name;
        $asset->description = $request->description;
        $asset->location = $request->location;
        $asset->date = $request->date;
        $asset->price = $request->price;
        $asset->lifetime = $request->lifetime;
        $asset->actual_price = $request->price;
        $asset->depreciation = $request->depreciation;
        $asset->save();
        $data = [
            'asset'    =>  $asset
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
        $asset = Asset::find($id); 
        $data = [
            'asset'  =>  $asset
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
        $asset = Asset::find($id);
        $data = [
            'asset'  =>  $asset
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in asset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id);
        $data = [
            'asset_id'    =>  $asset->id
        ];
        $asset->delete();
        return response()->json($data);
    }

}
