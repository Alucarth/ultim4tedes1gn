<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = $request->order ?? 'asc';
        $pagination_rows = $request->pagination_rows ?? 10;               

        $package_conditions = [];
        $storage_conditions = [];        
        

        $code = $request->code ?? null;        
        $name = $request->name ?? null;        
        $storage = $request->storage ?? null;

        if ($code) {
            array_push($package_conditions, ['code','like',"%{$code}%"]);
        }
        if ($name) {
            array_push($package_conditions, ['name','like',"%{$name}%"]);
        }        
        if ($storage) {
            array_push($storage_conditions, ['name','like',"%{$storage}%"]);
        }        
        

        $storages = Package::with(['storage'])
                            ->where($package_conditions)
                            ->whereHas('storage', function ($query) use ($storage_conditions) {
                                $query->where($storage_conditions);
                            })                            
                            ->paginate($pagination_rows);
        $data = [
            'storages'   =>  $storages
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
        $package = new Package();
        $pivot = ['quantity'=>null];
        $data = [
            'package'  =>  $package,
            'pivot'    =>  $pivot,
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
        $package = new Package();
        $package->code = $request->package['code'];
        $package->name = $request->package['name'];
        $package->storage_id = $request->package['storage_id'];        
        $package->save();
        $lumbers = [];
        foreach($request->lumbers as $lumber) {            
            $lumbers[$lumber['id']] = [
                'quantity' => $lumber['quantity']
            ];
        }                
        $package->lumbers()->attach($lumbers);        
        return $package;        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }

    public function createTransfer(Request $request) {
        return 123;
    }
}
