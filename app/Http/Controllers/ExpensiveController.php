<?php

namespace App\Http\Controllers;

use App\Expensive;
use Illuminate\Http\Request;

class ExpensiveController extends Controller
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

        $expenses = Expensive::where($conditions)
                                ->orderBy('name')
                                ->paginate($pagination_rows);
        return response()->json($expenses->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $expensive = new Expensive();
        $expensive->name = '';
        $expensive->description = '';
        $data = [
            'expensive'    =>  $expensive,
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
        //1 para operacion fallida
        $status = 1; 
        try {
            //code...
            $expensive = new Expensive();
            $expensive->name = $request->name;
            $expensive->description = $request->description;
            $expensive->save();
            $status =0;
        } catch (Exception $e) {
            //throw $th;
        }
        
        $data = [
            'status'    =>  $status,
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $expensive = Expensive::find($id);

        $data = [
            'expensive'    =>  $expensive,
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $expensive = Expensive::find($id);
        
        $data = [
            'expensive'    =>  $expensive,
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $expensive = Expensive::find($id);
        $expensive->name = $request->name;
        $expensive->description = $request->description;
        $expensive->save();

        $data = [
            'expensive'    =>  $expensive,
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $status = 1; 
        try {
            //code...
            $expensive = Expensive::find($id);
            $expensive->delete();
            $status =0;
        } catch (Exception $e) {
            //throw $th;
        }

        $data = [
            'status'    =>  $status,
        ];
        return response()->json($data);
    }
}
