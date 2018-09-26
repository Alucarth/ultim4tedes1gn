<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specie;
class SpecieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $species = Specie::get();
        return response()->json(
        [
            'species' => $species,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specie = new Specie();
        $data = [
            'specie'    =>  $specie,
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
        $specie = new Specie();
        $specie->name = $request->name;
        $specie->description = $request->description;
        $specie->save();
        
        $data = [
            'specie'    =>  $specie
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
        $specie = Specie::find($id);
        
        $data = [
            'specie'  =>  $specie
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
        $specie = Specie::find($id);
        
        $data = [
            'specie'  =>  $specie
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
        $specie = Specie::find($id);
        $specie->name = $request->name;
        $specie->description = $request->description;
        $specie->save();
        
        $data = [
            'specie'    =>  $specie
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
        $specie = Specie::find($id);
        $data = [
            'specie_id'    =>  $specie->id
        ];
        $specie->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from lumber
     * 
     * @param int $id
     * @return \App\Specie[] $species 
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';  
        
        $name = $request->name ?? '';
        $description = $request->description ?? '';
                
        $total = Specie::
            where('name','like',$name.'%')
            //where('description','like',$description.'%')
            ->count();

        $species = Specie::
            where('name','like',$name.'%')
//            ->where('description','like',$description.'%')
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();
            
        return response()->json(
        [
            'species' => $species->toArray(),
            'total'=>$total,
        ]);
    }
}
