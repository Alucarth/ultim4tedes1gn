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
