<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Construction;

class ConstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $constructions = Constructions::orderBy('id')->get();

        $data = [
            'constructions'  =>  $constructions
        ];

        return response()->json($constructions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $construction = new Construction();
        $data = [
            'construction'   =>  $construction,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in construction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        if($request->has('id')) {        
            $construction = Construction::find($request->id);
        } else {
            $construction = new Construction();                        
        }
        $construction->client_id = $request->client_id;
        $construction->name = $request->name;        
        $construction->description = $request->description;
        $construction->amount = $request->amount;
        $construction->save();
        
        $data = [
            'construction'    =>  $construction
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
        $construction = Construction::find($id); 
        $data = [
            'construction'  =>  $construction
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
        $construction = Construction::find($id);
        $data = [
            'construction'  =>  $construction
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in construction.
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
        $construction = Construction::find($id);
        $data = [
            'construction_id'    =>  $construction->id
        ];
        $construction->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from lumber
     * 
     * @param int $id
     * @return \App\Client[] $clients
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';  
        
        $client = $request->name ?? '';
        $name = $request->name ?? '';        
        $description = $request->description ?? '';
                        
        $total = Construction::
            where('name','like',$name.'%')            
            ->where('description','like',$description.'%')
            ->count();

        $construction = Construction::
            where('name','like',$name.'%')            
            ->where('description','like',$description.'%')
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();
            
        return response()->json([
            'clients' => $construction->toArray(),
            'total'=>$total,
        ]);
    }
}
