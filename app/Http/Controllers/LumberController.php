<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lumber;

class LumberController extends Controller
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
     * @return \App\Lumber[] $lumbers 
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';  

        $code = $request->code ?? '';
        $high = $request->high ?? 0;
        $wide = $request->wide ?? 0;
        $lenght = $request->length ?? 0;        
        $description = $request->description ?? '';
        $specie = $request->specie ?? '';
        $quality = $request->quality ?? '';

        
        $total = Lumber::
            leftJoin('qualities','lumbers.quality_id','=','qualities.id')
            ->leftJoin('species','lumbers.specie_id','=','species.id')
            ->where('lumbers.code','like',$code.'%')            
            ->where('lumbers.description','like',$description.'%')            
            ->where('species.name', 'like', $specie.'%')
            ->where('qualities.name','like', $quality.'%')
            ->count();

        $lumbers = Lumber::              
            select(
                'lumbers.id',
                'lumbers.code',
                'lumbers.wide',
                'lumbers.high',
                'lumbers.length',
                'lumbers.description',
                'qualities.name as quality',
                'species.name as specie'
            )
            ->leftJoin('qualities','lumbers.quality_id','=','qualities.id')
            ->leftJoin('species','lumbers.specie_id','=','species.id')
            ->where('lumbers.code','like',$code.'%')        
            ->where('lumbers.description','like',$description.'%')            
            ->where('species.name', 'like', $specie.'%')
            ->where('qualities.name','like', $quality.'%')
			->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)            
            ->get();
        
        return response()->json(
        [
            'lumbers' => $lumbers->toArray(),
            'total'=>$total,
        ]);
    }
}
