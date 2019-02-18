<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OriginType;
class OriginTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $order = request('order'??'');
        $pagination_rows = request('pagination_rows'??10);
        $name = request('name')??'';
        $description = request('description')??'';
        ;
        
        $conditions = [];
        if($name != '')
        {
            array_push($conditions,array('name','like',"%{$name}%"));
        }
        if($description != '')
        {
            array_push($conditions,array('description','like',"%{$description}%"));
        }

        $expenses = OriginType::where($conditions)
                                ->orderBy('name')
                                ->paginate($pagination_rows);
        return response()->json($expenses->toArray());
    }

    public function getData(){
        $origin_types = OriginType::all();
        return response()->json($origin_types->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $origin_type=new OriginType;
        $origin_type->name ='';
        $origin_type->description ='';
        return response()->json($origin_type->toArray());
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
        $origin_type = new OriginType;
        $origin_type->name = $request->name;
        $origin_type->description = $request->description;
        $origin_type->save();
        return response()->json($origin_type->toArray());
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
        $origin_type = OriginType::find($id);
        $origin_type->name = $request->name;
        $origin_type->description = $request->description;
        $origin_type->save();
        return response()->json($origin_type->toArray());
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
