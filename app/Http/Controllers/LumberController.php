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
        $lumber = new Lumber();
        $data = [
            'lumber'    =>  $lumber
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
        $lumber = Lumber::find($id);
        $data = [
            'lumber'    =>  $lumber
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
        $lumber = Lumber::find($id);
        $data = [
            'lumber'    =>  $lumber
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
        $lumber = Lumber::find($id);
        $lumber->high = $request->high;
        $lumber->width = $request->width;
        $lumber->density = $request->density;
        $lumber->description = $request->description;
        $lumber->type_id = $request->type_id;
        $lumber->specie_id = $request->specie_id;
        $lumber->save();
        $lumber = Lumber::find($id);
        //$lumber->with('species'); 
        $data = [
            'lumber'    =>  $lumber
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
        $lumber = Lumber::find($id);
        $data = [
            'lumber_id'    =>  $lumber->id
        ];
        $lumber->delete();
        return response()->json($data);
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

        $high = $request->high ?? 0;
        $width = $request->width ?? 0;
        $density = $request->density ?? 0;        
        $description = $request->description ?? '';
        $specie = $request->specie ?? '';
        $type = $request->type ?? '';

        
        $total = Lumber::
            leftJoin('types','lumbers.type_id','=','types.id')
            ->leftJoin('species','lumbers.specie_id','=','species.id')            
            ->where('lumbers.description','like',$description.'%')        
            ->where('species.name', 'like', $specie.'%')
            ->where('types.name','like', $type.'%')
            ->count();

        $lumbers = Lumber::              
            select(
                'lumbers.id',                
                'lumbers.width',
                'lumbers.high',
                'lumbers.density',
//                'lumbers.description',
                'types.name as type',
                'species.name as specie'
            )
            ->leftJoin('types','lumbers.type_id','=','types.id')
            ->leftJoin('species','lumbers.specie_id','=','species.id')            
            //->where('lumbers.description','like',$description.'%')        
            ->where('species.name', 'like', $specie.'%')
            ->where('types.name','like', $type.'%')
			->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();
        
            $lumbers = Lumber::with(['type','specie'])
            ->whereHas('type', function($query) use ($type) {
                $query->where('name','like',$type.'%');
            })
            ->whereHas('specie', function($query) use ($specie){
                $query->where('name','like',$specie.'%');
            })
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();
            //return $lumbers->count();
            //dd($lumbers);
        //return $lumbers;
        return response()->json(
        [
            'lumbers' => $lumbers->toArray(),
            'total'=>$total,
        ]);
    }
}
