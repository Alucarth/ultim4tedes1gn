<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Storage;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storages = Storage::get();

        $data = [
            'storages'  =>  $storages
        ];
        return response()->json($storages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storage = new Storage();
        $data = [
            'storage'    =>  $storage,
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
        $storage = new Storage();
        $storage->name = $request->name;
        $storage->description = $request->description;
        $storage->is_enabled = $request->is_enabled;
        $storage->save();
        
        $data = [
            'storage'    =>  $storage
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
        $storage = Storage::find($id);
        
        $data = [
            'storage'  =>  $storage
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
        $storage = Storage::find($id);
        
        $data = [
            'storage'  =>  $storage
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
        $storage = Storage::find($id);
        $storage->name = $request->name;
        $storage->description = $request->description;
        $storage->is_enabled = $request->is_enabled;
        $storage->save();
        
        $data = [
            'storage'    =>  $storage
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
        $storage = Storage::find($id);
        $data = [
            'storage_id'    =>  $storage->id
        ];
        $storage->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from lumber
     * 
     * @param int $id
     * @return \App\Storage[] $storages 
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';  
        
        $name = $request->name ?? '';
        $description = $request->description ?? '';
                
        $total = Storage::
            where('name','like',$name.'%')
            //where('description','like',$description.'%')
            ->count();

        $storages = Storage::
            where('name','like',$name.'%')
//            ->where('description','like',$description.'%')
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();
            
        return response()->json(
        [
            'storages' => $storages->toArray(),
            'total'=>$total,
        ]);
    }
}
