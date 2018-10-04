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
    public function index(Request $request) {
                
        $order = $request->order ?? 'asc';
        $pagination_rows = $request->pagination_rows ?? 10;               

        $lumber_conditions = [];
        $type_conditions = [];
        $specie_conditions = [];

        $high = $request->high ?? null;
        $width = $request->width ?? null;
        $density = $request->density ?? null;
        $description = $request->description ?? null;
        $specie = $request->specie ?? null;
        $type = $request->type ?? null;

        if ($high) {
            array_push($lumber_conditions, ['high','=',"{$high}"]);
        }
        if ($width) {
            array_push($lumber_conditions, ['width','=',"{$width}"]);
        }
        if ($density) {
            array_push($lumber_conditions, ['density','=',"{$density}"]);
        }
        if ($description) {
            array_push($lumber_conditions, ['description','like',"%{$description}%"]);
        }
        if ($specie) {
            array_push($specie_conditions, ['name','like',"%{$specie}%"]);
        }
        if ($type) {
            array_push($type_conditions, ['name','like',"%{$type}%"]);
        }

        $lumbers = Lumber::with(['specie','type'])
                            ->where($lumber_conditions)
                            ->whereHas('specie', function ($query) use ($specie_conditions) {
                                $query->where($specie_conditions);
                            })
                            ->whereHas('type', function ($query) use ($type_conditions) {
                                $query->where($type_conditions);
                            })
                            ->paginate($pagination_rows);
        $data = [
            'lumbers'   =>  $lumbers
        ];
        return response()->json($lumbers);    
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
        $lumber = new Lumber();
        $lumber->high = $request->high;
        $lumber->width = $request->width;
        $lumber->density = $request->density;
        $lumber->description = $request->description;
        $lumber->specie_id = $request->specie_id;
        $lumber->type_id = $request->type_id;
        $lumber->save();
                
        $data = [
            'lumber' => $lumber
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
        $lumber = Lumber::with(['specie','type'])->find($id);
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
        $lumber = Lumber::with(['specie', 'type'])->find($id);        
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
}
