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
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function show(Expensive $expensive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function edit(Expensive $expensive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expensive $expensive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expensive  $expensive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expensive $expensive)
    {
        //
    }
}
