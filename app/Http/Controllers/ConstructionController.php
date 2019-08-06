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
        $constructions = Construction::with(['client'])->orderBy('id')->get();

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
            $construction->amount = $request->amount;
        } else {
            $construction = new Construction();
            $construction->amount = 0;         
        }
        $construction->client_id = $request->client_id;
        $construction->name = $request->name;        
        $construction->address = $request->addresss;
        $construction->status_id = $request->status_id;
        $construction->start_date = $request->start_date;
        $construction->end_date = $request->end_date;
        $construction->description = $request->description;
        
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

        $client = $request->client ?? '';
        $name = $request->name ?? '';
        $description = $request->description ?? '';

        $construction_conditions = [];
        $client_conditions = [];
        if($name) {
            array_push($construction_conditions, ['name','like',$name.'%']);
        }
        if($description) {
            array_push($construction_conditions, ['description', 'like', $description.'%']);
        }
        if($client) {
            array_push($client_conditions, ['name', 'like', $name.'%']);
        }
        $total = Construction::with(['client'])
            ->where($construction_conditions)
            ->whereHas('client', function($query) use($client_conditions) {
                $query->where($client_conditions);
            })
            ->count();

        $construction = Construction::with(['client'])
            ->where($construction_conditions)
            ->whereHas('client', function($query) use($client_conditions) {
                $query->where($client_conditions);
            })
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();

        return response()->json([
            'constructions' => $construction->toArray(),
            'total'=>$total,
        ]);
    }
}
